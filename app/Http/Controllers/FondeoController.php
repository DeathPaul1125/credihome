<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Aportador;
use App\Models\Aportacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FondeoController extends Controller
{
    /**
     * Mostrar préstamos pendientes de fondeo
     */
    public function index(Request $request)
    {
        $query = Prestamo::with(['cliente', 'usuario', 'aportaciones.aportador'])
            ->whereIn('estado', ['pendiente', 'pendiente_fondeo'])
            ->latest();

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero_prestamo', 'like', "%{$search}%")
                  ->orWhereHas('cliente', function($q2) use ($search) {
                      $q2->where('nombre_completo', 'like', "%{$search}%");
                  });
            });
        }

        $prestamos = $query->paginate(15);

        // Calcular información de fondeo para cada préstamo
        foreach ($prestamos as $prestamo) {
            $prestamo->monto_fondeado = $prestamo->aportaciones->sum('monto_aportado');
            $prestamo->porcentaje_fondeo = $prestamo->monto_prestado > 0
                ? ($prestamo->monto_fondeado / $prestamo->monto_prestado) * 100
                : 0;
            $prestamo->monto_faltante = $prestamo->monto_prestado - $prestamo->monto_fondeado;
        }

        return view('fondeo.index', compact('prestamos'));
    }

    /**
     * Mostrar formulario de fondeo para un préstamo específico
     */
    public function gestionar(Prestamo $prestamo)
    {
        // Verificar que el préstamo está pendiente de fondeo
        if (!in_array($prestamo->estado, ['pendiente', 'pendiente_fondeo'])) {
            return redirect()->route('fondeo.index')
                ->with('error', 'Este préstamo ya no está pendiente de fondeo.');
        }

        $prestamo->load(['cliente', 'aportaciones.aportador']);

        // Calcular el fondeo actual
        $montoFondeado = $prestamo->aportaciones->sum('monto_aportado');
        $montoFaltante = $prestamo->monto_prestado - $montoFondeado;
        $porcentajeFondeo = $prestamo->monto_prestado > 0
            ? ($montoFondeado / $prestamo->monto_prestado) * 100
            : 0;

        // Obtener aportadores activos con capital disponible
        $aportadores = Aportador::where('estado', 'activo')
            ->where('capital_disponible', '>', 0)
            ->orderBy('nombre')
            ->get();

        return view('fondeo.gestionar', compact(
            'prestamo',
            'aportadores',
            'montoFondeado',
            'montoFaltante',
            'porcentajeFondeo'
        ));
    }

    /**
     * Agregar aportación a un préstamo
     */
    public function agregarAportacion(Request $request, Prestamo $prestamo)
    {
        $validated = $request->validate([
            'aportador_id' => 'required|exists:aportadores,id',
            'monto_aportado' => 'required|numeric|min:0.01',
        ]);

        // Verificar que el préstamo está pendiente de fondeo
        if (!in_array($prestamo->estado, ['pendiente', 'pendiente_fondeo'])) {
            return back()->with('error', 'Este préstamo ya no está pendiente de fondeo.');
        }

        $aportador = Aportador::find($validated['aportador_id']);

        // Validar que el aportador tiene capital suficiente
        if ($aportador->capital_disponible < $validated['monto_aportado']) {
            return back()->withErrors([
                'monto_aportado' => "El aportador {$aportador->nombre} solo tiene Q" . number_format($aportador->capital_disponible, 2) . " disponible."
            ])->withInput();
        }

        // Calcular el monto actualmente fondeado
        $montoFondeado = $prestamo->aportaciones->sum('monto_aportado');
        $montoFaltante = $prestamo->monto_prestado - $montoFondeado;

        // Validar que no se exceda el monto del préstamo
        if ($validated['monto_aportado'] > $montoFaltante) {
            return back()->withErrors([
                'monto_aportado' => "El monto excede lo que falta por fondear (Q" . number_format($montoFaltante, 2) . ")."
            ])->withInput();
        }

        DB::beginTransaction();
        try {
            // Crear la aportación
            $aportacion = new Aportacion();
            $aportacion->aportador_id = $validated['aportador_id'];
            $aportacion->prestamo_id = $prestamo->id;
            $aportacion->monto_aportado = $validated['monto_aportado'];
            $aportacion->porcentaje_participacion = ($validated['monto_aportado'] / $prestamo->monto_prestado) * 100;
            $aportacion->saldo_pendiente = $validated['monto_aportado'];
            $aportacion->fecha_aportacion = now();
            $aportacion->estado = 'activo';
            $aportacion->save();

            // Actualizar capital del aportador
            $aportador->capital_disponible -= $validated['monto_aportado'];
            $aportador->capital_invertido += $validated['monto_aportado'];
            $aportador->save();

            // Actualizar estado del préstamo a pendiente_fondeo si aún no lo está
            if ($prestamo->estado === 'pendiente') {
                $prestamo->estado = 'pendiente_fondeo';
                $prestamo->save();
            }

            // Verificar si el fondeo está completo y aprobar automáticamente
            $nuevoMontoFondeado = $prestamo->aportaciones()->sum('monto_aportado');
            if (abs($nuevoMontoFondeado - $prestamo->monto_prestado) < 0.01) {
                Log::info("Préstamo {$prestamo->numero_prestamo} completamente fondeado, aprobando automáticamente");

                $prestamo->estado = 'activo';
                $prestamo->aprobado_en = now();
                $prestamo->aprobado_por = auth()->id();
                $prestamo->save();

                DB::commit();

                return redirect()->route('fondeo.index')
                    ->with('success', "¡Aportación agregada! El préstamo ha sido fondeado completamente y aprobado automáticamente.");
            }

            DB::commit();

            $porcentajeFondeo = ($nuevoMontoFondeado / $prestamo->monto_prestado) * 100;
            return back()->with('success', "Aportación agregada exitosamente. Fondeo actual: " . number_format($porcentajeFondeo, 2) . "%");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al agregar aportación: ' . $e->getMessage());
            return back()->with('error', 'Error al agregar la aportación: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar una aportación
     */
    public function eliminarAportacion(Prestamo $prestamo, Aportacion $aportacion)
    {
        // Verificar que la aportación pertenece al préstamo
        if ($aportacion->prestamo_id !== $prestamo->id) {
            return back()->with('error', 'La aportación no pertenece a este préstamo.');
        }

        // Verificar que el préstamo está pendiente de fondeo
        if (!in_array($prestamo->estado, ['pendiente', 'pendiente_fondeo'])) {
            return back()->with('error', 'No se pueden eliminar aportaciones de un préstamo activo.');
        }

        // Verificar que no hay pagos realizados
        if ($prestamo->pagos()->count() > 0) {
            return back()->with('error', 'No se puede eliminar la aportación porque el préstamo ya tiene pagos registrados.');
        }

        DB::beginTransaction();
        try {
            $aportador = $aportacion->aportador;
            $monto = $aportacion->monto_aportado;

            // La eliminación de la aportación ya devuelve el capital automáticamente
            // gracias al listener en el modelo Aportacion
            $aportacion->delete();

            DB::commit();

            return back()->with('success', "Aportación eliminada. Se devolvieron Q" . number_format($monto, 2) . " a {$aportador->nombre}.");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar aportación: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar la aportación: ' . $e->getMessage());
        }
    }

    /**
     * Aprobar manualmente un préstamo fondeado
     */
    public function aprobar(Prestamo $prestamo)
    {
        // Verificar que el préstamo está pendiente de fondeo
        if (!in_array($prestamo->estado, ['pendiente', 'pendiente_fondeo'])) {
            return back()->with('error', 'Este préstamo ya no está pendiente de fondeo.');
        }

        // Verificar que el fondeo está completo
        $montoFondeado = $prestamo->aportaciones->sum('monto_aportado');
        if (abs($montoFondeado - $prestamo->monto_prestado) > 0.01) {
            $porcentaje = ($montoFondeado / $prestamo->monto_prestado) * 100;
            return back()->with('error', "El préstamo solo está fondeado al " . number_format($porcentaje, 2) . "%. Debe estar al 100% para aprobar.");
        }

        DB::beginTransaction();
        try {
            $prestamo->estado = 'activo';
            $prestamo->aprobado_en = now();
            $prestamo->aprobado_por = auth()->id();
            $prestamo->save();

            DB::commit();

            return redirect()->route('fondeo.index')
                ->with('success', "Préstamo {$prestamo->numero_prestamo} aprobado exitosamente.");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al aprobar préstamo: ' . $e->getMessage());
            return back()->with('error', 'Error al aprobar el préstamo: ' . $e->getMessage());
        }
    }
}
