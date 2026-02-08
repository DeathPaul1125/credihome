<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Prestamo;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pago::with(['prestamo.cliente', 'usuario'])->latest('fecha_pago');

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero_recibo', 'like', "%{$search}%")
                  ->orWhereHas('cliente', function($q2) use ($search) {
                      $q2->where('nombre_completo', 'like', "%{$search}%");
                  })
                  ->orWhereHas('prestamo', function($q2) use ($search) {
                      $q2->where('numero_prestamo', 'like', "%{$search}%");
                  });
            });
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtro por fecha
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_pago', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_pago', '<=', $request->fecha_hasta);
        }

        $pagos = $query->paginate(20);

        return view('pagos.index-flowbite', compact('pagos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $prestamo = null;
        $numeroCuota = null;
        $cuotaPendiente = null;
        $tablaAmortizacion = null;
        $numeroRecibo = null;

        if ($request->filled('prestamo_id')) {
            $prestamo = Prestamo::with('cliente')->find($request->prestamo_id);

            if ($prestamo) {
                // Generar tabla de amortización
                $tablaAmortizacion = $prestamo->generarTablaAmortizacion();

                // Si viene un número de cuota específico
                if ($request->filled('numero_cuota')) {
                    $numeroCuota = $request->numero_cuota;
                    // Buscar esa cuota en la tabla
                    $cuotaPendiente = collect($tablaAmortizacion)->firstWhere('numero_cuota', $numeroCuota);
                } else {
                    // Buscar primera cuota pendiente o vencida
                    $cuotaPendiente = collect($tablaAmortizacion)->first(function ($cuota) {
                        return in_array($cuota['estado'], ['pendiente', 'vencida']);
                    });

                    if ($cuotaPendiente) {
                        $numeroCuota = $cuotaPendiente['numero_cuota'];
                    }
                }

                // Generar número de recibo automático
                $numeroRecibo = $this->generarNumeroRecibo();
            }
        }

        // Obtener préstamos activos
        $prestamos = Prestamo::with('cliente')
            ->whereIn('estado', ['activo', 'en_mora', 'vencido'])
            ->orderBy('fecha_desembolso', 'desc')
            ->get();

        return view('pagos.create-flowbite', compact('prestamos', 'prestamo', 'numeroCuota', 'cuotaPendiente', 'tablaAmortizacion', 'numeroRecibo'));
    }

    /**
     * Generar número de recibo automático
     */
    private function generarNumeroRecibo()
    {
        $anio = date('Y');

        // Obtener el último recibo del año actual
        $ultimoPago = Pago::whereYear('created_at', $anio)
            ->whereNotNull('numero_recibo')
            ->orderBy('id', 'desc')
            ->first();

        if ($ultimoPago && $ultimoPago->numero_recibo) {
            // Extraer el número del recibo (formato: REC-YYYY-NNNNN)
            preg_match('/REC-\d{4}-(\d+)/', $ultimoPago->numero_recibo, $matches);
            $ultimoNumero = isset($matches[1]) ? (int)$matches[1] : 0;
            $nuevoNumero = $ultimoNumero + 1;
        } else {
            $nuevoNumero = 1;
        }

        return 'REC-' . $anio . '-' . str_pad($nuevoNumero, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'prestamo_id' => 'required|exists:prestamos,id',
            'monto_pagado' => 'required|numeric|min:0.01',
            'fecha_pago' => 'required|date',
            'tipo_pago' => 'required|in:efectivo,transferencia,cheque,deposito',
            'numero_recibo' => 'nullable|string|max:50|unique:pagos,numero_recibo',
            'observaciones' => 'nullable|string',
            'numero_cuota' => 'nullable|integer|min:1',
        ]);

        $prestamo = Prestamo::findOrFail($validated['prestamo_id']);

        // Verificar que el préstamo esté activo
        if (!in_array($prestamo->estado, ['activo', 'en_mora', 'vencido'])) {
            return back()->with('error', 'Este préstamo no está activo.');
        }

        // Usar número de cuota proporcionado o calcular automáticamente
        if (isset($validated['numero_cuota'])) {
            $numeroCuota = $validated['numero_cuota'];
        } else {
            $numeroCuota = $prestamo->cuotas_pagadas + 1;
        }

        // Calcular fecha de vencimiento de esta cuota
        $fechaBase = Carbon::parse($prestamo->fecha_primer_pago);
        switch ($prestamo->frecuencia_pago) {
            case 'semanal':
                $fechaVencimiento = $fechaBase->copy()->addWeeks($numeroCuota - 1);
                break;
            case 'quincenal':
                $fechaVencimiento = $fechaBase->copy()->addWeeks(($numeroCuota - 1) * 2);
                break;
            case 'mensual':
                $fechaVencimiento = $fechaBase->copy()->addMonths($numeroCuota - 1);
                break;
            default:
                $fechaVencimiento = $fechaBase;
        }

        // Calcular mora si hay atraso
        $fechaPago = Carbon::parse($validated['fecha_pago']);
        $diasAtraso = max(0, $fechaPago->diffInDays($fechaVencimiento, false) * -1);
        $mora = Pago::calcularMora($prestamo->monto_cuota, $diasAtraso);

        $pago = new Pago([
            'prestamo_id' => $validated['prestamo_id'],
            'cliente_id' => $prestamo->cliente_id,
            'numero_cuota' => $numeroCuota,
            'numero_recibo' => $validated['numero_recibo'] ?? null,
            'monto_cuota_esperado' => $prestamo->monto_cuota,
            'monto_pagado' => $validated['monto_pagado'],
            'mora' => $mora,
            'fecha_vencimiento' => $fechaVencimiento,
            'fecha_pago' => $validated['fecha_pago'],
            'tipo_pago' => $validated['tipo_pago'],
            'saldo_anterior' => $prestamo->saldo_pendiente,
            'saldo_nuevo' => $prestamo->saldo_pendiente - $validated['monto_pagado'],
            'observaciones' => $validated['observaciones'] ?? null,
            'user_id' => Auth::id(),
        ]);

        $pago->save();

        // Registrar en auditoría
        ActivityLog::log(
            'Pago creado',
            $pago,
            [
                'prestamo_id' => $prestamo->id,
                'numero_prestamo' => $prestamo->numero_prestamo,
                'cliente' => $prestamo->cliente->nombre_completo,
                'monto' => $pago->monto_pagado,
                'metodo' => $pago->tipo_pago,
            ],
            'pagos'
        );

        return redirect()->route('prestamos.show', $prestamo)
            ->with('success', 'Pago registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pago $pago)
    {
        $pago->load(['prestamo.cliente', 'usuario']);

        // Cargar historial de auditoría
        $activityLogs = ActivityLog::where('subject_type', Pago::class)
            ->where('subject_id', $pago->id)
            ->with('causer')
            ->latest()
            ->get();

        return view('pagos.show-flowbite', compact('pago', 'activityLogs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pago $pago)
    {
        // Verificar permiso
        if (!Auth::user()->can('eliminar-pagos')) {
            return back()->with('error', 'No tiene permisos para editar pagos.');
        }

        $pago->load(['prestamo.cliente']);

        return view('pagos.edit-flowbite', compact('pago'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pago $pago)
    {
        // Verificar permiso
        if (!Auth::user()->can('eliminar-pagos')) {
            return back()->with('error', 'No tiene permisos para editar pagos.');
        }

        $validated = $request->validate([
            'monto_pagado' => 'required|numeric|min:0.01',
            'fecha_pago' => 'required|date',
            'tipo_pago' => 'required|in:efectivo,transferencia,cheque,deposito',
            'observaciones' => 'nullable|string',
        ]);

        // Guardar valores anteriores para auditoría
        $valoresAnteriores = [
            'monto_pagado' => $pago->monto_pagado,
            'fecha_pago' => $pago->fecha_pago->format('Y-m-d'),
            'tipo_pago' => $pago->tipo_pago,
            'observaciones' => $pago->observaciones,
        ];

        // Actualizar el pago
        $pago->update($validated);

        // Registrar en auditoría
        ActivityLog::log(
            'Pago editado',
            $pago,
            [
                'antes' => $valoresAnteriores,
                'despues' => $validated,
                'prestamo' => $pago->prestamo->numero_prestamo,
                'cliente' => $pago->prestamo->cliente->nombre_completo,
            ],
            'pagos'
        );

        return redirect()->route('pagos.show', $pago)
            ->with('success', 'Pago actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pago $pago)
    {
        // Verificar permiso
        if (!Auth::user()->can('eliminar-pagos')) {
            return back()->with('error', 'No tiene permisos para eliminar pagos.');
        }

        // Solo permitir eliminar el último pago
        $ultimoPago = $pago->prestamo->pagos()->latest('id')->first();

        if ($pago->id !== $ultimoPago->id) {
            return back()->with('error', 'Solo se puede eliminar el último pago registrado.');
        }

        // Revertir cambios en el préstamo
        $prestamo = $pago->prestamo;
        $prestamo->total_pagado -= $pago->monto_pagado;
        $prestamo->saldo_pendiente += $pago->monto_pagado;
        $prestamo->cuotas_pagadas = max(0, $prestamo->cuotas_pagadas - 1);

        if ($pago->estado === 'atrasado') {
            $prestamo->cuotas_vencidas++;
        }

        // Actualizar estado
        if ($prestamo->cuotas_vencidas > 2) {
            $prestamo->estado = 'vencido';
        } elseif ($prestamo->cuotas_vencidas > 0) {
            $prestamo->estado = 'en_mora';
        } else {
            $prestamo->estado = 'activo';
        }

        $prestamo->save();

        // Registrar en auditoría antes de eliminar
        ActivityLog::log(
            'Pago eliminado',
            $pago,
            [
                'numero_recibo' => $pago->numero_recibo,
            ],
            'pagos'
        );

        // Eliminar distribuciones del pago si existen
        \App\Models\DistribucionPago::where('pago_id', $pago->id)->delete();

        $pago->delete();

        // Recalcular estadísticas de aportadores automáticamente
        $this->recalcularAportadoresAutomatico();

        return redirect()->route('prestamos.show', $prestamo)
            ->with('success', 'Pago eliminado exitosamente. Estadísticas de aportadores actualizadas.');
    }

    /**
     * Recalcular aportadores automáticamente (método interno)
     */
    private function recalcularAportadoresAutomatico()
    {
        try {
            $aportadores = \App\Models\Aportador::all();

            foreach ($aportadores as $aportador) {
                $aportacionesActivas = \App\Models\Aportacion::where('aportador_id', $aportador->id)
                    ->whereIn('estado', ['Activo', 'Recuperado'])
                    ->get();

                $aportador->capital_invertido = $aportacionesActivas->sum('monto_aportado');
                $aportador->capital_recuperado = $aportacionesActivas->sum('monto_recuperado');
                $aportador->ganancias_totales = $aportacionesActivas->sum('intereses_ganados');
                $aportador->save();
            }
        } catch (\Exception $e) {
            \Log::error('Error al recalcular aportadores automáticamente: ' . $e->getMessage());
        }
    }

    /**
     * Generar recibo PDF del pago
     */
    public function recibo(Pago $pago)
    {
        // Validar que el pago no esté pendiente o rechazado antes de generar el recibo
        if (in_array($pago->estado, ['pendiente', 'rechazado'])) {
            return redirect()->back()->with('error', 'No se puede generar recibo de pagos pendientes o rechazados.');
        }

        $pago->load(['prestamo.cliente', 'usuario']);

        $pdf = Pdf::loadView('pagos.recibo-pdf', compact('pago'));
        $pdf->setPaper('letter');

        return $pdf->stream('recibo-pago-' . ($pago->numero_recibo ?? 'pago-' . $pago->id) . '.pdf');
    }
}
