<x-flowbite-layout>
    <div class="p-4 max-w-2xl mx-auto">
        <!-- Success Message -->
        <div class="text-center py-8">
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-4">
                <svg class="h-12 w-12 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">¡Pago Exitoso!</h1>
            <p class="text-gray-600 dark:text-gray-400 mb-8">
                Tu pago ha sido procesado correctamente
            </p>
        </div>

        <!-- Payment Details -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Detalles del Pago</h2>

            <div class="space-y-4">
                <div class="flex justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-gray-600 dark:text-gray-400">Número de Recibo:</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $pago->numero_recibo }}</span>
                </div>

                <div class="flex justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-gray-600 dark:text-gray-400">Préstamo:</span>
                    <span class="font-semibold text-gray-900 dark:text-white">#{{ $pago->prestamo_id }}</span>
                </div>

                <div class="flex justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-gray-600 dark:text-gray-400">Cuota:</span>
                    <span class="font-semibold text-gray-900 dark:text-white">#{{ $pago->numero_cuota }}</span>
                </div>

                <div class="flex justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-gray-600 dark:text-gray-400">Monto Pagado:</span>
                    <span class="font-bold text-green-600 dark:text-green-400 text-xl">
                        {{ money_symbol($pago->monto_pagado) }}
                    </span>
                </div>

                <div class="flex justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-gray-600 dark:text-gray-400">Fecha:</span>
                    <span class="font-semibold text-gray-900 dark:text-white">
                        {{ $pago->fecha_pago->format('d/m/Y H:i') }}
                    </span>
                </div>

                <div class="flex justify-between py-3">
                    <span class="text-gray-600 dark:text-gray-400">Método:</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $pago->metodo_pago }}</span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col gap-4">
            <a href="{{ route('pagos.show', $pago) }}" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700">
                Ver Detalles del Pago
            </a>

            <a href="{{ route('prestamos.show', $pago->prestamo_id) }}" class="w-full text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-3 text-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700">
                Ver Préstamo
            </a>

            <a href="{{ route('dashboard') }}" class="w-full text-gray-700 hover:text-gray-900 text-center py-3 text-sm dark:text-gray-400 dark:hover:text-gray-200">
                Volver al Inicio
            </a>
        </div>

        <!-- Info Box -->
        <div class="mt-6 p-4 bg-blue-50 dark:bg-gray-900 rounded-lg border border-blue-200 dark:border-blue-900">
            <p class="text-sm text-gray-700 dark:text-gray-300">
                <strong>📧 Comprobante enviado:</strong> Recibirás un correo electrónico con el comprobante de pago.
            </p>
        </div>
    </div>
</x-flowbite-layout>
