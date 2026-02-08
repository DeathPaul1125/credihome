<x-flowbite-layout>
    <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $cotizacion->numero_cotizacion }}</h1>
                    @if($cotizacion->cliente)
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Cliente: {{ $cotizacion->cliente->nombre_completo }}</p>
                    @else
                    <p class="text-red-600 dark:text-red-400 mt-1">Cliente no disponible</p>
                    @endif
                </div>
                <div class="flex gap-3">
                    @can('editar-cotizaciones')
                    @if(!in_array($cotizacion->estado, ['aprobada', 'convertida', 'rechazada']))
                    <a href="{{ route('cotizaciones.edit', $cotizacion) }}" class="text-white bg-blue-700 hover:bg-blue-800 rounded-lg text-sm px-5 py-2.5">Editar</a>
                    @endif
                    @endcan

                    <!-- Botones de PDF -->
                    <a href="{{ route('cotizaciones.pdf', $cotizacion) }}" target="_blank" class="inline-flex items-center text-white bg-red-700 hover:bg-red-800 rounded-lg text-sm px-5 py-2.5">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z"/>
                            <path d="M3 8a2 2 0 012-2v10h8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
                        </svg>
                        PDF Completo
                    </a>
                    @if($cotizacion->plazo_meses && $cotizacion->tasa_interes_anual)
                    <a href="{{ route('cotizaciones.pdf-amortizacion', $cotizacion) }}" target="_blank" class="inline-flex items-center text-white bg-purple-700 hover:bg-purple-800 rounded-lg text-sm px-5 py-2.5">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z"/>
                        </svg>
                        PDF Amortización
                    </a>
                    @endif

                    <a href="{{ route('cotizaciones.index') }}" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg text-sm px-5 py-2.5">Volver</a>
                </div>
            </div>

            @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">{{ session('success') }}</div>
            @endif

            @if($cotizacion->prestamo_id && $cotizacion->prestamo)
            <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
                <svg class="flex-shrink-0 inline w-5 h-5 me-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div class="flex items-center justify-between w-full">
                    <span>
                        <strong>✓ Cotización Convertida:</strong>
                        Esta cotización fue convertida en el préstamo {{ $cotizacion->prestamo->numero_prestamo }}
                    </span>
                    <a href="{{ route('prestamos.show', $cotizacion->prestamo) }}" class="ml-4 text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 font-semibold flex items-center">
                        Ver Préstamo
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Estado</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-sm font-medium
                        @if($cotizacion->estado === 'pendiente') bg-yellow-100 text-yellow-800
                        @elseif($cotizacion->estado === 'aprobada') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($cotizacion->estado) }}
                    </span>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Subtotal</h3>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ money_symbol($cotizacion->subtotal) }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Total</h3>
                    <p class="text-lg font-semibold text-green-600">{{ money_symbol($cotizacion->total) }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Productos</h2>
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3">Descripción</th>
                            <th class="px-6 py-3">Cantidad</th>
                            <th class="px-6 py-3">Unidad</th>
                            <th class="px-6 py-3">Precio Unit.</th>
                            <th class="px-6 py-3">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cotizacion->items as $item)
                        <tr class="border-b dark:border-gray-700">
                            <td class="px-6 py-4">{{ $item->descripcion }}</td>
                            <td class="px-6 py-4">{{ number_format($item->cantidad, 2) }}</td>
                            <td class="px-6 py-4">{{ $item->unidad }}</td>
                            <td class="px-6 py-4">{{ money_symbol($item->precio_unitario) }}</td>
                            <td class="px-6 py-4 font-medium">{{ money_symbol($item->subtotal) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($cotizacion->plazo_meses && $cotizacion->tasa_interes_anual)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mt-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Plan de Financiamiento</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Plazo</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $cotizacion->plazo_meses }} meses</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Tasa de Interés Anual</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ percentage($cotizacion->tasa_interes_anual) }}</p>
                    </div>
                    @if($cotizacion->enganche > 0)
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Enganche</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ money_symbol($cotizacion->enganche) }}</p>
                    </div>
                    @endif
                </div>

                <div class="bg-blue-50 dark:bg-gray-700 p-4 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        Monto a Financiar: <span class="font-bold">{{ money_symbol($cotizacion->total - ($cotizacion->enganche ?? 0)) }}</span>
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        * Para ver la tabla de amortización completa, descargue el PDF de Amortización
                    </p>
                </div>
            </div>
            @endif

            <div class="flex gap-3 mt-6">
                @can('aprobar-cotizaciones')
                @if($cotizacion->estado === 'pendiente')
                <form action="{{ route('cotizaciones.aprobar', $cotizacion) }}" method="POST">
                    @csrf
                    <button type="submit" class="text-white bg-green-700 hover:bg-green-800 rounded-lg text-sm px-5 py-2.5">Aprobar Cotización</button>
                </form>
                @endif
                @endcan
                @can('convertir-cotizaciones')
                @if($cotizacion->estado === 'aprobada' && !$cotizacion->prestamo_id)
                <form action="{{ route('cotizaciones.convertir', $cotizacion) }}" method="POST">
                    @csrf
                    <button type="submit" class="text-white bg-purple-700 hover:bg-purple-800 rounded-lg text-sm px-5 py-2.5">Convertir a Préstamo</button>
                </form>
                @endif
                @endcan
            </div>
</x-flowbite-layout>
