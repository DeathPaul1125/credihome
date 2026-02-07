<?php

namespace App\Http\Controllers;

use App\Models\Aportacion;
use App\Models\Aportador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AportacionController extends Controller
{
    /**
     * Mostrar formulario de edición de aportación
     */
    public function edit(Aportacion $aportacion)
    {
        $aportacion->load(['aportador', 'prestamo.cliente']);

        return view('aportaciones.edit', compact('aportacion'));
    }

    /**
     * Actualizar una aportación
     */
    public function update(Request $request, Aportacion $aportacion)
    {
        $validated = $request->validate([
            'monto_aportado' => 'required|numeric|min:0.01',
            'porcentaje_participacion' => 'required|numeric|min:0|max:100',
            'monto_recuperado' => 'nullable|numeric|min:0',
            'intereses_ganados' => 'nullable|numeric|min:0',
            'estado' => 'required|in:Activo,Recuperado,Cancelado',
            'notas' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $montoAnterior = $aportacion->monto_aportado;
            $recuperadoAnterior = $aportacion->monto_recuperado;
            $interesesAnteriores = $aportacion->intereses_ganados;

            // Actualizar la aportación
            $aportacion->update($validated);

            // Recalcular saldo pendiente
            $aportacion->saldo_pendiente = $aportacion->monto_aportado - $aportacion->monto_recuperado;
            $aportacion->save();

            // Actualizar datos del aportador
            $aportador = $aportacion->aportador;

            // Ajustar capital invertido
            $diferenciaInvertido = $validated['monto_aportado'] - $montoAnterior;
            $aportador->capital_invertido += $diferenciaInvertido;

            // Ajustar capital recuperado
            $diferenciaRecuperado = ($validated['monto_recuperado'] ?? 0) - $recuperadoAnterior;
            $aportador->capital_recuperado += $diferenciaRecuperado;

            // Ajustar ganancias
            $diferenciaGanancias = ($validated['intereses_ganados'] ?? 0) - $interesesAnteriores;
            $aportador->ganancias_totales += $diferenciaGanancias;

            $aportador->save();

            DB::commit();

            return redirect()->route('aportadores.show', $aportacion->aportador_id)
                ->with('success', 'Aportación actualizada exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error al actualizar aportación: ' . $e->getMessage());
            return back()->with('error', 'Error al actualizar la aportación: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Recalcular una aportación específica desde el préstamo
     */
    public function recalcular(Aportacion $aportacion)
    {
        try {
            $prestamo = $aportacion->prestamo;

            // Recalcular desde las distribuciones de pagos
            $distribuciones = $aportacion->distribucionesPagos;

            $montoRecuperado = $distribuciones->sum('monto_capital');
            $interesesGanados = $distribuciones->sum('monto_interes');

            $aportacion->monto_recuperado = $montoRecuperado;
            $aportacion->intereses_ganados = $interesesGanados;
            $aportacion->saldo_pendiente = $aportacion->monto_aportado - $montoRecuperado;

            if ($aportacion->saldo_pendiente <= 0.01 && $aportacion->estado === 'Activo') {
                $aportacion->marcarComoRecuperado();
            }

            $aportacion->save();

            // Recalcular aportador
            $this->recalcularAportador($aportacion->aportador_id);

            return back()->with('success', 'Aportación recalculada exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error al recalcular aportación: ' . $e->getMessage());
            return back()->with('error', 'Error al recalcular la aportación: ' . $e->getMessage());
        }
    }

    /**
     * Recalcular todas las aportaciones de un aportador
     */
    private function recalcularAportador($aportadorId)
    {
        $aportador = Aportador::find($aportadorId);

        if ($aportador) {
            $aportacionesActivas = Aportacion::where('aportador_id', $aportadorId)
                ->whereIn('estado', ['Activo', 'Recuperado'])
                ->get();

            $aportador->capital_invertido = $aportacionesActivas->sum('monto_aportado');
            $aportador->capital_recuperado = $aportacionesActivas->sum('monto_recuperado');
            $aportador->ganancias_totales = $aportacionesActivas->sum('intereses_ganados');
            $aportador->save();
        }
    }
}
