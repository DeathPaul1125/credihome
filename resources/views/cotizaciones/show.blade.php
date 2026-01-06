<x-flowbite-layout>
    <div class="p-4 sm:ml-64">
        <div class="p-4 mt-14">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $cotizacion->numero_cotizacion }}</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Cliente: {{ $cotizacion->cliente->nombre }}</p>
                </div>
                <div class="flex gap-3">
                    @can('editar-cotizaciones')
                    @if(!in_array($cotizacion->estado, ['aprobada', 'convertida', 'rechazada']))
                    <a href="{{ route('cotizaciones.edit', $cotizacion) }}" class="text-white bg-blue-700 hover:bg-blue-800 rounded-lg text-sm px-5 py-2.5">Editar</a>
                    @endif
                    @endcan
                    <a href="{{ route('cotizaciones.index') }}" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg text-sm px-5 py-2.5">Volver</a>
                </div>
            </div>

            @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">{{ session('success') }}</div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
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
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">Q {{ number_format($cotizacion->subtotal, 2) }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Descuento</h3>
                    <p class="text-lg font-semibold text-red-600">Q {{ number_format($cotizacion->descuento, 2) }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Total</h3>
                    <p class="text-lg font-semibold text-green-600">Q {{ number_format($cotizacion->total, 2) }}</p>
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
                            <td class="px-6 py-4">Q {{ number_format($item->precio_unitario, 2) }}</td>
                            <td class="px-6 py-4 font-medium">Q {{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex gap-3">
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
        </div>
    </div>
</x-flowbite-layout>
