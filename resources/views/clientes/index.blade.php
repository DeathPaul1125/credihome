<x-tailadmin-layout>
    @section('page-title', 'Clientes')

    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-semibold text-gray-900 dark:text-white">
            Gestión de Clientes
        </h2>
        <a href="{{ route('clientes.create') }}" class="inline-flex items-center justify-center gap-2.5 rounded-lg bg-brand-500 px-6 py-3 text-center font-medium text-white hover:bg-brand-600 transition-colors">
            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 4.5C9.65833 4.5 9.375 4.78333 9.375 5.125V9.375H5.125C4.78333 9.375 4.5 9.65833 4.5 10C4.5 10.3417 4.78333 10.625 5.125 10.625H9.375V14.875C9.375 15.2167 9.65833 15.5 10 15.5C10.3417 15.5 10.625 15.2167 10.625 14.875V10.625H14.875C15.2167 10.625 15.5 10.3417 15.5 10C15.5 9.65833 15.2167 9.375 14.875 9.375H10.625V5.125C10.625 4.78333 10.3417 4.5 10 4.5Z"/>
            </svg>
            Nuevo Cliente
        </a>
    </div>

    <!-- Filtros -->
    <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/5">
        <form method="GET" action="{{ route('clientes.index') }}" class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Buscar</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nombre, DPI o teléfono..." class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                <select name="estado" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <option value="">Todos</option>
                    <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    <option value="bloqueado" {{ request('estado') == 'bloqueado' ? 'selected' : '' }}>Bloqueado</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 rounded-lg bg-brand-500 px-6 py-2.5 text-white hover:bg-brand-600 transition-colors">
                    Buscar
                </button>
                <a href="{{ route('clientes.index') }}" class="rounded-lg border border-gray-300 px-6 py-2.5 text-gray-700 hover:bg-gray-50 transition-colors dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-800">
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    <!-- Tabla de Clientes -->
    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-white/5">
        <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-800">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Lista de Clientes ({{ $clientes->total() }})
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Cliente</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">DPI</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Teléfono</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Ubicación</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Estado</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900 dark:text-white">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($clientes as $cliente)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $cliente->nombre_completo }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $cliente->email ?? 'Sin email' }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white">{{ $cliente->dpi_formateado }}</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white">{{ $cliente->telefono }}</td>
                        <td class="px-6 py-4">
                            <p class="text-gray-900 dark:text-white">{{ $cliente->municipio }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $cliente->departamento }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($cliente->estado === 'activo')
                                <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800 dark:bg-green-900/20 dark:text-green-400">Activo</span>
                            @elseif($cliente->estado === 'inactivo')
                                <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-sm font-medium text-gray-800 dark:bg-gray-900/20 dark:text-gray-400">Inactivo</span>
                            @else
                                <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-sm font-medium text-red-800 dark:bg-red-900/20 dark:text-red-400">Bloqueado</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('clientes.show', $cliente) }}" class="text-brand-500 hover:text-brand-600 transition-colors" title="Ver detalles">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('clientes.edit', $cliente) }}" class="text-blue-500 hover:text-blue-600 transition-colors" title="Editar">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <p class="mt-4 text-lg font-medium">No se encontraron clientes</p>
                            <p class="mt-2">Comienza agregando tu primer cliente</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($clientes->hasPages())
        <div class="border-t border-gray-200 px-6 py-4 dark:border-gray-800">
            {{ $clientes->links() }}
        </div>
        @endif
    </div>
</x-tailadmin-layout>
