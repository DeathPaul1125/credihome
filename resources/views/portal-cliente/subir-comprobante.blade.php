<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Subir Comprobante de Pago - Préstamo {{ $prestamo->numero_prestamo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    {{-- Información del Préstamo --}}
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold mb-3">Información del Préstamo</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm text-gray-600">Monto Original:</span>
                                <p class="font-semibold">{{ money_symbol($prestamo->monto_prestado) }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Saldo Pendiente:</span>
                                <p class="font-semibold text-red-600">{{ money_symbol($prestamo->saldo_pendiente) }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Tasa de Interés:</span>
                                <p class="font-semibold">{{ $prestamo->tasa_interes }}%</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Estado:</span>
                                <p class="font-semibold">{{ ucfirst($prestamo->estado) }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Formulario --}}
                    <form action="{{ route('portal.guardar-comprobante', $prestamo->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Monto Pagado --}}
                        <div class="mb-4">
                            <label for="monto_pagado" class="block mb-2 text-sm font-medium text-gray-900">
                                Monto Pagado <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">Q</span>
                                <input type="number" step="0.01" name="monto_pagado" id="monto_pagado"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-8 p-2.5"
                                    value="{{ old('monto_pagado') }}" required>
                            </div>
                            @error('monto_pagado')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Fecha de Pago --}}
                        <div class="mb-4">
                            <label for="fecha_pago" class="block mb-2 text-sm font-medium text-gray-900">
                                Fecha de Pago <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="fecha_pago" id="fecha_pago"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                value="{{ old('fecha_pago', date('Y-m-d')) }}" required>
                            @error('fecha_pago')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Método de Pago --}}
                        <div class="mb-4">
                            <label for="metodo_pago" class="block mb-2 text-sm font-medium text-gray-900">
                                Método de Pago
                            </label>
                            <select name="metodo_pago" id="metodo_pago"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="Transferencia">Transferencia Bancaria</option>
                                <option value="Depósito">Depósito en Banco</option>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Cheque">Cheque</option>
                            </select>
                        </div>

                        {{-- Referencia de Pago --}}
                        <div class="mb-4">
                            <label for="referencia_pago" class="block mb-2 text-sm font-medium text-gray-900">
                                Número de Referencia / Boleta
                            </label>
                            <input type="text" name="referencia_pago" id="referencia_pago"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                value="{{ old('referencia_pago') }}">
                            @error('referencia_pago')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Archivo Comprobante --}}
                        <div class="mb-4">
                            <label for="archivo_comprobante" class="block mb-2 text-sm font-medium text-gray-900">
                                Comprobante de Pago (JPG, PNG o PDF - Máx. 5MB) <span class="text-red-500">*</span>
                            </label>
                            <input type="file" name="archivo_comprobante" id="archivo_comprobante"
                                accept="image/jpeg,image/png,application/pdf"
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                required>
                            <p class="mt-1 text-sm text-gray-500">Sube una foto o escaneo de tu comprobante de pago</p>
                            @error('archivo_comprobante')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Notas --}}
                        <div class="mb-6">
                            <label for="notas" class="block mb-2 text-sm font-medium text-gray-900">
                                Notas Adicionales
                            </label>
                            <textarea name="notas" id="notas" rows="3"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Agrega cualquier información adicional sobre este pago...">{{ old('notas') }}</textarea>
                        </div>

                        {{-- Botones --}}
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('portal.prestamo', $prestamo->id) }}"
                                class="px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                                Subir Comprobante
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Instrucciones --}}
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h4 class="font-semibold text-blue-900 mb-2">📋 Instrucciones:</h4>
                <ul class="list-disc list-inside text-sm text-blue-800 space-y-1">
                    <li>Asegúrate de que el comprobante sea legible y muestre claramente el monto y la fecha</li>
                    <li>El archivo no debe superar los 5MB de tamaño</li>
                    <li>Los formatos aceptados son JPG, PNG y PDF</li>
                    <li>Una vez subido, tu comprobante será revisado por un administrador</li>
                    <li>Recibirás una notificación cuando tu pago sea aprobado o rechazado</li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
