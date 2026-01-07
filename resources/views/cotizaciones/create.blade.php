<x-flowbite-layout>
    <!-- Header -->
    <div class="mb-4">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Nueva Cotización</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Crear una nueva cotización para un cliente</p>
            </div>

            <!-- Formulario -->
            <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-6">
                <form action="{{ route('cotizaciones.store') }}" method="POST" id="cotizacionForm">
                    @csrf

                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <!-- Cliente -->
                        <div>
                            <label for="cliente_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cliente <span class="text-red-600">*</span></label>
                            <select id="cliente_id" name="cliente_id" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('cliente_id') border-red-500 @enderror">
                                <option value="">Seleccione un cliente</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->nombre_completo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cliente_id')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Receta (Opcional) -->
                        <div>
                            <label for="receta_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Receta Base (Opcional)</label>
                            <select id="receta_id" name="receta_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('receta_id') border-red-500 @enderror">
                                <option value="">Sin receta base</option>
                                @foreach($recetas as $receta)
                                    <option value="{{ $receta->id }}" {{ old('receta_id') == $receta->id ? 'selected' : '' }}>
                                        {{ $receta->nombre }} - {{ $receta->tipo_vivienda }}
                                    </option>
                                @endforeach
                            </select>
                            @error('receta_id')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fecha de Emisión -->
                        <div>
                            <label for="fecha_emision" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de Emisión <span class="text-red-600">*</span></label>
                            <input type="date" id="fecha_emision" name="fecha_emision" value="{{ old('fecha_emision', date('Y-m-d')) }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('fecha_emision') border-red-500 @enderror">
                            @error('fecha_emision')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fecha de Vencimiento -->
                        <div>
                            <label for="fecha_vencimiento" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de Vencimiento <span class="text-red-600">*</span></label>
                            <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" value="{{ old('fecha_vencimiento', date('Y-m-d', strtotime('+30 days'))) }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('fecha_vencimiento') border-red-500 @enderror">
                            @error('fecha_vencimiento')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Descuento -->
                        <div>
                            <label for="descuento" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descuento (Q)</label>
                            <input type="number" id="descuento" name="descuento" value="{{ old('descuento', '0.00') }}" step="0.01" min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('descuento') border-red-500 @enderror">
                            @error('descuento')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Notas -->
                    <div class="mb-6">
                        <label for="notas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notas</label>
                        <textarea id="notas" name="notas" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('notas') border-red-500 @enderror">{{ old('notas') }}</textarea>
                        @error('notas')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Términos y Condiciones -->
                    <div class="mb-6">
                        <label for="terminos_condiciones" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Términos y Condiciones</label>
                        <textarea id="terminos_condiciones" name="terminos_condiciones" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('terminos_condiciones') border-red-500 @enderror">{{ old('terminos_condiciones') }}</textarea>
                        @error('terminos_condiciones')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Productos -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Productos</h3>
                            <button type="button" id="addProductoBtn" class="inline-flex items-center text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"/>
                                </svg>
                                Agregar Producto
                            </button>
                        </div>

                        <div id="productosContainer" class="space-y-4">
                            <!-- Los productos se agregarán aquí dinámicamente -->
                        </div>

                        <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Subtotal:</span>
                                    <span id="subtotalDisplay" class="text-sm font-bold text-gray-900 dark:text-white">Q 0.00</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Descuento:</span>
                                    <span id="descuentoDisplay" class="text-sm font-bold text-green-600 dark:text-green-400">Q 0.00</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-medium text-gray-900 dark:text-white">Total:</span>
                                    <span id="totalDisplay" class="text-xl font-bold text-blue-600 dark:text-blue-400">Q 0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex gap-4">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Guardar Cotización
                        </button>
                        <a href="{{ route('cotizaciones.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>

    <!-- Template para productos -->
    <script type="text/template" id="productoTemplate">
        <div class="producto-row bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border">
            <div class="grid gap-4 md:grid-cols-6 items-end">
                <div class="md:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Producto</label>
                    <select name="productos[{index}][producto_id]" required class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white producto-select">
                        <option value="">Seleccione un producto</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}" data-precio="{{ $producto->precio_unitario }}" data-unidad="{{ $producto->unidad_medida }}" data-descripcion="{{ $producto->nombre }}">
                                {{ $producto->codigo }} - {{ $producto->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cantidad</label>
                    <input type="number" name="productos[{index}][cantidad]" step="0.01" min="0.01" required class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white producto-cantidad">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unidad</label>
                    <input type="text" name="productos[{index}][unidad]" readonly class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white producto-unidad">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio Unit.</label>
                    <input type="number" name="productos[{index}][precio_unitario]" step="0.01" min="0" required class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white producto-precio">
                </div>
                <div class="flex gap-2">
                    <div class="flex-1">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Subtotal</label>
                        <input type="number" name="productos[{index}][subtotal]" step="0.01" readonly class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white producto-subtotal">
                    </div>
                    <button type="button" class="remove-producto-btn text-red-600 hover:text-red-800 p-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="mt-3">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                <input type="text" name="productos[{index}][descripcion]" class="block p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white producto-descripcion">
            </div>
        </div>
    </script>

    <script>
        let productoIndex = 0;

        document.getElementById('addProductoBtn').addEventListener('click', function() {
            addProducto();
        });

        // Cargar productos desde receta si se selecciona
        document.getElementById('receta_id').addEventListener('change', function() {
            const recetaId = this.value;
            if (recetaId) {
                loadRecetaProductos(recetaId);
            }
        });

        function addProducto(productoData = null) {
            const template = document.getElementById('productoTemplate').innerHTML;
            const productoHtml = template.replace(/{index}/g, productoIndex);
            const container = document.getElementById('productosContainer');
            container.insertAdjacentHTML('beforeend', productoHtml);

            // Agregar event listeners al nuevo producto
            const newProducto = container.lastElementChild;
            setupProductoListeners(newProducto);

            // Si hay datos del producto, cargarlos
            if (productoData) {
                const select = newProducto.querySelector('.producto-select');
                const cantidad = newProducto.querySelector('.producto-cantidad');
                const precio = newProducto.querySelector('.producto-precio');
                const descripcion = newProducto.querySelector('.producto-descripcion');

                select.value = productoData.producto_id;
                cantidad.value = productoData.cantidad;
                precio.value = productoData.precio_unitario;
                descripcion.value = productoData.descripcion || productoData.producto?.nombre || '';

                // Trigger change event to update unidad and subtotal
                select.dispatchEvent(new Event('change'));
            }

            productoIndex++;
        }

        function setupProductoListeners(producto) {
            const productoSelect = producto.querySelector('.producto-select');
            const cantidadInput = producto.querySelector('.producto-cantidad');
            const precioInput = producto.querySelector('.producto-precio');
            const subtotalInput = producto.querySelector('.producto-subtotal');
            const unidadInput = producto.querySelector('.producto-unidad');
            const descripcionInput = producto.querySelector('.producto-descripcion');
            const removeBtn = producto.querySelector('.remove-producto-btn');

            productoSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const precio = selectedOption.getAttribute('data-precio') || 0;
                const unidad = selectedOption.getAttribute('data-unidad') || '';
                const descripcion = selectedOption.getAttribute('data-descripcion') || '';

                precioInput.value = precio;
                unidadInput.value = unidad;
                if (!descripcionInput.value) {
                    descripcionInput.value = descripcion;
                }
                calculateProductoSubtotal(cantidadInput, precioInput, subtotalInput);
                updateTotal();
            });

            cantidadInput.addEventListener('input', function() {
                calculateProductoSubtotal(this, precioInput, subtotalInput);
                updateTotal();
            });

            precioInput.addEventListener('input', function() {
                calculateProductoSubtotal(cantidadInput, this, subtotalInput);
                updateTotal();
            });

            removeBtn.addEventListener('click', function() {
                producto.remove();
                updateTotal();
            });
        }

        function calculateProductoSubtotal(cantidadInput, precioInput, subtotalInput) {
            const cantidad = parseFloat(cantidadInput.value) || 0;
            const precio = parseFloat(precioInput.value) || 0;
            const subtotal = cantidad * precio;
            subtotalInput.value = subtotal.toFixed(2);
        }

        function updateTotal() {
            let subtotal = 0;
            document.querySelectorAll('.producto-subtotal').forEach(function(input) {
                subtotal += parseFloat(input.value) || 0;
            });

            const descuento = parseFloat(document.getElementById('descuento').value) || 0;
            const total = subtotal - descuento;

            document.getElementById('subtotalDisplay').textContent = 'Q ' + subtotal.toFixed(2);
            document.getElementById('descuentoDisplay').textContent = 'Q ' + descuento.toFixed(2);
            document.getElementById('totalDisplay').textContent = 'Q ' + total.toFixed(2);
        }

        function loadRecetaProductos(recetaId) {
            // Limpiar productos existentes
            document.getElementById('productosContainer').innerHTML = '';

            // Aquí iría una llamada AJAX para cargar los productos de la receta
            // Por ahora, solo limpiamos y esperamos que el usuario agregue manualmente
            console.log('Cargando productos de receta:', recetaId);
        }

        // Agregar un producto inicial
        addProducto();

        // Actualizar total cuando cambia el descuento
        document.getElementById('descuento').addEventListener('input', updateTotal);
    </script>
</x-flowbite-layout>
