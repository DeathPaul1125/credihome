<x-tailadmin-layout>
    @section('page-title', 'Préstamos')

    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-semibold text-gray-900 dark:text-white">
            Gestión de Préstamos
        </h2>
        <a href="{{ route('prestamos.create') }}" class="inline-flex items-center justify-center gap-2.5 rounded-lg bg-brand-500 px-6 py-3 text-center font-medium text-white hover:bg-brand-600 transition-colors">
            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M10 4.5C9.65833 4.5 9.375 4.78333 9.375 5.125V9.375H5.125C4.78333 9.375 4.5 9.65833 4.5 10C4.5 10.3417 4.78333 10.625 5.125 10.625H9.375V14.875C9.375 15.2167 9.65833 15.5 10 15.5C10.3417 15.5 10.625 15.2167 10.625 14.875V10.625H14.875C15.2167 10.625 15.5 10.3417 15.5 10C15.5 9.65833 15.2167 9.375 14.875 9.375H10.625V5.125C10.625 4.78333 10.3417 4.5 10 4.5Z"/>
            </svg>
            Nuevo Préstamo
        </a>
    </div>

    <!-- Mensajes de éxito y error -->
    @if(session('success'))
    <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-gray-800 dark:text-green-400" role="alert">
        <span class="font-medium">¡Éxito!</span> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-gray-800 dark:text-red-400" role="alert">
        <span class="font-medium">Error:</span> {{ session('error') }}
    </div>
    @endif

    <!-- Tabla de Préstamos -->
    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-white/5">
        <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-800">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Lista de Préstamos ({{ $prestamos->total() }})
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Préstamo</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Cliente</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Monto</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Saldo</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Estado</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900 dark:text-white">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($prestamos as $prestamo)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-900 dark:text-white">{{ $prestamo->numero_prestamo }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $prestamo->fecha_desembolso->format('d/m/Y') }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white">{{ $prestamo->cliente->nombre_completo }}</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white">{{ $prestamo->monto_formateado }}</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white">{{ $prestamo->saldo_formateado }}</td>
                        <td class="px-6 py-4">
                            @if($prestamo->estado === 'activo')
                                <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800 dark:bg-green-900/20 dark:text-green-400">Activo</span>
                            @elseif($prestamo->estado === 'pagado')
                                <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">Pagado</span>
                            @elseif($prestamo->estado === 'vencido')
                                <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-sm font-medium text-red-800 dark:bg-red-900/20 dark:text-red-400">Vencido</span>
                            @elseif($prestamo->estado === 'en_mora')
                                <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-sm font-medium text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400">En Mora</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('prestamos.show', $prestamo) }}" class="text-brand-500 hover:text-brand-600 transition-colors" title="Ver detalle">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('prestamos.edit', $prestamo) }}" class="text-blue-500 hover:text-blue-600 transition-colors" title="Editar">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('prestamos.destroy', $prestamo) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de eliminar este préstamo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600 transition-colors" title="Eliminar">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            No se encontraron préstamos
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($prestamos->hasPages())
        <div class="border-t border-gray-200 px-6 py-4 dark:border-gray-800">
            {{ $prestamos->links() }}
        </div>
        @endif
    </div>
</x-tailadmin-layout>
