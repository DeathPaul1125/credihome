<x-flowbite-layout>
    <!-- Header -->
    <div class="mb-4">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Editar Producto</h1>
    </div>

            <!-- Formulario -->
            <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-6">
                <form action="{{ route('productos.update', $producto) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <!-- Código -->
                        <div>
                            <label for="codigo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Código <span class="text-red-600">*</span></label>
                            <input type="text" id="codigo" name="codigo" value="{{ old('codigo', $producto->codigo) }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('codigo') border-red-500 @enderror">
                            @error('codigo')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nombre -->
                        <div>
                            <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre <span class="text-red-600">*</span></label>
                            <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('nombre') border-red-500 @enderror">
                            @error('nombre')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Categoría -->
                        <div>
                            <label for="categoria" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categoría</label>
                            <select id="categoria" name="categoria" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('categoria') border-red-500 @enderror">
                                <option value="">Seleccione una categoría</option>
                                <option value="Cemento" {{ old('categoria', $producto->categoria) == 'Cemento' ? 'selected' : '' }}>Cemento</option>
                                <option value="Hierro" {{ old('categoria', $producto->categoria) == 'Hierro' ? 'selected' : '' }}>Hierro</option>
                                <option value="Blocks" {{ old('categoria', $producto->categoria) == 'Blocks' ? 'selected' : '' }}>Blocks</option>
                                <option value="Arena" {{ old('categoria', $producto->categoria) == 'Arena' ? 'selected' : '' }}>Arena</option>
                                <option value="Grava" {{ old('categoria', $producto->categoria) == 'Grava' ? 'selected' : '' }}>Grava</option>
                                <option value="Madera" {{ old('categoria', $producto->categoria) == 'Madera' ? 'selected' : '' }}>Madera</option>
                                <option value="Tubería" {{ old('categoria', $producto->categoria) == 'Tubería' ? 'selected' : '' }}>Tubería</option>
                                <option value="Eléctricos" {{ old('categoria', $producto->categoria) == 'Eléctricos' ? 'selected' : '' }}>Eléctricos</option>
                                <option value="Pintura" {{ old('categoria', $producto->categoria) == 'Pintura' ? 'selected' : '' }}>Pintura</option>
                                <option value="Acabados" {{ old('categoria', $producto->categoria) == 'Acabados' ? 'selected' : '' }}>Acabados</option>
                                <option value="Otros" {{ old('categoria', $producto->categoria) == 'Otros' ? 'selected' : '' }}>Otros</option>
                            </select>
                            @error('categoria')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Unidad de Medida -->
                        <div>
                            <label for="unidad_medida" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unidad de Medida</label>
                            <select id="unidad_medida" name="unidad_medida" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('unidad_medida') border-red-500 @enderror">
                                <option value="">Seleccione una unidad</option>
                                <option value="Unidad" {{ old('unidad_medida', $producto->unidad_medida) == 'Unidad' ? 'selected' : '' }}>Unidad</option>
                                <option value="Saco" {{ old('unidad_medida', $producto->unidad_medida) == 'Saco' ? 'selected' : '' }}>Saco</option>
                                <option value="m²" {{ old('unidad_medida', $producto->unidad_medida) == 'm²' ? 'selected' : '' }}>m²</option>
                                <option value="m³" {{ old('unidad_medida', $producto->unidad_medida) == 'm³' ? 'selected' : '' }}>m³</option>
                                <option value="Litro" {{ old('unidad_medida', $producto->unidad_medida) == 'Litro' ? 'selected' : '' }}>Litro</option>
                                <option value="Galón" {{ old('unidad_medida', $producto->unidad_medida) == 'Galón' ? 'selected' : '' }}>Galón</option>
                                <option value="Varilla" {{ old('unidad_medida', $producto->unidad_medida) == 'Varilla' ? 'selected' : '' }}>Varilla</option>
                                <option value="Lámina" {{ old('unidad_medida', $producto->unidad_medida) == 'Lámina' ? 'selected' : '' }}>Lámina</option>
                            </select>
                            @error('unidad_medida')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Precio Unitario -->
                        <div>
                            <label for="precio_unitario" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio Unitario (Q)</label>
                            <input type="number" id="precio_unitario" name="precio_unitario" value="{{ old('precio_unitario', $producto->precio_unitario) }}" step="0.01" min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('precio_unitario') border-red-500 @enderror">
                            @error('precio_unitario')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stock Actual -->
                        <div>
                            <label for="stock_actual" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock Actual</label>
                            <input type="number" id="stock_actual" name="stock_actual" value="{{ old('stock_actual', $producto->stock_actual) }}" min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('stock_actual') border-red-500 @enderror">
                            @error('stock_actual')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stock Mínimo -->
                        <div>
                            <label for="stock_minimo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock Mínimo</label>
                            <input type="number" id="stock_minimo" name="stock_minimo" value="{{ old('stock_minimo', $producto->stock_minimo) }}" min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('stock_minimo') border-red-500 @enderror">
                            @error('stock_minimo')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Marca -->
                        <div>
                            <label for="marca" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Marca</label>
                            <input type="text" id="marca" name="marca" value="{{ old('marca', $producto->marca) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('marca') border-red-500 @enderror">
                            @error('marca')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Estado -->
                        <div>
                            <label for="estado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                            <select id="estado" name="estado" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('estado') border-red-500 @enderror">
                                <option value="activo" {{ old('estado', $producto->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ old('estado', $producto->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            @error('estado')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-6">
                        <label for="descripcion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                        <textarea id="descripcion" name="descripcion" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $producto->descripcion) }}</textarea>
                        @error('descripcion')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notas -->
                    <div class="mb-6">
                        <label for="notas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notas</label>
                        <textarea id="notas" name="notas" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('notas') border-red-500 @enderror">{{ old('notas', $producto->notas) }}</textarea>
                        @error('notas')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botones -->
                    <div class="flex gap-4">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Actualizar Producto
                        </button>
                        <a href="{{ route('productos.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            Cancelar
                        </a>
            </div>
        </form>
    </div>
</x-flowbite-layout>
