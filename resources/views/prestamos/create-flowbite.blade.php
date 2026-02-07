<x-flowbite-layout>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Nuevo Préstamo</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Registrar un nuevo préstamo en el sistema</p>
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

                    <!-- Monto Prestado -->
                    <div>
                        <label for="monto_prestado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Monto del Préstamo (Q) <span class="text-red-500">*</span></label>
                        <input type="number" id="monto_prestado" name="monto_prestado" value="{{ old('monto_prestado', $cotizacion ? ($cotizacion->total - ($cotizacion->enganche ?? 0)) : '') }}" step="0.01" min="0" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('monto_prestado') border-red-500 @enderror" placeholder="5000.00">
                        @error('monto_prestado')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tasa de Interés -->
                    <div>
                        <label for="tasa_interes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tasa de Interés (%) <span class="text-red-500">*</span></label>
                        <input type="number" id="tasa_interes" name="tasa_interes" value="{{ old('tasa_interes', $cotizacion->tasa_interes_anual ?? '') }}" step="0.01" min="0" max="100" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('tasa_interes') border-red-500 @enderror" placeholder="24.00">
                        @error('tasa_interes')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tipo de Interés -->
                    <div>
                        <label for="tipo_interes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de Interés <span class="text-red-500">*</span></label>
                        <select id="tipo_interes" name="tipo_interes" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('tipo_interes') border-red-500 @enderror">
                            <option value="">Seleccionar...</option>
                            <option value="simple" {{ old('tipo_interes', 'simple') == 'simple' ? 'selected' : '' }}>Simple</option>
                            <option value="compuesto" {{ old('tipo_interes') == 'compuesto' ? 'selected' : '' }}>Compuesto</option>
                        </select>
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

                    <!-- Frecuencia de Pago -->
                    <div>
                        <label for="frecuencia_pago" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Frecuencia de Pago <span class="text-red-500">*</span></label>
                        <select id="frecuencia_pago" name="frecuencia_pago" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('frecuencia_pago') border-red-500 @enderror">
                            <option value="">Seleccionar...</option>
                            <option value="semanal" {{ old('frecuencia_pago') == 'semanal' ? 'selected' : '' }}>Semanal</option>
                            <option value="quincenal" {{ old('frecuencia_pago') == 'quincenal' ? 'selected' : '' }}>Quincenal</option>
                            <option value="mensual" {{ old('frecuencia_pago', 'mensual') == 'mensual' ? 'selected' : '' }}>Mensual</option>
                        </select>
                        @error('frecuencia_pago')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

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

                <!-- Sección de Inversionistas -->
                <div class="mb-6 p-6 bg-blue-50 dark:bg-gray-700 rounded-lg border border-blue-200 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        💰 Fondeo del Préstamo
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        Asigna inversionistas para fondear este préstamo. La suma de las aportaciones debe cubrir el monto del préstamo.
                    </p>

                    <div id="aportadores-container">
                        <div class="aportador-row grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Inversionista</label>
                                <select name="aportadores[0][id]" class="aportador-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                    <option value="">Seleccionar inversionista...</option>
                                    @foreach($aportadores as $aportador)
                                    <option value="{{ $aportador->id }}" data-capital="{{ $aportador->capital_disponible }}">
                                        {{ $aportador->nombre }} - Disponible: Q{{ number_format($aportador->capital_disponible, 2) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Monto a Aportar (Q)</label>
                                <input type="number" name="aportadores[0][monto]" step="0.01" min="0" class="monto-aportacion bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="0.00">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Porcentaje</label>
                                <input type="text" readonly class="porcentaje-aportacion bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="0%">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <button type="button" id="add-aportador" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                            + Agregar Inversionista
                        </button>
                        <div class="text-right">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Fondeado: <span id="total-fondeado" class="font-bold text-blue-600 dark:text-blue-400">Q0.00</span></p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Faltante: <span id="total-faltante" class="font-bold text-red-600 dark:text-red-400">Q0.00</span></p>
                        </div>
                    </div>

                    @error('aportadores')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center space-x-4">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Guardar Préstamo
                    </button>
                    <a href="{{ route('prestamos.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        let aportadorCount = 1;

        document.getElementById('add-aportador').addEventListener('click', function() {
            const container = document.getElementById('aportadores-container');
            const newRow = document.querySelector('.aportador-row').cloneNode(true);

            // Actualizar los nombres de los inputs
            newRow.querySelectorAll('select, input').forEach(input => {
                if (input.name) {
                    input.name = input.name.replace('[0]', `[${aportadorCount}]`);
                }
                if (input.type !== 'text' || !input.readOnly) {
                    input.value = '';
                }
            });

            // Agregar botón de eliminar
            const deleteBtn = document.createElement('button');
            deleteBtn.type = 'button';
            deleteBtn.className = 'text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium text-sm';
            deleteBtn.innerHTML = '✕ Eliminar';
            deleteBtn.onclick = function() {
                newRow.remove();
                calcularTotales();
            };

            const lastCol = newRow.querySelector('.grid > div:last-child');
            lastCol.appendChild(deleteBtn);

            container.appendChild(newRow);
            aportadorCount++;

            // Agregar event listeners a los nuevos campos
            attachEventListeners(newRow);
        });

        function attachEventListeners(row) {
            row.querySelector('.monto-aportacion').addEventListener('input', calcularTotales);
        }

        function calcularTotales() {
            const montoPrestamo = parseFloat(document.getElementById('monto_prestado').value) || 0;
            let totalFondeado = 0;

            document.querySelectorAll('.aportador-row').forEach(row => {
                const monto = parseFloat(row.querySelector('.monto-aportacion').value) || 0;
                totalFondeado += monto;

                // Calcular porcentaje
                const porcentaje = montoPrestamo > 0 ? (monto / montoPrestamo * 100).toFixed(2) : 0;
                row.querySelector('.porcentaje-aportacion').value = porcentaje + '%';
            });

            document.getElementById('total-fondeado').textContent = 'Q' + totalFondeado.toFixed(2);

            const faltante = Math.max(0, montoPrestamo - totalFondeado);
            document.getElementById('total-faltante').textContent = 'Q' + faltante.toFixed(2);

            // Cambiar color según el estado
            const faltanteSpan = document.getElementById('total-faltante');
            if (faltante === 0 && montoPrestamo > 0) {
                faltanteSpan.className = 'font-bold text-green-600 dark:text-green-400';
            } else {
                faltanteSpan.className = 'font-bold text-red-600 dark:text-red-400';
            }
        }

        // Agregar event listeners iniciales
        document.querySelectorAll('.aportador-row').forEach(attachEventListeners);
        document.getElementById('monto_prestado').addEventListener('input', calcularTotales);
    </script>
    @endpush
</x-flowbite-layout>
