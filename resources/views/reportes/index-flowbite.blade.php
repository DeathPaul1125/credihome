<x-flowbite-layout>
    <div class="p-4 sm:ml-64">
        <div class="p-4 mt-14">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    <i class="fas fa-chart-line mr-2"></i>Reportes y Estadísticas
                </h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Panel de control y análisis financiero</p>
            </div>

            <!-- Filtros de Fecha -->
            <div class="mb-6 p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <form method="GET" action="{{ route('reportes.index') }}" class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <label for="fecha_desde" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha Desde</label>
                        <input type="date" id="fecha_desde" name="fecha_desde" value="{{ request('fecha_desde', now()->startOfMonth()->format('Y-m-d')) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div class="flex-1 min-w-[200px]">
                        <label for="fecha_hasta" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha Hasta</label>
                        <input type="date" id="fecha_hasta" name="fecha_hasta" value="{{ request('fecha_hasta', now()->format('Y-m-d')) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            <i class="fas fa-filter mr-2"></i>Filtrar
                        </button>
                    </div>
                </form>
            </div>

            <!-- Cards de Métricas -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
                <!-- Total Prestado -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium mb-1">Total Prestado</p>
                            <h3 class="text-3xl font-bold">Q{{ number_format($metricas['total_prestado'], 2) }}</h3>
                            <p class="text-blue-100 text-xs mt-2">
                                <i class="fas fa-hand-holding-usd mr-1"></i>
                                {{ $metricas['cantidad_prestamos'] }} préstamos
                            </p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4">
                            <i class="fas fa-coins text-3xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Cobrado -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium mb-1">Total Cobrado</p>
                            <h3 class="text-3xl font-bold">Q{{ number_format($metricas['total_cobrado'], 2) }}</h3>
                            <p class="text-green-100 text-xs mt-2">
                                <i class="fas fa-check-circle mr-1"></i>
                                {{ $metricas['cantidad_pagos'] }} pagos
                            </p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4">
                            <i class="fas fa-money-bill-wave text-3xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Préstamos Activos -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium mb-1">Préstamos Activos</p>
                            <h3 class="text-3xl font-bold">{{ $metricas['prestamos_activos'] }}</h3>
                            <p class="text-purple-100 text-xs mt-2">
                                <i class="fas fa-clock mr-1"></i>
                                En proceso
                            </p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4">
                            <i class="fas fa-file-invoice-dollar text-3xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Morosidad -->
                <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-red-100 text-sm font-medium mb-1">Morosidad</p>
                            <h3 class="text-3xl font-bold">Q{{ number_format($metricas['morosidad'], 2) }}</h3>
                            <p class="text-red-100 text-xs mt-2">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                {{ $metricas['prestamos_vencidos'] }} vencidos
                            </p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4">
                            <i class="fas fa-exclamation-circle text-3xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6">
                <!-- Gráfica de Pagos -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                            <i class="fas fa-chart-bar text-blue-600 mr-2"></i>Pagos Mensuales
                        </h2>
                        <div id="pagos-chart"></div>
                    </div>
                </div>

                <!-- Gráfica de Préstamos por Estado -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                            <i class="fas fa-chart-pie text-purple-600 mr-2"></i>Préstamos por Estado
                        </h2>
                        <div id="prestamos-estado-chart"></div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Préstamos con Saldos -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                        <i class="fas fa-table text-green-600 mr-2"></i>Préstamos con Saldos Pendientes
                    </h2>

                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Cliente</th>
                                    <th scope="col" class="px-6 py-3">Monto Préstamo</th>
                                    <th scope="col" class="px-6 py-3">Total Pagado</th>
                                    <th scope="col" class="px-6 py-3">Saldo Pendiente</th>
                                    <th scope="col" class="px-6 py-3">% Pagado</th>
                                    <th scope="col" class="px-6 py-3">Fecha Préstamo</th>
                                    <th scope="col" class="px-6 py-3">Estado</th>
                                    <th scope="col" class="px-6 py-3">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($prestamos_con_saldo as $prestamo)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $prestamo->cliente->nombre }}
                                    </td>
                                    <td class="px-6 py-4">
                                        Q{{ number_format($prestamo->monto_prestamo, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-green-600 dark:text-green-400 font-semibold">
                                        Q{{ number_format($prestamo->monto_prestamo - $prestamo->saldo_pendiente, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-red-600 dark:text-red-400 font-semibold">
                                        Q{{ number_format($prestamo->saldo_pendiente, 2) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $porcentaje = $prestamo->monto_prestamo > 0 ? (($prestamo->monto_prestamo - $prestamo->saldo_pendiente) / $prestamo->monto_prestamo) * 100 : 0;
                                        @endphp
                                        <div class="flex items-center">
                                            <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700 mr-2">
                                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $porcentaje }}%"></div>
                                            </div>
                                            <span class="text-xs font-medium">{{ number_format($porcentaje, 1) }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::parse($prestamo->fecha_prestamo)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($prestamo->estado == 'activo')
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Activo</span>
                                        @elseif($prestamo->estado == 'vencido')
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Vencido</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ ucfirst($prestamo->estado) }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('prestamos.show', $prestamo->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400" title="Ver Detalle">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-check-circle text-4xl mb-3 text-green-500"></i>
                                        <p>No hay préstamos con saldos pendientes</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Gráfica de Pagos Mensuales
        const pagosOptions = {
            chart: {
                type: 'bar',
                height: 350,
                toolbar: { show: false }
            },
            series: [{
                name: 'Pagos',
                data: @json(array_values($grafica_pagos['montos']))
            }],
            xaxis: {
                categories: @json(array_values($grafica_pagos['meses']))
            },
            colors: ['#3b82f6'],
            dataLabels: {
                enabled: false
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    dataLabels: {
                        position: 'top'
                    }
                }
            },
            yaxis: {
                labels: {
                    formatter: function(val) {
                        return 'Q' + val.toFixed(0);
                    }
                }
            }
        };
        const pagosChart = new ApexCharts(document.querySelector("#pagos-chart"), pagosOptions);
        pagosChart.render();

        // Gráfica de Préstamos por Estado
        const prestamosEstadoOptions = {
            chart: {
                type: 'donut',
                height: 350
            },
            series: @json(array_values($grafica_estados['valores'])),
            labels: @json(array_values($grafica_estados['estados'])),
            colors: ['#10b981', '#f59e0b', '#ef4444', '#6b7280'],
            legend: {
                position: 'bottom'
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 300
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };
        const prestamosEstadoChart = new ApexCharts(document.querySelector("#prestamos-estado-chart"), prestamosEstadoOptions);
        prestamosEstadoChart.render();
    </script>
    @endpush
</x-flowbite-layout>
