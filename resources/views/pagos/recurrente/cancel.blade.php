<x-flowbite-layout>
    <div class="p-4 max-w-2xl mx-auto">
        <!-- Cancel Message -->
        <div class="text-center py-8">
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-yellow-100 mb-4">
                <svg class="h-12 w-12 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Pago Cancelado</h1>
            <p class="text-gray-600 dark:text-gray-400 mb-8">
                Has cancelado el proceso de pago
            </p>
        </div>

        <!-- Payment Info -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Información del Pago</h2>

            <div class="space-y-3">
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
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col gap-4">
            <form action="{{ route('recurrente.initPayment', $pago) }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700">
                    Intentar Nuevamente
                </button>
            </form>

            <a href="{{ route('prestamos.show', $pago->prestamo_id) }}" class="w-full text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-3 text-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700">
                Volver al Préstamo
            </a>

            <a href="{{ route('dashboard') }}" class="w-full text-gray-700 hover:text-gray-900 text-center py-3 text-sm dark:text-gray-400 dark:hover:text-gray-200">
                Volver al Inicio
            </a>
        </div>

        <!-- Info Box -->
        <div class="mt-6 p-4 bg-yellow-50 dark:bg-gray-900 rounded-lg border border-yellow-200 dark:border-yellow-900">
            <p class="text-sm text-gray-700 dark:text-gray-300">
                <strong>ℹ️ Nota:</strong> No se ha realizado ningún cargo a tu tarjeta. Puedes intentar realizar el pago nuevamente cuando desees.
            </p>
        </div>

        <!-- Alternative Payment Methods -->
        <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Otras formas de pago</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                También puedes realizar tu pago en efectivo o mediante transferencia bancaria. Consulta con nuestro equipo para más información.
            </p>
        </div>
    </div>
</x-flowbite-layout>
