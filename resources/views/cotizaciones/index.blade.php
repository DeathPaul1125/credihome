<x-flowbite-layout>
    <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Cotizaciones</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Presupuestos de materiales para clientes</p>
                </div>
                @can('crear-cotizaciones')
                <a href="{{ route('cotizaciones.create') }}" class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"/>
                    </svg>
                    Nueva Cotización
                </a>
                @endcan
            </div>

            @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
                {{ session('success') }}
            </div>
            @endif

            @if(session('info'))
            <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400">
                {{ session('info') }}
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por número o cliente..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <select name="estado" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Todos los estados</option>
                        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="aprobada" {{ request('estado') == 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                        <option value="rechazada" {{ request('estado') == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                        <option value="vencida" {{ request('estado') == 'vencida' ? 'selected' : '' }}>Vencida</option>
                        <option value="convertida" {{ request('estado') == 'convertida' ? 'selected' : '' }}>Convertida</option>
                    </select>
                    <button type="submit" class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 rounded-lg text-sm px-5 py-2.5">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                        </svg>
                        Filtrar
                    </button>
                </form>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">Número</th>
                            <th class="px-6 py-3">Cliente</th>
                            <th class="px-6 py-3">Fecha Emisión</th>
                            <th class="px-6 py-3">Vencimiento</th>
                            <th class="px-6 py-3">Total</th>
                            <th class="px-6 py-3">Estado</th>
                            <th class="px-6 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cotizaciones as $cotizacion)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $cotizacion->numero_cotizacion }}
                            </td>
                            <td class="px-6 py-4">{{ $cotizacion->cliente->nombre }}</td>
                            <td class="px-6 py-4">{{ $cotizacion->fecha_emision->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">{{ $cotizacion->fecha_vencimiento->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 font-medium">{{ money_symbol($cotizacion->total) }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium
                                    @if($cotizacion->estado === 'pendiente') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                    @elseif($cotizacion->estado === 'aprobada') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                    @elseif($cotizacion->estado === 'rechazada') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                    @elseif($cotizacion->estado === 'vencida') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                    @else bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                    @endif">
                                    {{ ucfirst($cotizacion->estado) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('cotizaciones.show', $cotizacion) }}" class="inline-flex items-center text-blue-600 hover:underline dark:text-blue-500">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Ver
                                    </a>
                                    @can('editar-cotizaciones')
                                    @if(!in_array($cotizacion->estado, ['aprobada', 'convertida', 'rechazada']))
                                    <a href="{{ route('cotizaciones.edit', $cotizacion) }}" class="inline-flex items-center text-yellow-600 hover:underline dark:text-yellow-500">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                        </svg>
                                        Editar
                                    </a>
                                    @endif
                                    @endcan
                                    @can('aprobar-cotizaciones')
                                    @if($cotizacion->estado === 'pendiente')
                                    <form action="{{ route('cotizaciones.aprobar', $cotizacion) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center text-green-600 hover:underline dark:text-green-500">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Aprobar
                                        </button>
                                    </form>
                                    @endif
                                    @endcan
                                    @can('convertir-cotizaciones')
                                    @if($cotizacion->estado === 'aprobada' && !$cotizacion->prestamo_id)
                                    <form action="{{ route('cotizaciones.convertir', $cotizacion) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center text-purple-600 hover:underline dark:text-purple-500">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            </svg>
                                            Préstamo
                                        </button>
                                    </form>
                                    @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">No se encontraron cotizaciones</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $cotizaciones->links() }}
            </div>
</x-flowbite-layout>
