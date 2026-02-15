<?php

namespace App\Http\Controllers;

use App\Models\Aportador;
use App\Models\Aportacion;
use App\Models\DistribucionPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AportadorController extends Controller
{
    /**
     * Dashboard de aportadores con estadísticas generales
     */
    public function dashboard()
    {
        $aportadores = Aportador::with(['aportaciones', 'aportacionesActivas'])->get();

        // Estadísticas globales
        $stats = [
            'total_aportadores' => Aportador::count(),
            'aportadores_activos' => Aportador::where('estado', 'Activo')->count(),
            'capital_total_sistema' => Aportador::sum('capital_disponible') + Aportador::sum('capital_invertido'),
            'capital_disponible' => Aportador::sum('capital_disponible'),
            'capital_invertido' => Aportador::sum('capital_invertido'),
            'capital_recuperado' => Aportador::sum('capital_recuperado'),
            'ganancias_totales' => Aportador::sum('ganancias_totales'),
            'prestamos_fondeados' => Aportacion::distinct('prestamo_id')->count(),
        ];

        // ROI promedio del sistema
        $stats['roi_promedio'] = $stats['capital_recuperado'] > 0
            ? ($stats['ganancias_totales'] / $stats['capital_recuperado']) * 100
            : 0;

        // Aportadores ordenados por capital total
        $topAportadores = Aportador::select('*')
            ->selectRaw('(capital_disponible + capital_invertido + capital_recuperado) as capital_total')
            ->orderByDesc('capital_total')
            ->limit(10)
            ->get();

        // Distribuciones recientes
        $distribucionesRecientes = DistribucionPago::with(['aportador', 'pago.prestamo.cliente'])
            ->orderByDesc('fecha_distribucion')
            ->limit(20)
            ->get();

        // Datos para gráfico de evolución mensual
        $evolucionMensual = DistribucionPago::select(
            DB::raw('DATE_FORMAT(fecha_distribucion, "%Y-%m") as mes'),
            DB::raw('SUM(monto_capital) as capital'),
            DB::raw('SUM(monto_interes) as intereses'),
            DB::raw('SUM(monto_total) as total')
        )
        ->groupBy('mes')
        ->orderBy('mes', 'desc')
        ->limit(12)
        ->get()
        ->reverse();

        return view('aportadores.dashboard', compact('stats', 'aportadores', 'topAportadores', 'distribucionesRecientes', 'evolucionMensual'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Aportador::query()->latest();

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('dpi', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('empresa', 'like', "%{$search}%");
            });
        }

        // Filtro por tipo
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $aportadores = $query->paginate(15);

        return view('aportadores.index', compact('aportadores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('aportadores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'dpi' => 'nullable|string|size:13|unique:aportadores,dpi',
            'email' => 'nullable|email|unique:aportadores,email',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:500',
            'tipo' => 'required|in:Persona,Empresa,Institución',
            'empresa' => 'nullable|string|max:255',
            'nit' => 'nullable|string|max:20',
            'capital_disponible' => 'required|numeric|min:0',
            'tasa_interes_minima' => 'nullable|numeric|min:0|max:100',
            'plazo_maximo' => 'nullable|integer|min:1|max:120',
            'monto_minimo_prestamo' => 'nullable|numeric|min:0',
            'monto_maximo_prestamo' => 'nullable|numeric|min:0',
            'estado' => 'required|in:Activo,Inactivo,Suspendido',
            'notas' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['usuario_id'] = Auth::id();

        Aportador::create($data);

        return redirect()->route('aportadores.index')
            ->with('success', 'Aportador registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Aportador $aportador)
    {
        $aportador->load(['aportaciones.prestamo.cliente', 'distribucionesPagos.pago']);

        // Estadísticas del aportador
        $stats = [
            'total_aportado' => $aportador->capital_invertido + $aportador->capital_recuperado,
            'prestamos_activos' => $aportador->aportacionesActivas()->count(),
            'prestamos_totales' => $aportador->aportaciones()->count(),
            'roi' => $aportador->getRoiAttribute(),
        ];

        // Aportaciones activas
        $aportacionesActivas = $aportador->aportacionesActivas()
            ->with('prestamo.cliente')
            ->get();

        // Aportaciones recuperadas
        $aportacionesRecuperadas = $aportador->aportaciones()
            ->where('estado', 'Recuperado')
            ->with('prestamo.cliente')
            ->get();

        // Historial de distribuciones
        $distribucionesPagos = $aportador->distribucionesPagos()
            ->with(['pago.prestamo.cliente', 'aportacion'])
            ->orderByDesc('fecha_distribucion')
            ->paginate(20);

        // Evolución mensual del aportador
        $evolucion = DistribucionPago::where('aportador_id', $aportador->id)
            ->select(
                DB::raw('DATE_FORMAT(fecha_distribucion, "%Y-%m") as mes'),
                DB::raw('SUM(monto_capital) as capital'),
                DB::raw('SUM(monto_interes) as intereses'),
                DB::raw('SUM(monto_total) as total')
            )
            ->groupBy('mes')
            ->orderBy('mes', 'desc')
            ->limit(12)
            ->get()
            ->reverse();

        return view('aportadores.show', compact('aportador', 'stats', 'aportacionesActivas', 'aportacionesRecuperadas', 'distribucionesPagos', 'evolucion'));
    }

    /**
     * Generar historial completo de movimientos del aportador
     */
    private function generarHistorialMovimientos(Aportador $aportador)
    {
        $movimientos = collect();

        // 1. Aportaciones realizadas (inversiones en préstamos)
        $aportaciones = $aportador->aportaciones()->with('prestamo.cliente')->get();
        foreach ($aportaciones as $aportacion) {
            $movimientos->push([
                'fecha' => $aportacion->fecha_aportacion ?? $aportacion->created_at,
                'tipo' => 'inversion',
                'descripcion' => "Inversión en préstamo #{$aportacion->prestamo->numero_prestamo} - {$aportacion->prestamo->cliente->nombre}",
                'monto' => -$aportacion->monto_aportado,
                'capital_disponible_antes' => null, // Se calculará después
                'capital_disponible_despues' => null,
                'referencia' => "Préstamo #{$aportacion->prestamo->numero_prestamo}",
                'prestamo_id' => $aportacion->prestamo_id,
            ]);
        }

        // 2. Distribuciones de pagos (recuperaciones)
        $distribuciones = $aportador->distribucionesPagos()
            ->with(['pago.prestamo.cliente', 'aportacion'])
            ->get();

        foreach ($distribuciones as $distribucion) {
            // Recuperación de capital
            if ($distribucion->monto_capital > 0) {
                $movimientos->push([
                    'fecha' => $distribucion->fecha_distribucion,
                    'tipo' => 'recuperacion_capital',
                    'descripcion' => "Recuperación de capital - Préstamo #{$distribucion->aportacion->prestamo->numero_prestamo}",
                    'monto' => $distribucion->monto_capital,
                    'capital_disponible_antes' => null,
                    'capital_disponible_despues' => null,
                    'referencia' => "Pago #{$distribucion->pago_id}",
                    'prestamo_id' => $distribucion->aportacion->prestamo_id,
                ]);
            }

            // Ganancia por intereses
            if ($distribucion->monto_interes > 0) {
                $movimientos->push([
                    'fecha' => $distribucion->fecha_distribucion,
                    'tipo' => 'interes',
                    'descripcion' => "Ganancia por intereses - Préstamo #{$distribucion->aportacion->prestamo->numero_prestamo}",
                    'monto' => $distribucion->monto_interes,
                    'capital_disponible_antes' => null,
                    'capital_disponible_despues' => null,
                    'referencia' => "Pago #{$distribucion->pago_id}",
                    'prestamo_id' => $distribucion->aportacion->prestamo_id,
                ]);
            }
        }

        // 3. Depósitos de capital (agregados manualmente)
        // Nota: Estos registros deberían estar en una tabla de transacciones
        // Por ahora los inferimos del capital inicial y ajustes

        // Ordenar por fecha
        $movimientos = $movimientos->sortBy('fecha')->values();

        // Calcular saldo acumulado
        $saldoAcumulado = 0;
        $movimientos = $movimientos->map(function ($movimiento) use (&$saldoAcumulado) {
            $movimiento['capital_disponible_antes'] = $saldoAcumulado;
            $saldoAcumulado += $movimiento['monto'];
            $movimiento['capital_disponible_despues'] = $saldoAcumulado;
            return $movimiento;
        });

        return $movimientos->reverse()->take(50); // Últimos 50 movimientos
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aportador $aportador)
    {
        return view('aportadores.edit', compact('aportador'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aportador $aportador)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'dpi' => 'nullable|string|size:13|unique:aportadores,dpi,' . $aportador->id,
            'email' => 'nullable|email|unique:aportadores,email,' . $aportador->id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:500',
            'tipo' => 'required|in:Persona,Empresa,Institución',
            'empresa' => 'nullable|string|max:255',
            'nit' => 'nullable|string|max:20',
            'capital_disponible' => 'required|numeric|min:0',
            'tasa_interes_minima' => 'nullable|numeric|min:0|max:100',
            'plazo_maximo' => 'nullable|integer|min:1|max:120',
            'monto_minimo_prestamo' => 'nullable|numeric|min:0',
            'monto_maximo_prestamo' => 'nullable|numeric|min:0',
            'estado' => 'required|in:Activo,Inactivo,Suspendido',
            'notas' => 'nullable|string',
        ]);

        $aportador->update($request->all());

        return redirect()->route('aportadores.show', $aportador)
            ->with('success', 'Aportador actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aportador $aportador)
    {
        // Verificar si tiene aportaciones activas
        if ($aportador->aportacionesActivas()->exists()) {
            return back()->with('error', 'No se puede eliminar un aportador con inversiones activas.');
        }

        $aportador->delete();

        return redirect()->route('aportadores.index')
            ->with('success', 'Aportador eliminado exitosamente.');
    }

    /**
     * Agregar capital al aportador
     */
    public function agregarCapital(Request $request, Aportador $aportador)
    {
        $request->validate([
            'monto' => 'required|numeric|min:0.01',
            'notas' => 'nullable|string',
        ]);

        $aportador->capital_disponible += $request->monto;
        $aportador->save();

        return back()->with('success', "Se agregaron Q " . number_format($request->monto, 2) . " al capital disponible.");
    }

    /**
     * Retirar capital del aportador
     */
    public function retirarCapital(Request $request, Aportador $aportador)
    {
        $request->validate([
            'monto' => 'required|numeric|min:0.01',
            'notas' => 'nullable|string',
        ]);

        if ($request->monto > $aportador->capital_disponible) {
            return back()->with('error', 'El monto a retirar excede el capital disponible.');
        }

        $aportador->capital_disponible -= $request->monto;
        $aportador->save();

        return back()->with('success', "Se retiraron Q " . number_format($request->monto, 2) . " del capital disponible.");
    }

    /**
     * Recalcular estadísticas de todos los aportadores
     */
    public function recalcularTodos()
    {
        try {
            $aportadores = \App\Models\Aportador::all();
            $contadorActualizados = 0;

            foreach ($aportadores as $aportador) {
                $aportacionesActivas = \App\Models\Aportacion::where('aportador_id', $aportador->id)
                    ->whereIn('estado', ['Activo', 'Recuperado'])
                    ->get();

                $capitalInvertido = $aportacionesActivas->sum('monto_aportado');
                $capitalRecuperado = $aportacionesActivas->sum('monto_recuperado');
                $gananciasTotales = $aportacionesActivas->sum('intereses_ganados');

                $aportador->capital_invertido = $capitalInvertido;
                $aportador->capital_recuperado = $capitalRecuperado;
                $aportador->ganancias_totales = $gananciasTotales;
                $aportador->save();

                $contadorActualizados++;
            }

            return back()->with('success', "Se recalcularon exitosamente las estadísticas de {$contadorActualizados} aportador(es).");
        } catch (\Exception $e) {
            \Log::error('Error al recalcular aportadores: ' . $e->getMessage());
            return back()->with('error', 'Error al recalcular: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar historial de movimientos de capital de un aportador
     */
    public function movimientos(Aportador $aportador)
    {
        $movimientos = $this->generarHistorialMovimientos($aportador);

        return view('aportadores.movimientos', compact('aportador', 'movimientos'));
    }
}
