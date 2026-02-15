<x-flowbite-layout>
    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Gestión de Fondeo</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Préstamos pendientes de asignación de aportadores</p>
        </div>
    </div>

    <!-- Mensajes -->
    @if(session('success'))
        <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filtros -->
    <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow p-4">
        <form method="GET" action="{{ route('fondeo.index') }}" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Buscar por número de préstamo o cliente..."
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700">
                Buscar
            </button>
            @if(request()->hasAny(['search']))
                <a href="{{ route('fondeo.index') }}" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700">
                    Limpiar
                </a>
            @endif
        </form>
    </div>

    <!-- Tabla de Préstamos -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Préstamo</th>
                        <th scope="col" class="px-6 py-3">Cliente</th>
                        <th scope="col" class="px-6 py-3">Monto Total</th>
                        <th scope="col" class="px-6 py-3">Fondeado</th>
                        <th scope="col" class="px-6 py-3">Faltante</th>
                        <th scope="col" class="px-6 py-3">Progreso</th>
                        <th scope="col" class="px-6 py-3">Estado</th>
                        <th scope="col" class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prestamos as $prestamo)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $prestamo->numero_prestamo }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $prestamo->cliente->nombre_completo }}
                            </td>
                            <td class="px-6 py-4 font-semibold">
                                {{ money_symbol($prestamo->monto_prestado) }}
                            </td>
                            <td class="px-6 py-4 text-green-600 dark:text-green-400">
                                {{ money_symbol($prestamo->monto_fondeado) }}
                            </td>
                            <td class="px-6 py-4 text-red-600 dark:text-red-400">
                                {{ money_symbol($prestamo->monto_faltante) }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ min($prestamo->porcentaje_fondeo, 100) }}%"></div>
                                </div>
                                <span class="text-xs text-gray-600 dark:text-gray-400 mt-1 block">
                                    {{ number_format($prestamo->porcentaje_fondeo, 1) }}%
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($prestamo->estado === 'pendiente')
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                        Sin fondeo
                                    </span>
                                @elseif($prestamo->estado === 'pendiente_fondeo')
                                    @if($prestamo->porcentaje_fondeo >= 100)
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                            ✓ Completo
                                        </span>
                                    @else
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                            En fondeo
                                        </span>
                                    @endif
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    @can('gestionar-fondeo-prestamos')
                                        <a href="{{ route('fondeo.gestionar', $prestamo) }}"
                                            class="font-medium text-blue-600 hover:text-blue-700 dark:text-blue-500">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"/>
                                                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"/>
                                            </svg>
                                        </a>
                                    @endcan

                                    @if($prestamo->porcentaje_fondeo >= 100)
                                        @can('aprobar-fondeo-prestamos')
                                            <form action="{{ route('fondeo.aprobar', $prestamo) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    onclick="return confirm('¿Aprobar este préstamo?')"
                                                    class="font-medium text-green-600 hover:text-green-700 dark:text-green-500"
                                                    title="Aprobar">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endcan
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                No hay préstamos pendientes de fondeo
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($prestamos->hasPages())
            <div class="px-6 py-4 border-t dark:border-gray-700">
                {{ $prestamos->links() }}
            </div>
        @endif
    </div>
</x-flowbite-layout>
