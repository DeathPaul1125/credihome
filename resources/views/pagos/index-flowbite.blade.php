<x-flowbite-layout>
    <!-- Header -->
    <div class="mb-4 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Pagos</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Gestión de pagos de préstamos</p>
                </div>
                <a href="{{ route('pagos.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <i class="fas fa-plus mr-2"></i>Registrar Pago
                </a>
            </div>

            <!-- Filtros y Búsqueda -->
            <div class="mb-4 p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <form method="GET" action="{{ route('pagos.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Búsqueda -->
                    <div>
                        <label for="search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Buscar</label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Cliente o N° Recibo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    </div>

                    <!-- Fecha desde -->
                    <div>
                        <label for="fecha_desde" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha Desde</label>
                        <input type="date" id="fecha_desde" name="fecha_desde" value="{{ request('fecha_desde') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <!-- Fecha hasta -->
                    <div>
                        <label for="fecha_hasta" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha Hasta</label>
                        <input type="date" id="fecha_hasta" name="fecha_hasta" value="{{ request('fecha_hasta') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <!-- Estado -->
                    <div>
                        <label for="estado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                        <select id="estado" name="estado" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Todos</option>
                            <option value="completado" {{ request('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
                            <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="rechazado" {{ request('estado') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                        </select>
                    </div>

                    <!-- Botones -->
                    <div class="md:col-span-4 flex gap-2">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            <i class="fas fa-search mr-2"></i>Filtrar
                        </button>
                        <a href="{{ route('pagos.index') }}" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            <i class="fas fa-times mr-2"></i>Limpiar
                        </a>
                    </div>
                </form>
            </div>

            <!-- Mensajes de éxito y error -->
            @if(session('success'))
            <div class="mb-4 flex items-center p-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>{{ session('success') }}</div>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-4 flex items-center p-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Error</span>
                <div>{{ session('error') }}</div>
            </div>
            @endif

            <!-- Tabla de Pagos -->
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">N° Recibo</th>
                            <th scope="col" class="px-6 py-3">Cliente</th>
                            <th scope="col" class="px-6 py-3">Préstamo</th>
                            <th scope="col" class="px-6 py-3">Monto Pagado</th>
                            <th scope="col" class="px-6 py-3">Método de Pago</th>
                            <th scope="col" class="px-6 py-3">Fecha de Pago</th>
                            <th scope="col" class="px-6 py-3">Estado</th>
                            <th scope="col" class="px-6 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pagos as $pago)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $pago->numero_recibo ?? 'N/A' }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $pago->prestamo->cliente->nombre ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4">
                                Préstamo #{{ $pago->prestamo_id }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                {{ money_symbol($pago->monto_pagado) }}
                            </td>
                            <td class="px-6 py-4">
                                @switch($pago->metodo_pago)
                                    @case('efectivo')
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded dark:bg-green-900 dark:text-green-300">
                                            <i class="fas fa-money-bill-wave mr-1"></i>Efectivo
                                        </span>
                                        @break
                                    @case('transferencia_bancaria')
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded dark:bg-blue-900 dark:text-blue-300">
                                            <i class="fas fa-exchange-alt mr-1"></i>Transferencia
                                        </span>
                                        @break
                                    @case('deposito_bancario')
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-purple-800 bg-purple-100 rounded dark:bg-purple-900 dark:text-purple-300">
                                            <i class="fas fa-university mr-1"></i>Depósito
                                        </span>
                                        @break
                                    @case('cheque')
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded dark:bg-yellow-900 dark:text-yellow-300">
                                            <i class="fas fa-money-check mr-1"></i>Cheque
                                        </span>
                                        @break
                                    @default
                                        <span class="text-gray-600">{{ $pago->metodo_pago }}</span>
                                @endswitch
                            </td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                @switch($pago->estado)
                                    @case('completado')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Completado</span>
                                        @break
                                    @case('pendiente')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Pendiente</span>
                                        @break
                                    @case('rechazado')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Rechazado</span>
                                        @break
                                    @default
                                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ $pago->estado }}</span>
                                @endswitch
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <!-- Ver Detalle -->
                                    <a href="{{ route('pagos.show', $pago->id) }}"
                                       class="inline-flex items-center px-3 py-2 text-xs font-medium text-center text-white bg-blue-600 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                       title="Ver Detalle">
                                        <i class="fas fa-eye mr-1.5"></i>
                                        <span>Ver</span>
                                    </a>

                                    <!-- Recibo PDF - Solo para pagos procesados (no pendientes ni rechazados) -->
                                    @if(!in_array($pago->estado, ['pendiente', 'rechazado']))
                                        <a href="{{ route('pagos.recibo', $pago->id) }}"
                                           target="_blank"
                                           class="inline-flex items-center px-3 py-2 text-xs font-medium text-center text-white bg-green-600 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-500 dark:hover:bg-green-700 dark:focus:ring-green-800"
                                           title="Imprimir Recibo PDF">
                                            <i class="fas fa-file-pdf mr-1.5"></i>
                                            <span>Recibo</span>
                                        </a>
                                    @else
                                        <span class="inline-flex items-center px-3 py-2 text-xs font-medium text-gray-400 dark:text-gray-500" title="Solo se pueden imprimir recibos de pagos procesados">
                                            <i class="fas fa-ban mr-1.5"></i>
                                            <span>N/D</span>
                                        </span>
                                    @endif

                                    <!-- Editar Pago -->
                                    <a href="{{ route('pagos.edit', $pago->id) }}"
                                       class="inline-flex items-center px-3 py-2 text-xs font-medium text-center text-white bg-yellow-500 rounded-lg hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-400 dark:hover:bg-yellow-500 dark:focus:ring-yellow-800"
                                       title="Editar Pago">
                                        <i class="fas fa-edit mr-1.5"></i>
                                        <span>Editar</span>
                                    </a>

                                    <!-- Eliminar Pago -->
                                    <form action="{{ route('pagos.destroy', $pago->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Está seguro de eliminar este pago? Esta acción revertirá los montos del préstamo.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-2 text-xs font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-700 dark:focus:ring-red-800"
                                                title="Eliminar Pago">
                                            <i class="fas fa-trash mr-1.5"></i>
                                            <span>Eliminar</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                <i class="fas fa-inbox text-4xl mb-3"></i>
                                <p>No se encontraron pagos registrados</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($pagos->hasPages())
            <div class="mt-4">
                {{ $pagos->links() }}
            </div>
            @endif
</x-flowbite-layout>
