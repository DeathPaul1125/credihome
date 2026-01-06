<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        if ($request->filled('prestamo_id')) {
            $prestamo = Prestamo::with('cliente')->find($request->prestamo_id);
        }

        // Obtener préstamos activos
        $prestamos = Prestamo::with('cliente')
            ->whereIn('estado', ['activo', 'en_mora', 'vencido'])
            ->orderBy('fecha_desembolso', 'desc')
            ->get();

        return view('pagos.create-flowbite', compact('prestamos', 'prestamo'));
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
            'observaciones' => 'nullable|string',
        ]);

        $prestamo = Prestamo::findOrFail($validated['prestamo_id']);

        // Verificar que el préstamo esté activo
        if (!in_array($prestamo->estado, ['activo', 'en_mora', 'vencido'])) {
            return back()->with('error', 'Este préstamo no está activo.');
        }

        // Calcular número de cuota
        $numeroCuota = $prestamo->cuotas_pagadas + 1;

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

        return redirect()->route('prestamos.show', $prestamo)
            ->with('success', 'Pago registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pago $pago)
    {
        $pago->load(['prestamo.cliente', 'usuario']);

        return view('pagos.show-flowbite', compact('pago'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pago $pago)
    {
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
        $pago->delete();

        return redirect()->route('prestamos.show', $prestamo)
            ->with('success', 'Pago eliminado exitosamente.');
    }
}
