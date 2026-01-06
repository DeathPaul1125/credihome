<x-tailadmin-layout>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Header -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Reportes y Estadísticas
            </h2>
            <nav>
                <ol class="flex items-center gap-2">
                    <li><a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a></li>
                    <li class="font-medium text-primary">Reportes</li>
                </ol>
            </nav>
        </div>

        <!-- Filtros -->
        <div class="mb-6 rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
            <form action="{{ route('reportes.index') }}" method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div>
                    <label class="mb-2 block text-sm font-medium text-black dark:text-white">Fecha Inicio</label>
                    <input type="date" name="fecha_inicio" value="{{ $fechaInicio }}" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-black dark:text-white">Fecha Fin</label>
                    <input type="date" name="fecha_fin" value="{{ $fechaFin }}" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full rounded-lg bg-primary px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-opacity-90 focus:outline-none focus:ring-4 focus:ring-primary-300">
                        Filtrar
                    </button>
                </div>
            </form>
        </div>

        <!-- Estadísticas Generales -->
        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
            <!-- Total Clientes -->
            <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-title-md font-bold text-black dark:text-white">{{ $totalClientes }}</h4>
                        <span class="text-sm font-medium">Clientes Activos</span>
                    </div>
                    <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
                        <svg class="fill-primary dark:fill-white" width="22" height="22" viewBox="0 0 22 22" fill="none">
                            <path d="M11 0C4.9 0 0 4.9 0 11s4.9 11 11 11 11-4.9 11-11S17.1 0 11 0zm0 20c-5 0-9-4-9-9s4-9 9-9 9 4 9 9-4 9-9 9z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Préstamos Activos -->
            <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-title-md font-bold text-success dark:text-white">{{ $totalPrestamosActivos }}</h4>
                        <span class="text-sm font-medium">Préstamos Activos</span>
                    </div>
                    <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-success bg-opacity-10">
                        <svg class="fill-success" width="22" height="22" viewBox="0 0 22 22" fill="none">
                            <path d="M11 0C4.9 0 0 4.9 0 11s4.9 11 11 11 11-4.9 11-11S17.1 0 11 0zm0 20c-5 0-9-4-9-9s4-9 9-9 9 4 9 9-4 9-9 9z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Cartera Total -->
            <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-title-md font-bold text-warning dark:text-white">Q {{ number_format($carteraTotal, 2) }}</h4>
                        <span class="text-sm font-medium">Cartera Total</span>
                    </div>
                    <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-warning bg-opacity-10">
                        <svg class="fill-warning" width="22" height="22" viewBox="0 0 22 22" fill="none">
                            <path d="M11 0C4.9 0 0 4.9 0 11s4.9 11 11 11 11-4.9 11-11S17.1 0 11 0zm0 20c-5 0-9-4-9-9s4-9 9-9 9 4 9 9-4 9-9 9z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pagos del Período -->
            <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-title-md font-bold text-primary dark:text-white">Q {{ number_format($totalPagosDelPeriodo, 2) }}</h4>
                        <span class="text-sm font-medium">Pagos del Período</span>
                    </div>
                    <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-primary bg-opacity-10">
                        <svg class="fill-primary" width="22" height="22" viewBox="0 0 22 22" fill="none">
                            <path d="M11 0C4.9 0 0 4.9 0 11s4.9 11 11 11 11-4.9 11-11S17.1 0 11 0zm0 20c-5 0-9-4-9-9s4-9 9-9 9 4 9 9-4 9-9 9z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cartera y Morosidad -->
        <div class="mb-6 grid grid-cols-1 gap-4 lg:grid-cols-2">
            <!-- Cartera por Estado -->
            <div class="rounded-lg border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                    <h3 class="font-semibold text-black dark:text-white">Cartera por Estado</h3>
                </div>
                <div class="p-7">
                    <div class="space-y-4">
                        @foreach($prestamosPorEstado as $estado)
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="font-medium text-black dark:text-white">{{ ucfirst(str_replace('_', ' ', $estado->estado)) }}</span>
                                    <p class="text-sm text-body-secondary">{{ $estado->total }} préstamos</p>
                                </div>
                                <span class="font-bold text-black dark:text-white">Q {{ number_format($estado->monto, 2) }}</span>
                            </div>
                            <div class="h-2 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                                <div class="h-full rounded-full
                                    @if($estado->estado === 'activo') bg-success
                                    @elseif($estado->estado === 'pagado') bg-primary
                                    @elseif($estado->estado === 'en_mora') bg-danger
                                    @elseif($estado->estado === 'vencido') bg-warning
                                    @else bg-secondary
                                    @endif"
                                    style="width: {{ $carteraTotal > 0 ? ($estado->monto / $carteraTotal * 100) : 0 }}%">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Indicadores de Morosidad -->
            <div class="rounded-lg border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                    <h3 class="font-semibold text-black dark:text-white">Indicadores de Morosidad</h3>
                </div>
                <div class="p-7">
                    <div class="space-y-6">
                        <div>
                            <div class="mb-2 flex items-center justify-between">
                                <span class="text-sm font-medium text-black dark:text-white">Tasa de Morosidad</span>
                                <span class="text-2xl font-bold {{ $tasaMorosidad > 10 ? 'text-danger' : ($tasaMorosidad > 5 ? 'text-warning' : 'text-success') }}">
                                    {{ number_format($tasaMorosidad, 2) }}%
                                </span>
                            </div>
                            <div class="h-4 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                                <div class="h-full rounded-full {{ $tasaMorosidad > 10 ? 'bg-danger' : ($tasaMorosidad > 5 ? 'bg-warning' : 'bg-success') }}"
                                    style="width: {{ min($tasaMorosidad, 100) }}%">
                                </div>
                            </div>
                        </div>

                        <div class="rounded-lg bg-red-50 p-4 dark:bg-red-900/20">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-medium text-black dark:text-white">Cartera Vencida</span>
                                <span class="text-danger font-bold">Q {{ number_format($carteraVencida, 2) }}</span>
                            </div>
                            <p class="text-sm text-body-secondary">{{ $prestamosVencidos }} préstamos en mora</p>
                        </div>

                        <div class="rounded-lg bg-yellow-50 p-4 dark:bg-yellow-900/20">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-medium text-black dark:text-white">Mora Acumulada</span>
                                <span class="text-warning font-bold">Q {{ number_format($moraTotal, 2) }}</span>
                            </div>
                            <p class="text-sm text-body-secondary">Mora cobrada en el período</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Distribuciones -->
        <div class="mb-6 grid grid-cols-1 gap-4 lg:grid-cols-2">
            <!-- Distribución por Frecuencia -->
            <div class="rounded-lg border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                    <h3 class="font-semibold text-black dark:text-white">Distribución por Frecuencia de Pago</h3>
                </div>
                <div class="p-7">
                    @if($distribucionFrecuencia->count() > 0)
                        <div class="space-y-4">
                            @foreach($distribucionFrecuencia as $dist)
                                <div>
                                    <div class="mb-2 flex items-center justify-between">
                                        <span class="font-medium text-black dark:text-white">{{ ucfirst($dist->frecuencia_pago) }}</span>
                                        <span class="text-body-secondary">{{ $dist->total }} préstamos - Q {{ number_format($dist->monto, 2) }}</span>
                                    </div>
                                    <div class="h-3 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                                        <div class="h-full rounded-full bg-primary" style="width: {{ $carteraTotal > 0 ? ($dist->monto / $carteraTotal * 100) : 0 }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-body-secondary py-4">No hay datos disponibles</p>
                    @endif
                </div>
            </div>

            <!-- Distribución por Tipo de Interés -->
            <div class="rounded-lg border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                    <h3 class="font-semibold text-black dark:text-white">Distribución por Tipo de Interés</h3>
                </div>
                <div class="p-7">
                    @if($distribucionInteres->count() > 0)
                        <div class="space-y-4">
                            @foreach($distribucionInteres as $dist)
                                <div>
                                    <div class="mb-2 flex items-center justify-between">
                                        <span class="font-medium text-black dark:text-white">{{ ucfirst($dist->tipo_interes) }}</span>
                                        <span class="text-body-secondary">{{ $dist->total }} préstamos - Q {{ number_format($dist->monto, 2) }}</span>
                                    </div>
                                    <div class="h-3 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                                        <div class="h-full rounded-full bg-warning" style="width: {{ $carteraTotal > 0 ? ($dist->monto / $carteraTotal * 100) : 0 }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-body-secondary py-4">No hay datos disponibles</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top Deudores -->
        <div class="mb-6 rounded-lg border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                <h3 class="font-semibold text-black dark:text-white">Top 10 Clientes con Mayor Deuda</h3>
            </div>
            <div class="p-7">
                @if($topDeudores->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-gray-2 text-left dark:bg-meta-4">
                                    <th class="px-4 py-3 font-medium text-black dark:text-white">#</th>
                                    <th class="px-4 py-3 font-medium text-black dark:text-white">Cliente</th>
                                    <th class="px-4 py-3 font-medium text-black dark:text-white">DPI</th>
                                    <th class="px-4 py-3 font-medium text-black dark:text-white">Saldo Pendiente</th>
                                    <th class="px-4 py-3 font-medium text-black dark:text-white">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topDeudores as $index => $cliente)
                                    @if($cliente->prestamos_sum_saldo_pendiente > 0)
                                        <tr class="border-b border-stroke dark:border-strokedark">
                                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                                            <td class="px-4 py-3">{{ $cliente->nombre_completo }}</td>
                                            <td class="px-4 py-3">{{ $cliente->dpi_formateado }}</td>
                                            <td class="px-4 py-3 font-semibold text-danger">Q {{ number_format($cliente->prestamos_sum_saldo_pendiente, 2) }}</td>
                                            <td class="px-4 py-3">
                                                <a href="{{ route('clientes.show', $cliente) }}" class="text-primary hover:underline">Ver</a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-body-secondary py-4">No hay datos disponibles</p>
                @endif
            </div>
        </div>

        <!-- Actividad del Período -->
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
            <!-- Préstamos Otorgados -->
            <div class="rounded-lg border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                    <h3 class="font-semibold text-black dark:text-white">Préstamos Otorgados en el Período</h3>
                </div>
                <div class="p-7">
                    @if($prestamosDelPeriodo->count() > 0)
                        <div class="space-y-2">
                            @foreach($prestamosDelPeriodo->take(10) as $dia)
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-body-secondary">{{ \Carbon\Carbon::parse($dia->fecha)->format('d/m/Y') }}</span>
                                    <span class="font-medium text-black dark:text-white">{{ $dia->total }} préstamos - Q {{ number_format($dia->monto, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-body-secondary py-4">No hay préstamos en este período</p>
                    @endif
                </div>
            </div>

            <!-- Pagos Recibidos -->
            <div class="rounded-lg border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                    <h3 class="font-semibold text-black dark:text-white">Pagos Recibidos en el Período</h3>
                </div>
                <div class="p-7">
                    @if($pagosDelPeriodo->count() > 0)
                        <div class="space-y-2">
                            @foreach($pagosDelPeriodo->take(10) as $dia)
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-body-secondary">{{ \Carbon\Carbon::parse($dia->fecha)->format('d/m/Y') }}</span>
                                    <span class="font-medium text-success">{{ $dia->total }} pagos - Q {{ number_format($dia->monto, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-body-secondary py-4">No hay pagos en este período</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-tailadmin-layout>
