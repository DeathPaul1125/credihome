<x-flowbite-layout>
    <!-- Header -->
    <div class="mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $producto->nombre }}</h1>
                <div class="flex gap-2">
                    <a href="{{ route('productos.edit', $producto) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-yellow-400 rounded-lg hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 focus:outline-none">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                        </svg>
                        Editar
                    </a>
                    <a href="{{ route('productos.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                        </svg>
                        Volver
                    </a>
                </div>
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <!-- Información General -->
                <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Información General</h2>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Código:</span>
                            <p class="text-base text-gray-900 dark:text-white">{{ $producto->codigo }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre:</span>
                            <p class="text-base text-gray-900 dark:text-white">{{ $producto->nombre }}</p>
                        </div>
                        @if($producto->descripcion)
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Descripción:</span>
                            <p class="text-base text-gray-900 dark:text-white">{{ $producto->descripcion }}</p>
                        </div>
                        @endif
                        @if($producto->marca)
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Marca:</span>
                            <p class="text-base text-gray-900 dark:text-white">{{ $producto->marca }}</p>
                        </div>
                        @endif
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Categoría:</span>
                            <p class="text-base text-gray-900 dark:text-white">{{ $producto->categoria ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Inventario -->
                <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Inventario</h2>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Unidad de Medida:</span>
                            <p class="text-base text-gray-900 dark:text-white">{{ $producto->unidad_medida ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Stock Actual:</span>
                            <p class="text-base {{ $producto->stock_actual <= $producto->stock_minimo ? 'text-red-600 font-bold' : 'text-gray-900 dark:text-white' }}">
                                {{ $producto->stock_actual }}
                                @if($producto->stock_actual <= $producto->stock_minimo)
                                    <span class="text-sm">(¡Stock bajo!)</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Stock Mínimo:</span>
                            <p class="text-base text-gray-900 dark:text-white">{{ $producto->stock_minimo }}</p>
                        </div>
                    </div>
                </div>

                <!-- Precios -->
                <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Precios</h2>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Precio Unitario:</span>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">Q{{ number_format($producto->precio_unitario, 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Estado -->
                <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Estado</h2>
                    <div class="space-y-3">
                        <div>
                            @if($producto->estado === 'activo')
                                <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded dark:bg-green-900 dark:text-green-300">Activo</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 text-sm font-medium px-3 py-1 rounded dark:bg-gray-700 dark:text-gray-300">Inactivo</span>
                            @endif
                        </div>
                        @if($producto->created_at)
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Creado:</span>
                            <p class="text-base text-gray-900 dark:text-white">{{ $producto->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif
                        @if($producto->updated_at)
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Última actualización:</span>
                            <p class="text-base text-gray-900 dark:text-white">{{ $producto->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Notas -->
            @if($producto->notas)
            <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Notas</h2>
                <p class="text-base text-gray-900 dark:text-white whitespace-pre-line">{{ $producto->notas }}</p>
            </div>
    @endif
</x-flowbite-layout>
