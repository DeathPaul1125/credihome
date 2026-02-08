<x-tailadmin-layout>
    @section('page-title', 'Registrar Pago')

    <div class="mb-6">
        <h2 class="text-title-md2 font-semibold text-gray-900 dark:text-white">
            Registrar Nuevo Pago
        </h2>
        <p class="text-gray-500 dark:text-gray-400">Complete la información del pago recibido</p>
    </div>

    <form action="{{ route('pagos.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Información del Préstamo -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/5">
                <h3 class="mb-6 text-lg font-semibold text-gray-900 dark:text-white">Préstamo</h3>

                <div class="space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Seleccionar Préstamo *</label>
                        <select name="prestamo_id" id="prestamo_id" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('prestamo_id') border-red-500 @enderror">
                            <option value="">Seleccionar...</option>
                            @foreach(\App\Models\Prestamo::with('cliente')->whereIn('estado', ['activo', 'en_mora'])->get() as $prest)
                                <option value="{{ $prest->id }}"
                                    data-cliente="{{ $prest->cliente->nombre_completo }}"
                                    data-monto-cuota="{{ $prest->monto_cuota }}"
                                    data-saldo="{{ $prest->saldo_pendiente }}"
                                    {{ old('prestamo_id', request('prestamo_id')) == $prest->id ? 'selected' : '' }}>
                                    {{ $prest->numero_prestamo }} - {{ $prest->cliente->nombre_completo }} ({{ money_symbol($prest->saldo_pendiente) }})
                                </option>
                            @endforeach
                        </select>
                        @error('prestamo_id')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div id="prestamo-info" class="hidden rounded-lg bg-blue-50 p-4 dark:bg-blue-900/20">
                        <div class="space-y-2">
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Cliente:</span>
                                <p class="font-medium text-gray-900 dark:text-white" id="info-cliente">-</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Cuota Regular:</span>
                                <p class="font-medium text-gray-900 dark:text-white" id="info-cuota">-</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Saldo Pendiente:</span>
                                <p class="font-medium text-danger" id="info-saldo">-</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detalles del Pago -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/5">
                <h3 class="mb-6 text-lg font-semibold text-gray-900 dark:text-white">Detalles del Pago</h3>

                <div class="space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Monto Pagado (Q) *</label>
                        <input type="number" name="monto_pagado" value="{{ old('monto_pagado') }}" step="0.01" min="0.01" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('monto_pagado') border-red-500 @enderror">
                        @error('monto_pagado')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Fecha de Pago *</label>
                        <input type="date" name="fecha_pago" value="{{ old('fecha_pago', date('Y-m-d')) }}" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('fecha_pago') border-red-500 @enderror">
                        @error('fecha_pago')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Método de Pago *</label>
                        <select name="metodo_pago" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('metodo_pago') border-red-500 @enderror">
                            <option value="">Seleccionar...</option>
                            <option value="efectivo" {{ old('metodo_pago', 'efectivo') == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                            <option value="transferencia" {{ old('metodo_pago') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                            <option value="cheque" {{ old('metodo_pago') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                            <option value="deposito" {{ old('metodo_pago') == 'deposito' ? 'selected' : '' }}>Depósito</option>
                        </select>
                        @error('metodo_pago')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Observaciones -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/5">
                <h3 class="mb-6 text-lg font-semibold text-gray-900 dark:text-white">Información Adicional</h3>

                <div class="space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Observaciones</label>
                        <textarea name="observaciones" rows="5" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('observaciones') border-red-500 @enderror">{{ old('observaciones') }}</textarea>
                        @error('observaciones')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div class="rounded-lg bg-green-50 p-4 dark:bg-green-900/20">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-green-800 dark:text-green-300">Cálculo Automático</h3>
                                <div class="mt-2 text-sm text-green-700 dark:text-green-400">
                                    <ul class="list-disc pl-5 space-y-1">
                                        <li>El número de recibo se genera automáticamente</li>
                                        <li>La mora se calcula si el pago es posterior a la fecha de vencimiento</li>
                                        <li>El saldo del préstamo se actualiza automáticamente</li>
                                        <li>El estado del préstamo se ajusta según el pago recibido</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 flex gap-4">
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-600 px-6 py-3 text-center text-base font-semibold text-white hover:bg-brand-700 focus:outline-none focus:ring-4 focus:ring-brand-300 dark:bg-brand-600 dark:hover:bg-brand-700 dark:focus:ring-brand-800">
                Registrar Pago
            </button>
            <a href="{{ route('pagos.index') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-3 text-center text-base font-medium text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                Cancelar
            </a>
        </div>
    </form>

    @push('scripts')
    <script>
        document.getElementById('prestamo_id').addEventListener('change', function() {
            const select = this;
            const option = select.options[select.selectedIndex];
            const infoDiv = document.getElementById('prestamo-info');

            if (option.value) {
                document.getElementById('info-cliente').textContent = option.dataset.cliente;
                document.getElementById('info-cuota').textContent = formatMoneySymbol(option.dataset.montoCuota);
                document.getElementById('info-saldo').textContent = formatMoneySymbol(option.dataset.saldo);
                infoDiv.classList.remove('hidden');
            } else {
                infoDiv.classList.add('hidden');
            }
        });

        // Trigger on page load if prestamo is preselected
        if (document.getElementById('prestamo_id').value) {
            document.getElementById('prestamo_id').dispatchEvent(new Event('change'));
        }
    </script>
    @endpush
</x-tailadmin-layout>
