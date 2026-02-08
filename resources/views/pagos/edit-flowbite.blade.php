<x-flowbite-layout>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-2">
            <a href="{{ route('pagos.index') }}" class="hover:text-blue-600">Pagos</a>
            <i class="fas fa-chevron-right mx-2 text-xs"></i>
            <span>Editar Pago</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Editar Pago #{{ $pago->numero_recibo ?? $pago->id }}</h1>
    </div>

    <!-- Formulario -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <div class="p-6">
            <form action="{{ route('pagos.update', $pago) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Info del préstamo (solo lectura) -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg dark:bg-gray-700 dark:border-gray-600">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Información del Préstamo</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Cliente:</span>
                            <span class="text-gray-900 dark:text-white ml-2">{{ $pago->prestamo->cliente->nombre_completo }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">N° Préstamo:</span>
                            <span class="text-gray-900 dark:text-white ml-2">{{ $pago->prestamo->numero_prestamo }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Saldo Actual:</span>
                            <span class="text-blue-600 dark:text-blue-400 font-semibold ml-2">{{ money_symbol($pago->prestamo->saldo_pendiente) }}</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Monto Pagado -->
                    <div>
                        <label for="monto_pagado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Monto Pagado (Q) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" step="0.01" id="monto_pagado" name="monto_pagado" value="{{ old('monto_pagado', $pago->monto_pagado) }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('monto_pagado') border-red-500 @enderror" placeholder="0.00">
                        @error('monto_pagado')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha de Pago -->
                    <div>
                        <label for="fecha_pago" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Fecha de Pago <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="fecha_pago" name="fecha_pago" value="{{ old('fecha_pago', $pago->fecha_pago->format('Y-m-d')) }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('fecha_pago') border-red-500 @enderror">
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
                            <option value="efectivo" {{ old('tipo_pago', $pago->tipo_pago) == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                            <option value="transferencia" {{ old('tipo_pago', $pago->tipo_pago) == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                            <option value="deposito" {{ old('tipo_pago', $pago->tipo_pago) == 'deposito' ? 'selected' : '' }}>Depósito</option>
                            <option value="cheque" {{ old('tipo_pago', $pago->tipo_pago) == 'cheque' ? 'selected' : '' }}>Cheque</option>
                        </select>
                        @error('tipo_pago')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Observaciones -->
                    <div class="md:col-span-2">
                        <label for="observaciones" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Observaciones
                        </label>
                        <textarea id="observaciones" name="observaciones" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('observaciones') border-red-500 @enderror" placeholder="Observaciones adicionales...">{{ old('observaciones', $pago->observaciones) }}</textarea>
                        @error('observaciones')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex items-center justify-end gap-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('pagos.show', $pago) }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                        Cancelar
                    </a>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        <i class="fas fa-save mr-2"></i>Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-flowbite-layout>
