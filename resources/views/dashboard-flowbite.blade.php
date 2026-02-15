<x-flowbite-layout>
    <div class="mb-4">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Resumen general del sistema de préstamos</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        <!-- Total Clientes -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 18">
                            <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Clientes</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalClientes }}</p>
                </div>
            </div>
        </div>

        <!-- Préstamos Activos -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-300" fill="currentColor" viewBox="0 0 18 20">
                            <path d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Préstamos Activos</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $prestamosActivos }}</p>
                </div>
            </div>
        </div>

        <!-- Cartera Total -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-lg">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-300" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Cartera Total</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ money_symbol($carteraTotal) }}</p>
                </div>
            </div>
        </div>

        <!-- Pagos Hoy -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                        <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.96 2.96 0 0 0 .13 5H5Z"/>
                            <path d="M6.737 11.061a2.961 2.961 0 0 1 .81-1.515l6.117-6.116A4.839 4.839 0 0 1 16 2.141V2a1.97 1.97 0 0 0-1.933-2H7v5a2 2 0 0 1-2 2H0v11a1.969 1.969 0 0 0 1.933 2h12.134A1.97 1.97 0 0 0 16 18v-3.093l-1.546 1.546c-.413.413-.94.695-1.513.81l-3.4.679a2.947 2.947 0 0 1-1.85-.227 2.96 2.96 0 0 1-1.635-3.257l.681-3.397Z"/>
                            <path d="M8.961 16a.93.93 0 0 0 .189-.019l3.4-.679a.961.961 0 0 0 .49-.263l6.118-6.117a2.884 2.884 0 0 0-4.079-4.078l-6.117 6.117a.96.96 0 0 0-.263.491l-.679 3.4A.961.961 0 0 0 8.961 16Zm7.477-9.8a.958.958 0 0 1 .68-.281.961.961 0 0 1 .682 1.644l-.315.315-1.36-1.36.313-.318Zm-5.911 5.911 4.236-4.236 1.359 1.359-4.236 4.237-1.7.339.341-1.699Z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Pagos Hoy</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ money_symbol($pagosHoy) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
        <!-- Pagos últimos 7 días -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pagos últimos 7 días</h3>
            <div id="chart-pagos-7dias"></div>
        </div>

        <!-- Préstamos por Estado -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Préstamos por Estado</h3>
            <div id="chart-prestamos-estado"></div>
        </div>
    </div>

    <!-- Additional Stats Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
        <!-- Tasa de Morosidad -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Tasa de Morosidad</h3>
                <span class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                    <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4"/>
                    </svg>
                    {{ percentage($tasaMorosidad) }}
                </span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                <div class="bg-red-600 h-2.5 rounded-full" style="width: {{ min($tasaMorosidad, 100) }}%"></div>
            </div>
        </div>

        <!-- Préstamos Vencidos -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Préstamos Vencidos</h3>
            <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $prestamosVencidos }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ money_symbol($carteraVencida) }}</p>
        </div>

        <!-- Distribución por Frecuencia -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-3">Por Frecuencia de Pago</h3>
            <div class="space-y-2">
                @foreach($distribucionFrecuencia as $frec)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ ucfirst($frec->frecuencia_pago) }}</span>
                    <span class="inline-flex items-center bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                        {{ $frec->total }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
        <!-- Top Usuarios - Préstamos -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Top Usuarios - Préstamos Creados</h3>
                </div>
                @if($usuarioMasPrestamos)
                <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-lg">
                                    {{ substr($usuarioMasPrestamos->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">🏆 {{ $usuarioMasPrestamos->name }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Usuario más activo</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $usuarioMasPrestamos->total_prestamos }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">préstamos</p>
                        </div>
                    </div>
                    <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                        <span class="font-semibold">Total otorgado:</span> {{ money_symbol($usuarioMasPrestamos->monto_total) }}
                    </div>
                </div>
                @endif
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Usuario</th>
                            <th scope="col" class="px-6 py-3 text-center">Préstamos</th>
                            <th scope="col" class="px-6 py-3 text-right">Monto Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topUsuariosPrestamos as $usuario)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm mr-3">
                                        {{ substr($usuario->name, 0, 1) }}
                                    </div>
                                    {{ $usuario->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                    {{ $usuario->total }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right font-semibold text-gray-900 dark:text-white">
                                {{ money_symbol($usuario->monto_total) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                No hay datos disponibles
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Usuarios - Cobros -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Top Usuarios - Cobros Realizados</h3>
                </div>
                @if($usuarioMasCobros)
                <div class="mt-4 p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-green-600 flex items-center justify-center text-white font-bold text-lg">
                                    {{ substr($usuarioMasCobros->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">🏆 {{ $usuarioMasCobros->name }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Mejor cobrador</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $usuarioMasCobros->total_cobros }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">cobros</p>
                        </div>
                    </div>
                    <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                        <span class="font-semibold">Total cobrado:</span> {{ money_symbol($usuarioMasCobros->monto_total_cobrado) }}
                    </div>
                </div>
                @endif
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Usuario</th>
                            <th scope="col" class="px-6 py-3 text-center">Cobros</th>
                            <th scope="col" class="px-6 py-3 text-right">Monto Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topUsuariosCobros as $usuario)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center text-white font-semibold text-sm mr-3">
                                        {{ substr($usuario->name, 0, 1) }}
                                    </div>
                                    {{ $usuario->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                    {{ $usuario->total }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right font-semibold text-gray-900 dark:text-white">
                                {{ money_symbol($usuario->monto_total) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                No hay datos disponibles
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tables Row - Actividad Reciente -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Préstamos Recientes -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Préstamos Recientes</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Cliente</th>
                            <th scope="col" class="px-6 py-3">Monto</th>
                            <th scope="col" class="px-6 py-3">Estado</th>
                            <th scope="col" class="px-6 py-3">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prestamosRecientes as $prestamo)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                <a href="{{ route('prestamos.show', $prestamo->id) }}" class="hover:underline">
                                    {{ $prestamo->cliente->nombre_completo }}
                                </a>
                            </td>
                            <td class="px-6 py-4">{{ money_symbol($prestamo->monto_prestado) }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'activo' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                        'pendiente' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                        'completado' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                        'vencido' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                        'cancelado' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$prestamo->estado] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($prestamo->estado) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $prestamo->fecha_desembolso ? $prestamo->fecha_desembolso->format('d/m/Y') : 'Sin fecha' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                No hay préstamos recientes
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagos Recientes -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pagos Recientes</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Préstamo</th>
                            <th scope="col" class="px-6 py-3">Monto</th>
                            <th scope="col" class="px-6 py-3">Método</th>
                            <th scope="col" class="px-6 py-3">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pagosRecientes as $pago)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                <a href="{{ route('pagos.show', $pago->id) }}" class="hover:underline">
                                    #{{ $pago->prestamo_id }}
                                </a>
                            </td>
                            <td class="px-6 py-4">{{ money_symbol($pago->monto) }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                    {{ ucfirst(str_replace('_', ' ', $pago->metodo_pago)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                No hay pagos recientes
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Configuración común para dark mode
        const isDarkMode = document.documentElement.classList.contains('dark');
        const textColor = isDarkMode ? '#9ca3af' : '#6b7280';
        const gridColor = isDarkMode ? '#374151' : '#f3f4f6';

        // Chart 1: Pagos últimos 7 días
        const optionsPagos7Dias = {
            chart: {
                type: 'area',
                height: 300,
                toolbar: { show: false },
                background: 'transparent'
            },
            series: [{
                name: 'Pagos',
                data: @json($diasCompletos->pluck('total')->toArray())
            }],
            xaxis: {
                categories: @json($diasCompletos->pluck('fecha')->toArray()),
                labels: {
                    style: { colors: textColor }
                }
            },
            yaxis: {
                labels: {
                    style: { colors: textColor },
                    formatter: (value) => formatMoneySymbol(value)
                }
            },
            colors: ['#3b82f6'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.3,
                }
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            grid: {
                borderColor: gridColor
            },
            dataLabels: {
                enabled: false
            },
            tooltip: {
                theme: isDarkMode ? 'dark' : 'light',
                y: {
                    formatter: (value) => formatMoneySymbol(value)
                }
            }
        };

        const chartPagos7Dias = new ApexCharts(document.querySelector("#chart-pagos-7dias"), optionsPagos7Dias);
        chartPagos7Dias.render();

        // Chart 2: Préstamos por Estado
        const optionsPrestamosEstado = {
            chart: {
                type: 'donut',
                height: 300,
                background: 'transparent'
            },
            series: @json($prestamosPorEstado->pluck('total')->toArray()),
            labels: @json($prestamosPorEstado->pluck('estado')->map(fn($e) => ucfirst($e))->toArray()),
            colors: ['#10b981', '#f59e0b', '#3b82f6', '#ef4444', '#6b7280'],
            legend: {
                position: 'bottom',
                labels: {
                    colors: textColor
                }
            },
            dataLabels: {
                enabled: true,
                style: {
                    colors: ['#fff']
                }
            },
            tooltip: {
                theme: isDarkMode ? 'dark' : 'light',
                y: {
                    formatter: (value) => value + ' préstamos'
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total',
                                color: textColor,
                                formatter: () => '{{ $prestamosActivos }}'
                            }
                        }
                    }
                }
            }
        };

        const chartPrestamosEstado = new ApexCharts(document.querySelector("#chart-prestamos-estado"), optionsPrestamosEstado);
        chartPrestamosEstado.render();

        // Rerender charts on theme toggle
        document.getElementById('theme-toggle').addEventListener('click', function() {
            setTimeout(() => {
                chartPagos7Dias.destroy();
                chartPrestamosEstado.destroy();
                location.reload();
            }, 100);
        });
    </script>
    @endpush
</x-flowbite-layout>
