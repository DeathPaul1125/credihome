<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ComprobantePago;
use App\Models\Pago;
use App\Models\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ComprobantePagoController extends Controller
{
    public function index(Request $request)
    {
        $query = ComprobantePago::with(['prestamo.cliente', 'cliente', 'validador'])
            ->orderBy('created_at', 'desc');

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtro solo pendientes por defecto
        if (!$request->filled('estado')) {
            $query->where('estado', 'pendiente');
        }

        $comprobantes = $query->paginate(20);

        return view('admin.comprobantes.index', compact('comprobantes'));
    }

    public function show($id)
    {
        $comprobante = ComprobantePago::with([
            'prestamo.cliente',
            'cliente',
            'validador',
            'pago'
        ])->findOrFail($id);

        return view('admin.comprobantes.show', compact('comprobante'));
    }

    public function aprobar(Request $request, $id)
    {
        $request->validate([
            'monto_pagado' => 'required|numeric|min:0.01',
            'fecha_pago' => 'required|date',
            'notas' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            $comprobante = ComprobantePago::findOrFail($id);

            if ($comprobante->estado !== 'pendiente') {
                return back()->with('error', 'Este comprobante ya fue procesado.');
            }

            // Verificar si ya existe un pago asociado a este comprobante
            if ($comprobante->pago_id) {
                return back()->with('error', 'Este comprobante ya tiene un pago asociado.');
            }

            // Obtener el préstamo con su tabla de amortización
            $prestamo = Prestamo::findOrFail($comprobante->prestamo_id);
            $tablaAmortizacion = $prestamo->generarTablaAmortizacion();

            // Buscar la próxima cuota pendiente
            $cuotaPendiente = collect($tablaAmortizacion)->first(function ($cuota) {
                return $cuota['estado'] === 'pendiente' || $cuota['estado'] === 'vencida';
            });

            if (!$cuotaPendiente) {
                return back()->with('error', 'No hay cuotas pendientes para este préstamo.');
            }

            // Verificar si ya existe un pago para esta cuota
            $pagoExistente = Pago::where('prestamo_id', $comprobante->prestamo_id)
                ->where('numero_cuota', $cuotaPendiente['numero_cuota'])
                ->first();

            if ($pagoExistente) {
                return back()->with('error', 'Ya existe un pago registrado para la cuota #' . $cuotaPendiente['numero_cuota'] . '.');
            }

            // Crear el pago con toda la información de la cuota
            $pago = Pago::create([
                'prestamo_id' => $comprobante->prestamo_id,
                'cliente_id' => $comprobante->cliente_id,
                'numero_cuota' => $cuotaPendiente['numero_cuota'],
                'monto_cuota_esperado' => $cuotaPendiente['cuota'],
                'monto_pagado' => $request->monto_pagado,
                'fecha_vencimiento' => $cuotaPendiente['fecha_vencimiento'],
                'fecha_pago' => $request->fecha_pago,
                'saldo_anterior' => $cuotaPendiente['saldo_anterior'],
                'saldo_nuevo' => max(0, $cuotaPendiente['saldo_anterior'] - $request->monto_pagado),
                'observaciones' => $request->notas,
                'user_id' => auth()->id(),
            ]);

            // Actualizar el comprobante
            $comprobante->update([
                'estado' => 'aprobado',
                'validado_por' => auth()->id(),
                'fecha_validacion' => now(),
                'pago_id' => $pago->id,
                'notas_validacion' => $request->notas,
            ]);

            // Actualizar el préstamo
            $prestamo = Prestamo::findOrFail($comprobante->prestamo_id);
            $prestamo->saldo_pendiente -= $request->monto_pagado;

            if ($prestamo->saldo_pendiente <= 0) {
                $prestamo->estado = 'pagado';
                $prestamo->saldo_pendiente = 0;
            }

            $prestamo->save();

            DB::commit();

            return redirect()->route('admin.comprobantes.index')
                ->with('success', 'Comprobante aprobado y pago registrado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al aprobar el comprobante: ' . $e->getMessage());
        }
    }

    public function rechazar(Request $request, $id)
    {
        $request->validate([
            'motivo_rechazo' => 'required|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            $comprobante = ComprobantePago::findOrFail($id);

            if ($comprobante->estado !== 'pendiente') {
                return back()->with('error', 'Este comprobante ya fue procesado.');
            }

            $comprobante->update([
                'estado' => 'rechazado',
                'validado_por' => auth()->id(),
                'fecha_validacion' => now(),
                'motivo_rechazo' => $request->motivo_rechazo,
            ]);

            DB::commit();

            return redirect()->route('admin.comprobantes.index')
                ->with('success', 'Comprobante rechazado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al rechazar el comprobante: ' . $e->getMessage());
        }
    }
}
