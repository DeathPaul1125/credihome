<x-flowbite-layout>
    <div class="p-4 max-w-2xl mx-auto">
        <!-- Pending Message -->
        <div class="text-center py-8">
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-blue-100 mb-4">
                <svg class="h-12 w-12 text-blue-600 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Procesando Pago...</h1>
            <p class="text-gray-600 dark:text-gray-400 mb-8">
                Tu pago está siendo verificado. Por favor espera.
            </p>
        </div>

        <!-- Payment Info -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Información del Pago</h2>

            <div class="space-y-3">
                <div class="flex justify-between py-2">
                    <span class="text-gray-600 dark:text-gray-400">Número de Recibo:</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $pago->numero_recibo }}</span>
                </div>

                <div class="flex justify-between py-2">
                    <span class="text-gray-600 dark:text-gray-400">Préstamo:</span>
                    <span class="font-semibold text-gray-900 dark:text-white">#{{ $pago->prestamo_id }}</span>
                </div>

                <div class="flex justify-between py-2">
                    <span class="text-gray-600 dark:text-gray-400">Cuota:</span>
                    <span class="font-semibold text-gray-900 dark:text-white">#{{ $pago->numero_cuota }}</span>
                </div>

                <div class="flex justify-between py-2">
                    <span class="text-gray-600 dark:text-gray-400">Monto:</span>
                    <span class="font-bold text-gray-900 dark:text-white">
                        {{ money_symbol($pago->monto_cuota) }}
                    </span>
                </div>

                <div class="flex justify-between py-2">
                    <span class="text-gray-600 dark:text-gray-400">Estado:</span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Verificando...
                    </span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col gap-4">
            <button onclick="window.location.reload()" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700">
                Actualizar Estado
            </button>

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
                <strong>ℹ️ Nota:</strong> Si el pago fue exitoso, la página se actualizará automáticamente en unos momentos. Si después de 5 minutos el estado no cambia, contacta a soporte.
            </p>
        </div>

        <!-- Auto-reload script -->
        <script>
            // Auto-reload después de 10 segundos
            setTimeout(function() {
                window.location.reload();
            }, 10000);
        </script>
    </div>
</x-flowbite-layout>
