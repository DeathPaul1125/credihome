<x-flowbite-layout>
    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $aportador->nombre }}</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium
                            @if($aportador->estado === 'Activo') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                            @elseif($aportador->estado === 'Inactivo') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                            @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 @endif">
                            {{ $aportador->estado }}
                        </span>
                        <span class="ml-2">{{ $aportador->tipo }}</span>
                    </p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('aportadores.edit', $aportador) }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        Editar
                    </a>
                    <a href="{{ route('aportadores.index') }}" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                        Volver
                    </a>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Capital Total</h3>
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ money_symbol($stats['total_aportado']) }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Disponible</h3>
                        <svg class="w-5 h-5 text-green-600 dark:text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ money_symbol($aportador->capital_disponible) }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Invertido</h3>
                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ money_symbol($aportador->capital_invertido) }}</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $stats['prestamos_activos'] }} préstamos</p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Ganancias</h3>
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-green-600 dark:text-green-500">{{ money_symbol($aportador->ganancias_totales) }}</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">ROI: {{ percentage($aportador->roi) }}</p>
                </div>
            </div>

            <!-- Gráfico de Evolución -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Evolución de Capital (12 meses)</h2>
                <div id="capitalChart"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Información Personal -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Información Personal</h2>
                    <dl class="space-y-3">
                        @if($aportador->tipo === 'Empresa' || $aportador->tipo === 'Institución')
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Empresa</dt>
                                <dd class="text-sm text-gray-900 dark:text-white mt-1">{{ $aportador->empresa ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">NIT</dt>
                                <dd class="text-sm text-gray-900 dark:text-white mt-1">{{ $aportador->nit ?? 'N/A' }}</dd>
                            </div>
                        @endif
                        @if($aportador->dpi)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">DPI</dt>
                            <dd class="text-sm text-gray-900 dark:text-white mt-1">{{ $aportador->dpi }}</dd>
                        </div>
                        @endif
                        @if($aportador->email)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                            <dd class="text-sm text-gray-900 dark:text-white mt-1">{{ $aportador->email }}</dd>
                        </div>
                        @endif
                        @if($aportador->telefono)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono</dt>
                            <dd class="text-sm text-gray-900 dark:text-white mt-1">{{ $aportador->telefono }}</dd>
                        </div>
                        @endif
                        @if($aportador->direccion)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dirección</dt>
                            <dd class="text-sm text-gray-900 dark:text-white mt-1">{{ $aportador->direccion }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>

                <!-- Preferencias -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Preferencias de Inversión</h2>
                    <dl class="space-y-3">
                        @if($aportador->tasa_interes_minima)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tasa Mínima</dt>
                            <dd class="text-sm text-gray-900 dark:text-white mt-1">{{ percentage($aportador->tasa_interes_minima) }}</dd>
                        </div>
                        @endif
                        @if($aportador->plazo_maximo)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Plazo Máximo</dt>
                            <dd class="text-sm text-gray-900 dark:text-white mt-1">{{ $aportador->plazo_maximo }} meses</dd>
                        </div>
                        @endif
                        @if($aportador->monto_minimo_prestamo)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto Mínimo</dt>
                            <dd class="text-sm text-gray-900 dark:text-white mt-1">{{ money_symbol($aportador->monto_minimo_prestamo) }}</dd>
                        </div>
                        @endif
                        @if($aportador->monto_maximo_prestamo)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto Máximo</dt>
                            <dd class="text-sm text-gray-900 dark:text-white mt-1">{{ money_symbol($aportador->monto_maximo_prestamo) }}</dd>
                        </div>
                        @endif
                    </dl>

                    <!-- Acciones Rápidas -->
                    <div class="mt-6 flex gap-3">
                        <form action="{{ route('aportadores.agregar-capital', $aportador) }}" method="POST" class="flex-1">
                            @csrf
                            <div class="flex gap-2">
                                <input type="number" step="0.01" name="monto" placeholder="Monto" required class="flex-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none">
                                    Depositar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Inversiones Activas -->
            @if($aportacionesActivas->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Inversiones Activas</h2>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3">Préstamo</th>
                                <th class="px-6 py-3">Cliente</th>
                                <th class="px-6 py-3">Aportación</th>
                                <th class="px-6 py-3">Participación</th>
                                <th class="px-6 py-3">Recuperado</th>
                                <th class="px-6 py-3">Ganancias</th>
                                <th class="px-6 py-3">Saldo</th>
                                <th class="px-6 py-3">ROI</th>
                                <th class="px-6 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aportacionesActivas as $aportacion)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">
                                    <a href="{{ route('prestamos.show', $aportacion->prestamo) }}" class="text-blue-600 hover:underline dark:text-blue-500">
                                        #{{ $aportacion->prestamo->id }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">{{ $aportacion->prestamo->cliente->nombre }}</td>
                                <td class="px-6 py-4 font-medium">{{ money_symbol($aportacion->monto_aportado) }}</td>
                                <td class="px-6 py-4">{{ percentage($aportacion->porcentaje_participacion) }}</td>
                                <td class="px-6 py-4 text-green-600">{{ money_symbol($aportacion->monto_recuperado) }}</td>
                                <td class="px-6 py-4 text-blue-600">{{ money_symbol($aportacion->intereses_ganados) }}</td>
                                <td class="px-6 py-4">{{ money_symbol($aportacion->saldo_pendiente) }}</td>
                                <td class="px-6 py-4 font-medium">{{ percentage($aportacion->roi) }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <!-- Editar -->
                                        <a href="{{ route('aportaciones.edit', $aportacion) }}"
                                           class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                                           title="Editar Aportación">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Recalcular -->
                                        <form action="{{ route('aportaciones.recalcular', $aportacion) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit"
                                                    class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300"
                                                    title="Recalcular desde distribuciones"
                                                    onclick="return confirm('¿Recalcular esta aportación desde las distribuciones de pagos?');">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Historial de Distribuciones -->
            @if($distribucionesPagos->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Historial de Distribuciones</h2>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3">Fecha</th>
                                <th class="px-6 py-3">Préstamo</th>
                                <th class="px-6 py-3">Cliente</th>
                                <th class="px-6 py-3">Capital</th>
                                <th class="px-6 py-3">Interés</th>
                                <th class="px-6 py-3">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($distribucionesPagos as $distribucion)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">{{ $distribucion->fecha_distribucion->format('d/m/Y') }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('prestamos.show', $distribucion->aportacion->prestamo) }}" class="text-blue-600 hover:underline dark:text-blue-500">
                                        #{{ $distribucion->aportacion->prestamo_id }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">{{ $distribucion->aportacion->prestamo->cliente->nombre }}</td>
                                <td class="px-6 py-4 text-yellow-600">{{ money_symbol($distribucion->monto_capital) }}</td>
                                <td class="px-6 py-4 text-green-600">{{ money_symbol($distribucion->monto_interes) }}</td>
                                <td class="px-6 py-4 font-medium">{{ money_symbol($distribucion->monto_total) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $distribucionesPagos->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        const capitalOptions = {
            chart: {
                type: 'area',
                height: 350,
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif',
            },
            series: [{
                name: 'Capital + Ganancias',
                data: @json($evolucion->pluck('total'))
            }],
            xaxis: {
                categories: @json($evolucion->pluck('mes')),
                labels: {
                    style: {
                        colors: getComputedStyle(document.documentElement).getPropertyValue('--color-text')
                    }
                }
            },
            yaxis: {
                labels: {
                    formatter: function(value) {
                        return 'Q ' + value.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    },
                    style: {
                        colors: getComputedStyle(document.documentElement).getPropertyValue('--color-text')
                    }
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
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 2 },
            grid: {
                borderColor: getComputedStyle(document.documentElement).getPropertyValue('--color-border')
            },
            tooltip: {
                y: {
                    formatter: function(value) {
                        return formatMoneySymbol(value).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }
            }
        };

    const chart = new ApexCharts(document.querySelector("#capitalChart"), capitalOptions);
    chart.render();
</script>
@endpush
</x-flowbite-layout>
