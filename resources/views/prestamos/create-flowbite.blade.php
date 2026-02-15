<x-flowbite-layout>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Nueva Venta</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Registrar una nueva venta en el sistema</p>
            </div>
            <a href="{{ route('prestamos.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                Volver
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6">
            @if(isset($cotizacion) && $cotizacion)
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg dark:bg-blue-900/20 dark:border-blue-800">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">Datos cargados desde Cotización {{ $cotizacion->numero_cotizacion }}</h3>
                        <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">Los campos se han pre-llenado con la información de la cotización. Puede modificarlos si es necesario.</p>
                    </div>
                </div>
            </div>
            @endif

            <form action="{{ route('prestamos.store') }}" method="POST">
                @csrf

                @if(isset($cotizacion) && $cotizacion)
                <input type="hidden" name="cotizacion_id" value="{{ $cotizacion->id }}">
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Cliente -->
                    <div class="md:col-span-2">
                        <label for="cliente_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cliente <span class="text-red-500">*</span></label>
                        <select id="cliente_id" name="cliente_id" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('cliente_id') border-red-500 @enderror">
                            <option value="">Seleccionar cliente...</option>
                            @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ (old('cliente_id', $cotizacion->cliente_id ?? null) == $cliente->id) ? 'selected' : '' }}>
                                {{ $cliente->nombre_completo }} - {{ $cliente->dpi }}
                            </option>
                            @endforeach
                        </select>
                        @error('cliente_id')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Monto de la Venta -->
                    <div>
                        <label for="monto_prestado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Monto de la Venta (Q) <span class="text-red-500">*</span></label>
                        <input type="number" id="monto_prestado" name="monto_prestado" value="{{ old('monto_prestado', $cotizacion ? ($cotizacion->total - ($cotizacion->enganche ?? 0)) : '') }}" step="0.01" min="0" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('monto_prestado') border-red-500 @enderror" placeholder="5000.00">
                        @error('monto_prestado')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tasa de Interés -->
                    <div>
                        <label for="tasa_interes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tasa de Interés (%) <span class="text-red-500">*</span></label>
                        <input type="number" id="tasa_interes" name="tasa_interes" value="{{ old('tasa_interes', $cotizacion->tasa_interes_anual ?? '') }}" step="1" min="0" max="100" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('tasa_interes') border-red-500 @enderror" placeholder="24">
                        @error('tasa_interes')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tipo de Interés -->
                    <div>
                        <label for="tipo_interes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de Interés <span class="text-red-500">*</span></label>
                        <select id="tipo_interes" name="tipo_interes" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('tipo_interes') border-red-500 @enderror">
                            <option value="cuota_fija" {{ old('tipo_interes', 'cuota_fija') == 'cuota_fija' ? 'selected' : '' }}>Cuota Fija (Sistema Francés)</option>
                            <option value="flat" {{ old('tipo_interes') == 'flat' ? 'selected' : '' }}>Flat (Tasa Fija)</option>
                            <option value="sobre_saldos" {{ old('tipo_interes') == 'sobre_saldos' ? 'selected' : '' }}>Sobre Saldos (Cuota Decreciente)</option>
                            <option value="simple" {{ old('tipo_interes') == 'simple' ? 'selected' : '' }}>Simple</option>
                            <option value="compuesto" {{ old('tipo_interes') == 'compuesto' ? 'selected' : '' }}>Compuesto</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Cuota Fija: cuota constante | Flat: interés sobre capital original | Sobre Saldos: cuota decreciente</p>
                        @error('tipo_interes')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Plazo -->
                    <div>
                        <label for="plazo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Plazo (meses) <span class="text-red-500">*</span></label>
                        <input type="number" id="plazo" name="plazo" value="{{ old('plazo', $cotizacion->plazo_meses ?? '') }}" min="1" max="360" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('plazo') border-red-500 @enderror" placeholder="12">
                        @error('plazo')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Frecuencia de Pago (oculto, siempre mensual) -->
                    <input type="hidden" name="frecuencia_pago" value="mensual">

                    <!-- Fecha de Desembolso -->
                    <div>
                        <label for="fecha_desembolso" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de Desembolso <span class="text-red-500">*</span></label>
                        <input type="date" id="fecha_desembolso" name="fecha_desembolso" value="{{ old('fecha_desembolso', date('Y-m-d')) }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('fecha_desembolso') border-red-500 @enderror">
                        @error('fecha_desembolso')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tipo de Garantía -->
                    <div>
                        <label for="tipo_garantia" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de Garantía <span class="text-red-500">*</span></label>
                        <select id="tipo_garantia" name="tipo_garantia" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('tipo_garantia') border-red-500 @enderror">
                            <option value="">Seleccionar...</option>
                            <option value="ninguna" {{ old('tipo_garantia') == 'ninguna' ? 'selected' : '' }}>Ninguna</option>
                            <option value="prenda" {{ old('tipo_garantia') == 'prenda' ? 'selected' : '' }}>Prenda</option>
                            <option value="hipoteca" {{ old('tipo_garantia') == 'hipoteca' ? 'selected' : '' }}>Hipoteca</option>
                            <option value="fiador" {{ old('tipo_garantia') == 'fiador' ? 'selected' : '' }}>Fiador</option>
                            <option value="otro" {{ old('tipo_garantia') == 'otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('tipo_garantia')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Descripción de Garantía -->
                    <div>
                        <label for="descripcion_garantia" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción de Garantía</label>
                        <input type="text" id="descripcion_garantia" name="descripcion_garantia" value="{{ old('descripcion_garantia') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('descripcion_garantia') border-red-500 @enderror" placeholder="Detalles de la garantía">
                        @error('descripcion_garantia')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <!-- Notas -->
                    <label for="notas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notas Adicionales</label>
                    <textarea id="notas" name="notas" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('notas') border-red-500 @enderror">{{ old('notas') }}</textarea>
                    @error('notas')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center space-x-4">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Guardar Venta
                    </button>
                    <a href="{{ route('prestamos.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>


</x-flowbite-layout>
