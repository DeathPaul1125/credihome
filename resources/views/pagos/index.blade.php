<x-tailadmin-layout>
    @section('page-title', 'Pagos')

    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-semibold text-gray-900 dark:text-white">
            Registro de Pagos
        </h2>
        <a href="{{ route('pagos.create') }}" class="inline-flex items-center justify-center gap-2.5 rounded-lg bg-brand-500 px-6 py-3 text-center font-medium text-white hover:bg-brand-600 transition-colors">
            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M10 4.5C9.65833 4.5 9.375 4.78333 9.375 5.125V9.375H5.125C4.78333 9.375 4.5 9.65833 4.5 10C4.5 10.3417 4.78333 10.625 5.125 10.625H9.375V14.875C9.375 15.2167 9.65833 15.5 10 15.5C10.3417 15.5 10.625 15.2167 10.625 14.875V10.625H14.875C15.2167 10.625 15.5 10.3417 15.5 10C15.5 9.65833 15.2167 9.375 14.875 9.375H10.625V5.125C10.625 4.78333 10.3417 4.5 10 4.5Z"/>
            </svg>
            Registrar Pago
        </a>
    </div>

    <!-- Tabla de Pagos -->
    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-white/5">
        <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-800">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Historial de Pagos ({{ $pagos->total() }})
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Recibo</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Cliente</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Préstamo</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Monto</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Fecha</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($pagos as $pago)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-900 dark:text-white">{{ $pago->numero_recibo }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Cuota #{{ $pago->numero_cuota }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white">{{ $pago->cliente->nombre_completo }}</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white">{{ $pago->prestamo->numero_prestamo }}</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white">{{ $pago->monto_formateado }}</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white">{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">{!! $pago->badge_estado !!}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            No se encontraron pagos registrados
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pagos->hasPages())
        <div class="border-t border-gray-200 px-6 py-4 dark:border-gray-800">
            {{ $pagos->links() }}
        </div>
        @endif
    </div>
</x-tailadmin-layout>
