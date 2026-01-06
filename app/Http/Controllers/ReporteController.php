<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Prestamo;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        // Filtros de fecha
        $fechaInicio = $request->input('fecha_inicio', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $fechaFin = $request->input('fecha_fin', Carbon::now()->format('Y-m-d'));

        // Estadísticas Generales
        $totalClientes = Cliente::where('estado', 'activo')->count();
        $totalPrestamosActivos = Prestamo::whereIn('estado', ['activo', 'en_mora'])->count();
        $carteraTotal = Prestamo::whereIn('estado', ['activo', 'en_mora'])->sum('saldo_pendiente');
        $totalPagosDelPeriodo = Pago::whereBetween('fecha_pago', [$fechaInicio, $fechaFin])->sum('monto_pagado');

        // Préstamos por Estado
        $prestamosPorEstado = Prestamo::select('estado', DB::raw('count(*) as total'), DB::raw('sum(saldo_pendiente) as monto'))
            ->groupBy('estado')
            ->get();

        // Cartera Vencida (préstamos en mora)
        $carteraVencida = Prestamo::where('estado', 'en_mora')->sum('saldo_pendiente');
        $prestamosVencidos = Prestamo::where('estado', 'en_mora')->count();

        // Préstamos otorgados en el período
        $prestamosDelPeriodo = Prestamo::whereBetween('fecha_desembolso', [$fechaInicio, $fechaFin])
            ->select(DB::raw('DATE(fecha_desembolso) as fecha'), DB::raw('count(*) as total'), DB::raw('sum(monto_prestado) as monto'))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        // Pagos recibidos en el período por día
        $pagosDelPeriodo = Pago::whereBetween('fecha_pago', [$fechaInicio, $fechaFin])
            ->select(DB::raw('DATE(fecha_pago) as fecha'), DB::raw('count(*) as total'), DB::raw('sum(monto_pagado) as monto'))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        // Top 10 Clientes con mayor deuda
        $topDeudores = Cliente::withSum(['prestamos' => function($query) {
            $query->whereIn('estado', ['activo', 'en_mora']);
        }], 'saldo_pendiente')
            ->orderByDesc('prestamos_sum_saldo_pendiente')
            ->limit(10)
            ->get();

        // Mora acumulada
        $moraTotal = Pago::whereBetween('fecha_pago', [$fechaInicio, $fechaFin])->sum('mora');

        // Tasa de morosidad (préstamos en mora / préstamos activos)
        $totalActivos = Prestamo::whereIn('estado', ['activo', 'en_mora'])->count();
        $tasaMorosidad = $totalActivos > 0 ? ($prestamosVencidos / $totalActivos) * 100 : 0;

        // Distribución por frecuencia de pago
        $distribucionFrecuencia = Prestamo::whereIn('estado', ['activo', 'en_mora'])
            ->select('frecuencia_pago', DB::raw('count(*) as total'), DB::raw('sum(saldo_pendiente) as monto'))
            ->groupBy('frecuencia_pago')
            ->get();

        // Distribución por tipo de interés
        $distribucionInteres = Prestamo::whereIn('estado', ['activo', 'en_mora'])
            ->select('tipo_interes', DB::raw('count(*) as total'), DB::raw('sum(saldo_pendiente) as monto'))
            ->groupBy('tipo_interes')
            ->get();

        // Préstamos con saldo pendiente (para tabla de detalle)
        $prestamos_con_saldo = Prestamo::whereIn('estado', ['activo', 'en_mora'])
            ->where('saldo_pendiente', '>', 0)
            ->with('cliente')
            ->orderBy('saldo_pendiente', 'desc')
            ->limit(10)
            ->get();

        // Métricas para las tarjetas del dashboard
        $metricas = [
            'total_prestado' => Prestamo::whereBetween('fecha_desembolso', [$fechaInicio, $fechaFin])->sum('monto_prestado'),
            'cantidad_prestamos' => Prestamo::whereBetween('fecha_desembolso', [$fechaInicio, $fechaFin])->count(),
            'total_cobrado' => Pago::whereBetween('fecha_pago', [$fechaInicio, $fechaFin])->sum('monto_pagado'),
            'cantidad_pagos' => Pago::whereBetween('fecha_pago', [$fechaInicio, $fechaFin])->count(),
            'saldo_pendiente' => Prestamo::whereIn('estado', ['activo', 'en_mora'])->sum('saldo_pendiente'),
            'prestamos_activos' => Prestamo::whereIn('estado', ['activo', 'en_mora'])->count(),
            'mora_acumulada' => $moraTotal,
            'cantidad_mora' => Pago::whereBetween('fecha_pago', [$fechaInicio, $fechaFin])->where('mora', '>', 0)->count(),
            'morosidad' => $carteraVencida,
            'prestamos_vencidos' => $prestamosVencidos,
        ];

        // Datos para gráfica de pagos (últimos 6 meses)
        $grafica_pagos = [
            'meses' => [],
            'montos' => []
        ];
        
        for ($i = 5; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i);
            $grafica_pagos['meses'][] = $mes->locale('es')->isoFormat('MMM YYYY');
            $grafica_pagos['montos'][] = Pago::whereYear('fecha_pago', $mes->year)
                ->whereMonth('fecha_pago', $mes->month)
                ->sum('monto_pagado');
        }

        // Datos para gráfica de estados (donut chart)
        $grafica_estados = [
            'estados' => [],
            'valores' => []
        ];
        
        foreach ($prestamosPorEstado as $estado) {
            $grafica_estados['estados'][] = ucfirst($estado->estado);
            $grafica_estados['valores'][] = $estado->total;
        }

        return view('reportes.index-flowbite', compact(
            'fechaInicio',
            'fechaFin',
            'totalClientes',
            'totalPrestamosActivos',
            'carteraTotal',
            'totalPagosDelPeriodo',
            'prestamosPorEstado',
            'carteraVencida',
            'prestamosVencidos',
            'prestamosDelPeriodo',
            'pagosDelPeriodo',
            'topDeudores',
            'moraTotal',
            'tasaMorosidad',
            'distribucionFrecuencia',
            'distribucionInteres',
            'metricas',
            'prestamos_con_saldo',
            'grafica_pagos',
            'grafica_estados'
        ));
    }
}
