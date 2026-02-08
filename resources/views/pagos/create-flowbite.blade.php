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

                        @if(isset($numeroCuota))
                        <input type="hidden" name="numero_cuota" value="{{ $numeroCuota }}">
                        @endif

                        @if(isset($cuotaPendiente))
                        <div class="mb-6 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg dark:from-blue-900/20 dark:to-indigo-900/20 dark:border-blue-800">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center w-12 h-12 bg-blue-600 rounded-lg">
                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                            Cuota #{{ $cuotaPendiente['numero_cuota'] }}
                                            @if($cuotaPendiente['estado'] === 'vencida')
                                                <span class="ml-2 px-2.5 py-0.5 text-xs font-medium rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">VENCIDA</span>
                                            @else
                                                <span class="ml-2 px-2.5 py-0.5 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">PENDIENTE</span>
                                            @endif
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                            Información de la cuota {{ $cuotaPendiente['estado'] === 'vencida' ? 'vencida' : 'pendiente' }} según tabla de amortización
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Detalles de la cuota en grid -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4 pt-4 border-t border-blue-200 dark:border-blue-700">
                                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Monto Cuota</p>
                                    <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-1">{{ money_symbol($cuotaPendiente['cuota']) }}</p>
                                </div>
                                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Capital</p>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ money_symbol($cuotaPendiente['capital']) }}</p>
                                </div>
                                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Interés</p>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ money_symbol($cuotaPendiente['interes']) }}</p>
                                </div>
                            </div>

                            <!-- Fechas y saldo -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-3">
                                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Fecha Vencimiento</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">
                                        {{ \Carbon\Carbon::parse($cuotaPendiente['fecha_vencimiento'])->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Saldo Anterior</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">{{ money_symbol($cuotaPendiente['saldo_anterior']) }}</p>
                                </div>
                                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Saldo Después</p>
                                    <p class="text-sm font-semibold text-green-600 dark:text-green-400 mt-1">{{ money_symbol($cuotaPendiente['saldo']) }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Préstamo -->
                            <div class="md:col-span-2">
                                <label for="prestamo_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Préstamo <span class="text-red-500">*</span>
                                </label>
                                <select id="prestamo_id" name="prestamo_id" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('prestamo_id') border-red-500 @enderror">
                                    <option value="">Seleccione un préstamo</option>
                                    @foreach($prestamos as $p)
                                        <option value="{{ $p->id }}"
                                            {{ (old('prestamo_id', $prestamo->id ?? null) == $p->id) ? 'selected' : '' }}
                                            data-cliente="{{ $p->cliente->nombre_completo }}"
                                            data-monto="{{ $p->monto_prestado }}"
                                            data-saldo="{{ $p->saldo_pendiente }}">
                                            {{ $p->numero_prestamo }} - {{ $p->cliente->nombre_completo }} - Saldo: {{ money_symbol($p->saldo_pendiente) }}
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
                                <input type="number" step="0.01" id="monto_pagado" name="monto_pagado" value="{{ old('monto_pagado', isset($cuotaPendiente) ? $cuotaPendiente['cuota'] : '') }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('monto_pagado') border-red-500 @enderror" placeholder="0.00">
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
                                    @if(isset($numeroRecibo))
                                        <span class="ml-2 text-xs text-green-600 dark:text-green-400">(Generado automáticamente)</span>
                                    @endif
                                </label>
                                <div class="relative">
                                    <input type="text" id="numero_recibo" name="numero_recibo" value="{{ old('numero_recibo', $numeroRecibo ?? '') }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('numero_recibo') border-red-500 @enderror"
                                        placeholder="Ej: REC-2026-00001"
                                        @if(isset($numeroRecibo)) readonly @endif>
                                    @if(isset($numeroRecibo))
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
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
        // Recargar página cuando se selecciona un préstamo para obtener cuota pendiente
        document.getElementById('prestamo_id').addEventListener('change', function() {
            if (this.value) {
                // Redirigir a la misma página con el prestamo_id como parámetro
                window.location.href = '{{ route("pagos.create") }}?prestamo_id=' + this.value;
            } else {
                const infoDiv = document.getElementById('prestamo-info');
                infoDiv.classList.add('hidden');
            }
        });

        // Mostrar información del préstamo seleccionado (si no hay cuota pendiente mostrada)
        @if(!isset($cuotaPendiente))
        const prestamoSelect = document.getElementById('prestamo_id');
        if (prestamoSelect.value) {
            const option = prestamoSelect.options[prestamoSelect.selectedIndex];
            const infoDiv = document.getElementById('prestamo-info');

            document.getElementById('info-cliente').textContent = option.dataset.cliente;
            document.getElementById('info-monto').textContent = formatMoneySymbol(option.dataset.monto);
            document.getElementById('info-saldo').textContent = formatMoneySymbol(option.dataset.saldo);
            infoDiv.classList.remove('hidden');
        }
        @endif
    </script>
    @endpush
</x-flowbite-layout>
