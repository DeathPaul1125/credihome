<x-flowbite-layout>
    <!-- Header -->
    <div class="mb-4">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Editar Cotización</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Modificar la cotización: {{ $cotizacion->numero_cotizacion }}</p>
            </div>

            <!-- Formulario -->
            <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-6">
                <form action="{{ route('cotizaciones.update', $cotizacion) }}" method="POST" id="cotizacionForm">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <!-- Cliente -->
                        <div>
                            <label for="cliente_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cliente <span class="text-red-600">*</span></label>
                            <select id="cliente_id" name="cliente_id" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('cliente_id') border-red-500 @enderror">
                                <option value="">Seleccione un cliente</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('cliente_id', $cotizacion->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->nombre_completo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cliente_id')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Plan de Construcción (Opcional) -->
                        <div>
                            <label for="receta_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Plan de Construcción Base (Opcional)</label>
                            <select id="receta_id" name="receta_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('receta_id') border-red-500 @enderror">
                                <option value="">Sin plan base</option>
                                @foreach($recetas as $receta)
                                    <option value="{{ $receta->id }}" {{ old('receta_id', $cotizacion->receta_id) == $receta->id ? 'selected' : '' }}>
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
                            <input type="date" id="fecha_emision" name="fecha_emision" value="{{ old('fecha_emision', $cotizacion->fecha_emision->format('Y-m-d')) }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('fecha_emision') border-red-500 @enderror">
                            @error('fecha_emision')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fecha de Vencimiento -->
                        <div>
                            <label for="fecha_vencimiento" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de Vencimiento <span class="text-red-600">*</span></label>
                            <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" value="{{ old('fecha_vencimiento', $cotizacion->fecha_vencimiento->format('Y-m-d')) }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('fecha_vencimiento') border-red-500 @enderror">
                            @error('fecha_vencimiento')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Descuento -->
                        <div>
                            <label for="descuento" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descuento (Q)</label>
                            <input type="number" id="descuento" name="descuento" value="{{ old('descuento', $cotizacion->descuento) }}" step="0.01" min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('descuento') border-red-500 @enderror">
                            @error('descuento')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Estado -->
                        <div>
                            <label for="estado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                            <select id="estado" name="estado" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('estado') border-red-500 @enderror">
                                <option value="pendiente" {{ old('estado', $cotizacion->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="aprobada" {{ old('estado', $cotizacion->estado) == 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                                <option value="rechazada" {{ old('estado', $cotizacion->estado) == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                                <option value="vencida" {{ old('estado', $cotizacion->estado) == 'vencida' ? 'selected' : '' }}>Vencida</option>
                                <option value="convertida" {{ old('estado', $cotizacion->estado) == 'convertida' ? 'selected' : '' }}>Convertida</option>
                            </select>
                            @error('estado')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Tipo de Venta -->
                    <div class="mb-6">
                        <label for="tipo_venta" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de Venta <span class="text-red-600">*</span></label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative flex items-center p-4 cursor-pointer bg-gray-50 dark:bg-gray-700 border-2 rounded-lg transition-all hover:shadow-md tipo-venta-option" data-tipo="contado">
                                <input type="radio" id="tipo_venta_contado" name="tipo_venta" value="contado" {{ old('tipo_venta', $cotizacion->tipo_venta ?? 'credito') == 'contado' ? 'checked' : '' }} class="hidden tipo-venta-radio">
                                <div class="flex items-center gap-3 w-full">
                                    <div class="flex-shrink-0">
                                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="flex-grow">
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white">Contado</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Pago único sin intereses</p>
                                    </div>
                                    <div class="radio-indicator hidden">
                                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                            </label>
                            <label class="relative flex items-center p-4 cursor-pointer bg-gray-50 dark:bg-gray-700 border-2 rounded-lg transition-all hover:shadow-md tipo-venta-option" data-tipo="credito">
                                <input type="radio" id="tipo_venta_credito" name="tipo_venta" value="credito" {{ old('tipo_venta', $cotizacion->tipo_venta ?? 'credito') == 'credito' ? 'checked' : '' }} class="hidden tipo-venta-radio">
                                <div class="flex items-center gap-3 w-full">
                                    <div class="flex-shrink-0">
                                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="flex-grow">
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white">Crédito</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Pago en cuotas con intereses</p>
                                    </div>
                                    <div class="radio-indicator hidden">
                                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('tipo_venta')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notas -->
                    <div class="mb-6">
                        <label for="notas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notas</label>
                        <textarea id="notas" name="notas" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('notas') border-red-500 @enderror">{{ old('notas', $cotizacion->notas) }}</textarea>
                        @error('notas')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Términos y Condiciones -->
                    <div class="mb-6">
                        <label for="terminos_condiciones" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Términos y Condiciones</label>
                        <textarea id="terminos_condiciones" name="terminos_condiciones" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('terminos_condiciones') border-red-500 @enderror">{{ old('terminos_condiciones', $cotizacion->terminos_condiciones) }}</textarea>
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
                            <!-- Los productos existentes se cargarán aquí -->
                            @foreach($cotizacion->items as $index => $item)
                            <div class="producto-row bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border">
                                <div class="grid gap-4 md:grid-cols-6 items-end">
                                    <div class="md:col-span-2">
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Producto</label>
                                        <select name="productos[{{ $index }}][producto_id]" required class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white producto-select">
                                            <option value="">Seleccione un producto</option>
                                            @foreach($productos as $producto)
                                                <option value="{{ $producto->id }}" data-precio="{{ $producto->precio_unitario }}" data-unidad="{{ $producto->unidad_medida }}" data-descripcion="{{ $producto->nombre }}" {{ $item->producto_id == $producto->id ? 'selected' : '' }}>
                                                    {{ $producto->codigo }} - {{ $producto->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cantidad</label>
                                        <input type="number" name="productos[{{ $index }}][cantidad]" value="{{ old('productos.' . $index . '.cantidad', $item->cantidad) }}" step="0.01" min="0.01" required class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white producto-cantidad">
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unidad</label>
                                        <input type="text" name="productos[{{ $index }}][unidad]" value="{{ old('productos.' . $index . '.unidad', $item->unidad) }}" readonly class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white producto-unidad">
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio Unit.</label>
                                        <input type="number" name="productos[{{ $index }}][precio_unitario]" value="{{ old('productos.' . $index . '.precio_unitario', $item->precio_unitario) }}" step="0.01" min="0" required class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white producto-precio">
                                    </div>
                                    <div class="flex gap-2">
                                        <div class="flex-1">
                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Subtotal</label>
                                            <input type="number" name="productos[{{ $index }}][subtotal]" value="{{ old('productos.' . $index . '.subtotal', $item->subtotal) }}" step="0.01" readonly class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white producto-subtotal">
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
                                    <input type="text" name="productos[{{ $index }}][descripcion]" value="{{ old('productos.' . $index . '.descripcion', $item->descripcion) }}" class="block p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white producto-descripcion">
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Subtotal:</span>
                                    <span id="subtotalDisplay" class="text-sm font-bold text-gray-900 dark:text-white">{{ money_symbol($cotizacion->subtotal ?? 0) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Descuento:</span>
                                    <span id="descuentoDisplay" class="text-sm font-bold text-green-600 dark:text-green-400">{{ money_symbol($cotizacion->descuento ?? 0) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-medium text-gray-900 dark:text-white">Total:</span>
                                    <span id="totalDisplay" class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ money_symbol($cotizacion->total ?? 0) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex gap-4">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Actualizar Cotización
                        </button>
                        <a href="{{ route('cotizaciones.show', $cotizacion) }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            Ver Cotización
                        </a>
                        <a href="{{ route('cotizaciones.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
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
        let productoIndex = {{ count($cotizacion->items) }};

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

            document.getElementById('subtotalDisplay').textContent = formatMoneySymbol(subtotal);
            document.getElementById('descuentoDisplay').textContent = formatMoneySymbol(descuento);
            document.getElementById('totalDisplay').textContent = formatMoneySymbol(total);
        }

        function loadRecetaProductos(recetaId) {
            // Limpiar productos existentes
            document.getElementById('productosContainer').innerHTML = '';

            // Aquí iría una llamada AJAX para cargar los productos de la receta
            // Por ahora, solo limpiamos y esperamos que el usuario agregue manualmente
            console.log('Cargando productos de receta:', recetaId);
        }

        // Configurar listeners para productos existentes
        document.querySelectorAll('.producto-row').forEach(function(producto) {
            setupProductoListeners(producto);
        });

        // Actualizar total cuando cambia el descuento
        document.getElementById('descuento').addEventListener('input', updateTotal);

        // Calcular total inicial
        updateTotal();

        // Manejo del tipo de venta
        document.addEventListener('DOMContentLoaded', function() {
            const tipoVentaOptions = document.querySelectorAll('.tipo-venta-option');

            // Función para actualizar el estado visual
            function updateTipoVentaUI() {
                tipoVentaOptions.forEach(option => {
                    const radio = option.querySelector('.tipo-venta-radio');
                    const indicator = option.querySelector('.radio-indicator');

                    if (radio.checked) {
                        option.classList.add('border-blue-600', 'bg-blue-50', 'dark:bg-blue-900/20');
                        option.classList.remove('border-gray-300');
                        indicator.classList.remove('hidden');
                    } else {
                        option.classList.remove('border-blue-600', 'bg-blue-50', 'dark:bg-blue-900/20');
                        option.classList.add('border-gray-300');
                        indicator.classList.add('hidden');
                    }
                });
            }

            // Event listeners para las opciones
            tipoVentaOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const radio = this.querySelector('.tipo-venta-radio');
                    radio.checked = true;
                    updateTipoVentaUI();
                });
            });

            // Inicializar el estado visual
            updateTipoVentaUI();
        });
    </script>
</x-flowbite-layout>
