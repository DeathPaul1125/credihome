<x-flowbite-layout>
    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">💰 Historial de Movimientos</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                Inversionista: <span class="font-semibold">{{ $aportador->nombre }}</span>
            </p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('aportadores.show', $aportador) }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                Ver Perfil
            </a>
            <a href="{{ route('aportadores.index') }}" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                Volver al Listado
            </a>
        </div>
    </div>

    <!-- Resumen de Capital -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Capital Disponible</h3>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400 mt-2">{{ money_symbol($aportador->capital_disponible) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Capital Invertido</h3>
            <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400 mt-2">{{ money_symbol($aportador->capital_invertido) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Capital Recuperado</h3>
            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-2">{{ money_symbol($aportador->capital_recuperado) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Ganancias Totales</h3>
            <p class="text-2xl font-bold text-purple-600 dark:text-purple-400 mt-2">{{ money_symbol($aportador->ganancias_totales) }}</p>
        </div>
    </div>

    <!-- Tabla de Movimientos -->
    @if($movimientos->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                Detalle de Movimientos
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400 ml-2">({{ $movimientos->count() }} movimientos)</span>
            </h2>
        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">Fecha</th>
                        <th class="px-6 py-3">Tipo</th>
                        <th class="px-6 py-3">Descripción</th>
                        <th class="px-6 py-3">Referencia</th>
                        <th class="px-6 py-3 text-right">Monto</th>
                        <th class="px-6 py-3 text-right">Saldo Anterior</th>
                        <th class="px-6 py-3 text-right">Saldo Después</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($movimientos as $movimiento)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($movimiento['fecha'])->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($movimiento['tipo'] === 'inversion')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Inversión
                                </span>
                            @elseif($movimiento['tipo'] === 'recuperacion_capital')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                    Recuperación Capital
                                </span>
                            @elseif($movimiento['tipo'] === 'interes')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                    </svg>
                                    Intereses
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                    {{ ucfirst($movimiento['tipo']) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $movimiento['descripcion'] }}</td>
                        <td class="px-6 py-4">
                            @if($movimiento['prestamo_id'])
                                <a href="{{ route('prestamos.show', $movimiento['prestamo_id']) }}" class="text-blue-600 hover:underline dark:text-blue-400">
                                    {{ $movimiento['referencia'] }}
                                </a>
                            @else
                                <span class="text-gray-500">{{ $movimiento['referencia'] ?? '-' }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right font-medium">
                            <span class="{{ $movimiento['monto'] < 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                {{ $movimiento['monto'] < 0 ? '-' : '+' }}{{ money_symbol(abs($movimiento['monto'])) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-gray-600 dark:text-gray-400">
                            {{ money_symbol($movimiento['capital_disponible_antes']) }}
                        </td>
                        <td class="px-6 py-4 text-right font-semibold text-gray-900 dark:text-white">
                            {{ money_symbol($movimiento['capital_disponible_despues']) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <td colspan="7" class="px-6 py-3 text-xs text-gray-500 dark:text-gray-400 text-center">
                            <div class="flex items-center justify-center gap-4">
                                <span class="inline-flex items-center">
                                    <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                    Salida: Inversión en préstamos
                                </span>
                                <span class="inline-flex items-center">
                                    <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                    Entrada: Recuperación de capital
                                </span>
                                <span class="inline-flex items-center">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                    Entrada: Ganancias por intereses
                                </span>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @else
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-12 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No hay movimientos</h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Este inversionista aún no tiene movimientos registrados.</p>
    </div>
    @endif
</x-flowbite-layout>
