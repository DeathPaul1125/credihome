<x-flowbite-layout>
    <div class="p-4 max-w-2xl mx-auto">
        <!-- Error Message -->
        <div class="text-center py-8">
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-100 mb-4">
                <svg class="h-12 w-12 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Error en el Pago</h1>
            <p class="text-gray-600 dark:text-gray-400 mb-8">
                {{ $message ?? 'Ocurrió un error al procesar tu pago' }}
            </p>
        </div>

        <!-- Error Details -->
        <div class="bg-red-50 dark:bg-gray-900 border border-red-200 dark:border-red-900 rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-red-900 dark:text-red-400 mb-3">¿Qué puedes hacer?</h2>
            <ul class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-red-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Verifica que tu tarjeta tenga fondos suficientes
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-red-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Asegúrate de que los datos ingresados sean correctos
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-red-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Contacta a tu banco si el problema persiste
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-red-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Intenta con otra tarjeta
                </li>
            </ul>
        </div>

        <!-- Actions -->
        <div class="flex flex-col gap-4">
            <a href="{{ route('dashboard') }}" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700">
                Volver al Inicio
            </a>

            <a href="{{ route('prestamos.index') }}" class="w-full text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-3 text-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700">
                Ver Mis Préstamos
            </a>
        </div>

        <!-- Support Info -->
        <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">¿Necesitas ayuda?</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                Si sigues teniendo problemas, contáctanos:
            </p>
            <div class="text-sm text-gray-700 dark:text-gray-300 space-y-1">
                <p>📞 Teléfono: {{ config('configuracion.telefono', '(+502) 1234-5678') }}</p>
                <p>📧 Email: {{ config('configuracion.email', 'soporte@credihome.com') }}</p>
            </div>
        </div>
    </div>
</x-flowbite-layout>
