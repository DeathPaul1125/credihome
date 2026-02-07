<x-flowbite-layout>
    <!-- Header -->
    <div class="mb-4">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Editar Plan de Construcción</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Modificar el plan: {{ $receta->nombre }}</p>
            </div>

            <!-- Formulario -->
            <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-6">
                <form action="{{ route('recetas.update', $receta) }}" method="POST" id="recetaForm">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <!-- Nombre -->
                        <div>
                            <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del Plan <span class="text-red-600">*</span></label>
                            <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $receta->nombre) }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('nombre') border-red-500 @enderror">
                            @error('nombre')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipo de Vivienda -->
                        <div>
                            <label for="tipo_vivienda" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de Vivienda <span class="text-red-600">*</span></label>
                            <select id="tipo_vivienda" name="tipo_vivienda" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('tipo_vivienda') border-red-500 @enderror">
                                <option value="">Seleccione un tipo</option>
                                <option value="casa_basica" {{ old('tipo_vivienda', $receta->tipo_vivienda) == 'casa_basica' ? 'selected' : '' }}>Casa Básica</option>
                                <option value="casa_mediana" {{ old('tipo_vivienda', $receta->tipo_vivienda) == 'casa_mediana' ? 'selected' : '' }}>Casa Mediana</option>
                                <option value="casa_grande" {{ old('tipo_vivienda', $receta->tipo_vivienda) == 'casa_grande' ? 'selected' : '' }}>Casa Grande</option>
                                <option value="apartamento" {{ old('tipo_vivienda', $receta->tipo_vivienda) == 'apartamento' ? 'selected' : '' }}>Apartamento</option>
                                <option value="ampliacion" {{ old('tipo_vivienda', $receta->tipo_vivienda) == 'ampliacion' ? 'selected' : '' }}>Ampliación</option>
                                <option value="oficina" {{ old('tipo_vivienda', $receta->tipo_vivienda) == 'oficina' ? 'selected' : '' }}>Oficina</option>
                                <option value="local_comercial" {{ old('tipo_vivienda', $receta->tipo_vivienda) == 'local_comercial' ? 'selected' : '' }}>Local Comercial</option>
                                <option value="otro" {{ old('tipo_vivienda', $receta->tipo_vivienda) == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('tipo_vivienda')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Área de Construcción -->
                        <div>
                            <label for="area_construccion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Área de Construcción (m²)</label>
                            <input type="number" id="area_construccion" name="area_construccion" value="{{ old('area_construccion', $receta->area_construccion) }}" step="0.01" min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('area_construccion') border-red-500 @enderror">
                            @error('area_construccion')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cliente -->
                        <div>
                            <label for="cliente_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cliente (Opcional)</label>
                            <select id="cliente_id" name="cliente_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('cliente_id') border-red-500 @enderror">
                                <option value="">Sin cliente específico</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('cliente_id', $receta->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->nombre_completo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cliente_id')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Es Plantilla -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">¿Es una plantilla general?</label>
                            <div class="flex items-center">
                                <input type="checkbox" id="es_plantilla" name="es_plantilla" value="1" {{ old('es_plantilla', $receta->es_plantilla) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="es_plantilla" class="ml-2 text-sm font-medium text-gray-900 dark:text-white">Sí, es una plantilla reutilizable</label>
                            </div>
                        </div>

                        <!-- Estado -->
                        <div>
                            <label for="estado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                            <select id="estado" name="estado" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('estado') border-red-500 @enderror">
                                <option value="activo" {{ old('estado', $receta->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ old('estado', $receta->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            @error('estado')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-6">
                        <label for="descripcion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                        <textarea id="descripcion" name="descripcion" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $receta->descripcion) }}</textarea>
                        @error('descripcion')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                    </div>

                    <!-- Notas -->
                    <div class="mb-6">
                        <label for="notas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notas</label>
                        <textarea id="notas" name="notas" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('notas') border-red-500 @enderror">{{ old('notas', $receta->notas) }}</textarea>
                        @error('notas')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Materiales -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Materiales</h3>
                            <button type="button" id="addItemBtn" class="inline-flex items-center text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"/>
                                </svg>
                                Agregar Material
                            </button>
                        </div>

                        <div id="itemsContainer" class="space-y-4">
                            <!-- Los items existentes se cargarán aquí -->
                            @foreach($receta->items as $index => $item)
                            <div class="item-row bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border">
                                <div class="grid gap-4 md:grid-cols-5 items-end">
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Producto</label>
                                        <select name="productos[{{ $index }}][producto_id]" required class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                            <option value="">Seleccione un producto</option>
                                            @foreach($productos as $producto)
                                                <option value="{{ $producto->id }}" data-precio="{{ $producto->precio_unitario }}" data-unidad="{{ $producto->unidad_medida }}" {{ $item->producto_id == $producto->id ? 'selected' : '' }}>
                                                    {{ $producto->codigo }} - {{ $producto->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cantidad</label>
                                        <input type="number" name="productos[{{ $index }}][cantidad]" value="{{ old('productos.' . $index . '.cantidad', $item->cantidad) }}" step="0.01" min="0.01" required class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white item-cantidad">
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unidad</label>
                                        <input type="text" name="productos[{{ $index }}][unidad]" value="{{ old('productos.' . $index . '.unidad', $item->unidad) }}" readonly class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white item-unidad">
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio Unit.</label>
                                        <input type="number" name="productos[{{ $index }}][precio_unitario]" value="{{ old('productos.' . $index . '.precio_unitario', $item->precio_unitario) }}" step="0.01" min="0" required class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white item-precio">
                                    </div>
                                    <div class="flex gap-2">
                                        <div class="flex-1">
                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Subtotal</label>
                                            <input type="number" name="productos[{{ $index }}][subtotal]" value="{{ old('productos.' . $index . '.subtotal', $item->subtotal) }}" step="0.01" readonly class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white item-subtotal">
                                        </div>
                                        <button type="button" class="remove-item-btn text-red-600 hover:text-red-800 p-2">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notas del material</label>
                                    <textarea name="productos[{{ $index }}][notas]" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">{{ old('productos.' . $index . '.notas', $item->notas) }}</textarea>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-medium text-gray-900 dark:text-white">Costo Total Estimado:</span>
                                <span id="costoTotal" class="text-xl font-bold text-green-600 dark:text-green-400">Q {{ number_format($receta->costo_total ?? 0, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex gap-4">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Actualizar Plan
                        </button>
                        <a href="{{ route('recetas.show', $receta) }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            Ver Plan
                        </a>
                        <a href="{{ route('recetas.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>

    <!-- Template para items -->
    <script type="text/template" id="itemTemplate">
        <div class="item-row bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border">
            <div class="grid gap-4 md:grid-cols-5 items-end">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Producto</label>
                    <select name="productos[{index}][producto_id]" required class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                        <option value="">Seleccione un producto</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}" data-precio="{{ $producto->precio_unitario }}" data-unidad="{{ $producto->unidad_medida }}">
                                {{ $producto->codigo }} - {{ $producto->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cantidad</label>
                    <input type="number" name="productos[{index}][cantidad]" step="0.01" min="0.01" required class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white item-cantidad">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unidad</label>
                    <input type="text" name="productos[{index}][unidad]" readonly class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white item-unidad">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio Unit.</label>
                    <input type="number" name="productos[{index}][precio_unitario]" step="0.01" min="0" required class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white item-precio">
                </div>
                <div class="flex gap-2">
                    <div class="flex-1">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Subtotal</label>
                        <input type="number" name="productos[{index}][subtotal]" step="0.01" readonly class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white item-subtotal">
                    </div>
                    <button type="button" class="remove-item-btn text-red-600 hover:text-red-800 p-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="mt-3">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notas del material</label>
                <textarea name="productos[{index}][notas]" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"></textarea>
            </div>
        </div>
    </script>

    <script>
        let itemIndex = {{ count($receta->items) }};

        document.getElementById('addItemBtn').addEventListener('click', function() {
            addItem();
        });

        function addItem() {
            const template = document.getElementById('itemTemplate').innerHTML;
            const itemHtml = template.replace(/{index}/g, itemIndex);
            const container = document.getElementById('itemsContainer');
            container.insertAdjacentHTML('beforeend', itemHtml);

            // Agregar event listeners al nuevo item
            const newItem = container.lastElementChild;
            setupItemListeners(newItem);

            itemIndex++;
        }

        function setupItemListeners(item) {
            const productoSelect = item.querySelector('select[name*="[producto_id]"]');
            const cantidadInput = item.querySelector('.item-cantidad');
            const precioInput = item.querySelector('.item-precio');
            const subtotalInput = item.querySelector('.item-subtotal');
            const unidadInput = item.querySelector('.item-unidad');
            const removeBtn = item.querySelector('.remove-item-btn');

            productoSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const precio = selectedOption.getAttribute('data-precio') || 0;
                const unidad = selectedOption.getAttribute('data-unidad') || '';

                precioInput.value = precio;
                unidadInput.value = unidad;
                calculateSubtotal(cantidadInput, precioInput, subtotalInput);
                updateTotal();
            });

            cantidadInput.addEventListener('input', function() {
                calculateSubtotal(this, precioInput, subtotalInput);
                updateTotal();
            });

            precioInput.addEventListener('input', function() {
                calculateSubtotal(cantidadInput, this, subtotalInput);
                updateTotal();
            });

            removeBtn.addEventListener('click', function() {
                item.remove();
                updateTotal();
            });
        }

        function calculateSubtotal(cantidadInput, precioInput, subtotalInput) {
            const cantidad = parseFloat(cantidadInput.value) || 0;
            const precio = parseFloat(precioInput.value) || 0;
            const subtotal = cantidad * precio;
            subtotalInput.value = subtotal.toFixed(2);
        }

        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.item-subtotal').forEach(function(input) {
                total += parseFloat(input.value) || 0;
            });
            document.getElementById('costoTotal').textContent = 'Q ' + total.toFixed(2);
        }

        // Configurar listeners para items existentes
        document.querySelectorAll('.item-row').forEach(function(item) {
            setupItemListeners(item);
        });

        // Calcular total inicial
        updateTotal();
    </script>
</x-flowbite-layout>
