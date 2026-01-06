<x-flowbite-layout>
    <div class="p-4">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard de Aportadores</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Vista general de inversionistas y capital del sistema
            </p>
        </div>

        <!-- Estadísticas Principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Total Capital Sistema -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Capital Total Sistema</p>
                        <p class="text-3xl font-bold mt-2">Q {{ number_format($stats['capital_total_sistema'], 2) }}</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-3">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-blue-100">{{ $stats['total_aportadores'] }} aportadores registrados</span>
                </div>
            </div>

            <!-- Capital Disponible -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Capital Disponible</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">Q {{ number_format($stats['capital_disponible'], 2) }}</p>
                    </div>
                    <div class="bg-green-100 dark:bg-green-900 rounded-full p-3">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Listo para prestar</p>
            </div>

            <!-- Capital Invertido -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Capital Invertido</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">Q {{ number_format($stats['capital_invertido'], 2) }}</p>
                    </div>
                    <div class="bg-yellow-100 dark:bg-yellow-900 rounded-full p-3">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">En {{ $stats['prestamos_fondeados'] }} préstamos</p>
            </div>

            <!-- Ganancias Totales -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Ganancias Totales</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400 mt-2">Q {{ number_format($stats['ganancias_totales'], 2) }}</p>
                    </div>
                    <div class="bg-green-100 dark:bg-green-900 rounded-full p-3">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-green-600 dark:text-green-400 mt-2">ROI Promedio: {{ number_format($stats['roi_promedio'], 2) }}%</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Gráfico de Evolución Mensual -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Distribuciones Mensuales</h3>
                <div id="evolucionChart"></div>
            </div>

            <!-- Top Aportadores -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top 10 Aportadores por Capital</h3>
                <div class="overflow-y-auto max-h-96">
                    @foreach($topAportadores as $index => $aportador)
                        <div class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700 last:border-0">
                            <div class="flex items-center space-x-3">
                                <span class="flex items-center justify-center w-8 h-8 text-sm font-bold rounded-full {{ $index < 3 ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                    {{ $index + 1 }}
                                </span>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $aportador->nombre }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $aportador->tipo }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-900 dark:text-white">Q {{ number_format($aportador->capital_total, 2) }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">ROI: {{ number_format($aportador->getRoiAttribute(), 2) }}%</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Distribuciones Recientes -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Distribuciones Recientes</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">Fecha</th>
                            <th class="px-6 py-3">Aportador</th>
                            <th class="px-6 py-3">Cliente</th>
                            <th class="px-6 py-3">Préstamo</th>
                            <th class="px-6 py-3">Capital</th>
                            <th class="px-6 py-3">Interés</th>
                            <th class="px-6 py-3">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($distribucionesRecientes as $dist)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $dist->fecha_distribucion->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('aportadores.show', $dist->aportador_id) }}" class="text-blue-600 hover:underline dark:text-blue-400">
                                        {{ $dist->aportador->nombre }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $dist->pago->prestamo->cliente->nombre ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $dist->pago->prestamo->numero_prestamo ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-gray-900 dark:text-white">
                                    Q {{ number_format($dist->monto_capital, 2) }}
                                </td>
                                <td class="px-6 py-4 text-green-600 dark:text-green-400">
                                    Q {{ number_format($dist->monto_interes, 2) }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                    Q {{ number_format($dist->monto_total, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                    No hay distribuciones registradas aún
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="mt-6 flex gap-4">
            <a href="{{ route('aportadores.index') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                Ver Todos los Aportadores
            </a>
            <a href="{{ route('aportadores.create') }}" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
                + Nuevo Aportador
            </a>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Gráfico de evolución mensual
        const evolucionData = @json($evolucionMensual);

        const options = {
            series: [{
                name: 'Capital Recuperado',
                data: evolucionData.map(d => parseFloat(d.capital))
            }, {
                name: 'Intereses Ganados',
                data: evolucionData.map(d => parseFloat(d.intereses))
            }],
            chart: {
                type: 'area',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                categories: evolucionData.map(d => d.mes),
                labels: {
                    style: {
                        colors: '#9ca3af'
                    }
                }
            },
            yaxis: {
                labels: {
                    formatter: function(val) {
                        return 'Q ' + val.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    },
                    style: {
                        colors: '#9ca3af'
                    }
                }
            },
            colors: ['#3b82f6', '#10b981'],
            fill: {
                type: 'gradient',
                gradient: {
                    opacityFrom: 0.6,
                    opacityTo: 0.1,
                }
            },
            legend: {
                position: 'top',
                labels: {
                    colors: '#9ca3af'
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return 'Q ' + val.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }
            }
        };

        const chart = new ApexCharts(document.querySelector("#evolucionChart"), options);
        chart.render();
    </script>
    @endpush
</x-flowbite-layout>
