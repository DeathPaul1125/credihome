<x-flowbite-layout>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Comprobantes de Pago</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Gestión y validación de comprobantes subidos por clientes</p>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <div>{{ session('success') }}</div>
    </div>
    @endif

    @if(session('error'))
    <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <div>{{ session('error') }}</div>
    </div>
    @endif

    {{-- Filtros --}}
    <div class="mb-4 bg-white dark:bg-gray-800 rounded-lg shadow p-4">
        <form method="GET" action="{{ route('admin.comprobantes.index') }}" class="flex items-end space-x-4">
            <div class="flex-1">
                <label for="estado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                <select name="estado" id="estado" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    <option value="">Todos</option>
                    <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendientes</option>
                    <option value="aprobado" {{ request('estado') == 'aprobado' ? 'selected' : '' }}>Aprobados</option>
                    <option value="rechazado" {{ request('estado') == 'rechazado' ? 'selected' : '' }}>Rechazados</option>
                </select>
            </div>
            <div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    {{-- Tabla de Comprobantes --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Número</th>
                        <th scope="col" class="px-6 py-3">Cliente</th>
                        <th scope="col" class="px-6 py-3">Préstamo</th>
                        <th scope="col" class="px-6 py-3">Monto</th>
                        <th scope="col" class="px-6 py-3">Fecha Pago</th>
                        <th scope="col" class="px-6 py-3">Subido</th>
                        <th scope="col" class="px-6 py-3">Estado</th>
                        <th scope="col" class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($comprobantes as $comprobante)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $comprobante->numero_comprobante }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $comprobante->cliente->nombre_completo }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $comprobante->prestamo->numero_prestamo }}
                            </td>
                            <td class="px-6 py-4">
                                {{ money_symbol($comprobante->monto_pagado) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($comprobante->fecha_pago)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $comprobante->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $colorEstado = match($comprobante->estado) {
                                        'pendiente' => 'yellow',
                                        'aprobado' => 'green',
                                        'rechazado' => 'red',
                                        default => 'gray'
                                    };
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-{{ $colorEstado }}-100 text-{{ $colorEstado }}-800 dark:bg-{{ $colorEstado }}-900 dark:text-{{ $colorEstado }}-300">
                                    {{ ucfirst($comprobante->estado) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.comprobantes.show', $comprobante->id) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                    Ver Detalle
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                No hay comprobantes disponibles
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        @if($comprobantes->hasPages())
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                {{ $comprobantes->links() }}
            </div>
        @endif
    </div>
</x-flowbite-layout>
