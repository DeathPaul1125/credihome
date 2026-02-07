<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Prestamo;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Métricas principales
        $totalClientes = Cliente::where('estado', 'activo')->count();
        $prestamosActivos = Prestamo::whereIn('estado', ['activo', 'en_mora'])->count();
        $carteraTotal = Prestamo::whereIn('estado', ['activo', 'en_mora'])->sum('saldo_pendiente');
        $pagosHoy = Pago::whereDate('fecha_pago', Carbon::today())->sum('monto_pagado');

        // Préstamos por estado
        $prestamosPorEstado = Prestamo::select('estado', DB::raw('count(*) as total'), DB::raw('sum(saldo_pendiente) as monto'))
            ->groupBy('estado')
            ->get();

        // Cartera vencida
        $carteraVencida = Prestamo::where('estado', 'en_mora')->sum('saldo_pendiente');
        $prestamosVencidos = Prestamo::where('estado', 'en_mora')->count();

        // Tasa de morosidad
        $totalActivos = Prestamo::whereIn('estado', ['activo', 'en_mora'])->count();
        $tasaMorosidad = $totalActivos > 0 ? ($prestamosVencidos / $totalActivos) * 100 : 0;

        // Actividad reciente - últimos 7 días
        $fechaInicio = Carbon::now()->subDays(7);
        $prestamosRecientes = Prestamo::where('created_at', '>=', $fechaInicio)
            ->with('cliente')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $pagosRecientes = Pago::where('created_at', '>=', $fechaInicio)
            ->with(['cliente', 'prestamo'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Gráfica de pagos de los últimos 7 días
        $pagosUltimos7Dias = Pago::whereBetween('fecha_pago', [Carbon::now()->subDays(6), Carbon::now()])
            ->select(DB::raw('DATE(fecha_pago) as fecha'), DB::raw('sum(monto_pagado) as total'))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        // Completar los días faltantes con 0
        $diasCompletos = collect();
        for ($i = 6; $i >= 0; $i--) {
            $fecha = Carbon::now()->subDays($i)->format('Y-m-d');
            $pago = $pagosUltimos7Dias->firstWhere('fecha', $fecha);
            $diasCompletos->push([
                'fecha' => $fecha,
                'total' => $pago ? $pago->total : 0,
                'dia' => Carbon::parse($fecha)->format('D')
            ]);
        }

        // Préstamos próximos a vencer (próximos 7 días)
        $proximosVencer = Prestamo::whereIn('estado', ['activo', 'en_mora'])
            ->whereHas('pagos', function($query) {
                $query->whereBetween('fecha_vencimiento', [Carbon::now(), Carbon::now()->addDays(7)]);
            })
            ->with('cliente')
            ->limit(5)
            ->get();

        // Distribución de cartera por frecuencia
        $distribucionFrecuencia = Prestamo::whereIn('estado', ['activo', 'en_mora'])
            ->select('frecuencia_pago', DB::raw('count(*) as total'), DB::raw('sum(saldo_pendiente) as monto'))
            ->groupBy('frecuencia_pago')
            ->get();

        // Usuario que realizó más préstamos
        $usuarioMasPrestamos = Prestamo::join('users', 'prestamos.user_id', '=', 'users.id')
            ->select('users.id', 'users.name', DB::raw('count(*) as total_prestamos'), DB::raw('sum(prestamos.monto_prestado) as monto_total'))
            ->groupBy('users.id', 'users.name')
            ->orderBy('total_prestamos', 'desc')
            ->first();

        // Usuario que realizó más cobros (pagos registrados)
        $usuarioMasCobros = Pago::join('users', 'pagos.user_id', '=', 'users.id')
            ->select('users.id', 'users.name', DB::raw('count(*) as total_cobros'), DB::raw('sum(pagos.monto_pagado) as monto_total_cobrado'))
            ->groupBy('users.id', 'users.name')
            ->orderBy('total_cobros', 'desc')
            ->first();

        // Top 5 usuarios por préstamos creados
        $topUsuariosPrestamos = Prestamo::join('users', 'prestamos.user_id', '=', 'users.id')
            ->select('users.name', DB::raw('count(*) as total'), DB::raw('sum(prestamos.monto_prestado) as monto_total'))
            ->groupBy('users.id', 'users.name')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        // Top 5 usuarios por cobros realizados
        $topUsuariosCobros = Pago::join('users', 'pagos.user_id', '=', 'users.id')
            ->select('users.name', DB::raw('count(*) as total'), DB::raw('sum(pagos.monto_pagado) as monto_total'))
            ->groupBy('users.id', 'users.name')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard-flowbite', compact(
            'totalClientes',
            'prestamosActivos',
            'carteraTotal',
            'pagosHoy',
            'prestamosPorEstado',
            'carteraVencida',
            'prestamosVencidos',
            'tasaMorosidad',
            'prestamosRecientes',
            'pagosRecientes',
            'diasCompletos',
            'proximosVencer',
            'distribucionFrecuencia',
            'usuarioMasPrestamos',
            'usuarioMasCobros',
            'topUsuariosPrestamos',
            'topUsuariosCobros'
        ));
    }
}
