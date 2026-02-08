<x-flowbite-layout>
    <div class="mb-6 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $receta->nombre }}</h1>
                <div class="flex gap-3">
                    @can('editar-recetas')
                    <a href="{{ route('recetas.edit', $receta) }}" class="text-white bg-blue-700 hover:bg-blue-800 rounded-lg text-sm px-5 py-2.5">Editar</a>
                    @endcan
                    <a href="{{ route('recetas.index') }}" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg text-sm px-5 py-2.5">Volver</a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Tipo de Vivienda</h3>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $receta->tipo_vivienda }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Área Construcción</h3>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $receta->area_construccion ? number_format($receta->area_construccion, 2) . ' m²' : 'N/A' }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Costo Total</h3>
                    <p class="text-lg font-semibold text-green-600 dark:text-green-500">{{ money_symbol($receta->costo_total) }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Materiales</h2>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3">Producto</th>
                                <th class="px-6 py-3">Cantidad</th>
                                <th class="px-6 py-3">Unidad</th>
                                <th class="px-6 py-3">Precio Unit.</th>
                                <th class="px-6 py-3">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($receta->items as $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4 font-medium">{{ $item->producto->nombre }}</td>
                                <td class="px-6 py-4">{{ number_format($item->cantidad, 2) }}</td>
                                <td class="px-6 py-4">{{ $item->unidad }}</td>
                                <td class="px-6 py-4">{{ money_symbol($item->precio_unitario) }}</td>
                                <td class="px-6 py-4 font-medium">{{ money_symbol($item->subtotal) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @if($receta->descripcion || $receta->notas)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                @if($receta->descripcion)
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Descripción</h3>
                    <p class="text-gray-900 dark:text-white">{{ $receta->descripcion }}</p>
                </div>
                @endif
                @if($receta->notas)
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Notas</h3>
                    <p class="text-gray-900 dark:text-white">{{ $receta->notas }}</p>
                </div>
                @endif
            </div>
            @endif
        </div>
</x-flowbite-layout>
