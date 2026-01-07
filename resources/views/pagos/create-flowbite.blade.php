<x-flowbite-layout>
    <!-- Header -->
    <div class="mb-6">
                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-2">
                    <a href="{{ route('pagos.index') }}" class="hover:text-blue-600">Pagos</a>
                    <i class="fas fa-chevron-right mx-2 text-xs"></i>
                    <span>Registrar Nuevo Pago</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Registrar Nuevo Pago</h1>
            </div>

            <!-- Formulario -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6">
                    <form action="{{ route('pagos.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Préstamo -->
                            <div class="md:col-span-2">
                                <label for="prestamo_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Préstamo <span class="text-red-500">*</span>
                                </label>
                                <select id="prestamo_id" name="prestamo_id" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('prestamo_id') border-red-500 @enderror">
                                    <option value="">Seleccione un préstamo</option>
                                    @foreach($prestamos as $prestamo)
                                        <option value="{{ $prestamo->id }}" {{ old('prestamo_id') == $prestamo->id ? 'selected' : '' }}
                                            data-cliente="{{ $prestamo->cliente->nombre }}"
                                            data-monto="{{ $prestamo->monto_prestamo }}"
                                            data-saldo="{{ $prestamo->saldo_pendiente }}">
                                            Préstamo #{{ $prestamo->id }} - {{ $prestamo->cliente->nombre }} - Saldo: Q{{ number_format($prestamo->saldo_pendiente, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('prestamo_id')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror

                                <!-- Info del préstamo seleccionado -->
                                <div id="prestamo-info" class="mt-3 p-4 bg-blue-50 border border-blue-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 hidden">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                        <div>
                                            <span class="font-medium text-gray-700 dark:text-gray-300">Cliente:</span>
                                            <span id="info-cliente" class="text-gray-900 dark:text-white ml-2"></span>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-700 dark:text-gray-300">Monto Préstamo:</span>
                                            <span id="info-monto" class="text-gray-900 dark:text-white ml-2"></span>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-700 dark:text-gray-300">Saldo Pendiente:</span>
                                            <span id="info-saldo" class="text-blue-600 dark:text-blue-400 font-semibold ml-2"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Monto Pagado -->
                            <div>
                                <label for="monto_pagado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Monto Pagado (Q) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" step="0.01" id="monto_pagado" name="monto_pagado" value="{{ old('monto_pagado') }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('monto_pagado') border-red-500 @enderror" placeholder="0.00">
                                @error('monto_pagado')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Fecha de Pago -->
                            <div>
                                <label for="fecha_pago" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Fecha de Pago <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="fecha_pago" name="fecha_pago" value="{{ old('fecha_pago', date('Y-m-d')) }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('fecha_pago') border-red-500 @enderror">
                                @error('fecha_pago')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tipo de Pago -->
                            <div>
                                <label for="tipo_pago" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Tipo de Pago <span class="text-red-500">*</span>
                                </label>
                                <select id="tipo_pago" name="tipo_pago" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('tipo_pago') border-red-500 @enderror">
                                    <option value="">Seleccione tipo</option>
                                    <option value="efectivo" {{ old('tipo_pago') == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                                    <option value="transferencia" {{ old('tipo_pago') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                                    <option value="deposito" {{ old('tipo_pago') == 'deposito' ? 'selected' : '' }}>Depósito</option>
                                    <option value="cheque" {{ old('tipo_pago') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                </select>
                                @error('tipo_pago')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Número de Recibo -->
                            <div>
                                <label for="numero_recibo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Número de Recibo
                                </label>
                                <input type="text" id="numero_recibo" name="numero_recibo" value="{{ old('numero_recibo') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('numero_recibo') border-red-500 @enderror" placeholder="Ej: REC-001">
                                @error('numero_recibo')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Observaciones -->
                            <div class="md:col-span-2">
                                <label for="observaciones" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Observaciones
                                </label>
                                <textarea id="observaciones" name="observaciones" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('observaciones') border-red-500 @enderror" placeholder="Observaciones adicionales...">{{ old('observaciones') }}</textarea>
                                @error('observaciones')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                <i class="fas fa-save mr-2"></i>Registrar Pago
                            </button>
                            <a href="{{ route('pagos.index') }}" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                                <i class="fas fa-times mr-2"></i>Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

    @push('scripts')
    <script>
        // Mostrar información del préstamo seleccionado
        document.getElementById('prestamo_id').addEventListener('change', function() {
            const option = this.options[this.selectedIndex];
            const infoDiv = document.getElementById('prestamo-info');

            if (this.value) {
                document.getElementById('info-cliente').textContent = option.dataset.cliente;
                document.getElementById('info-monto').textContent = 'Q' + parseFloat(option.dataset.monto).toLocaleString('es-GT', {minimumFractionDigits: 2});
                document.getElementById('info-saldo').textContent = 'Q' + parseFloat(option.dataset.saldo).toLocaleString('es-GT', {minimumFractionDigits: 2});
                infoDiv.classList.remove('hidden');
            } else {
                infoDiv.classList.add('hidden');
            }
        });
    </script>
    @endpush
</x-flowbite-layout>
