<x-flowbite-layout>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                <svg class="w-7 h-7 inline mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Contratos
            </h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Gestión de contratos entre clientes y contratistas</p>
        </div>
        <a href="{{ route('contratos.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Nuevo Contrato
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filtros -->
    <div class="mb-6 p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <form method="GET" action="{{ route('contratos.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por número, título, cliente, contratista..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
            </div>
            <div class="w-48">
                <select name="estado" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Todos los estados</option>
                    <option value="borrador" {{ request('estado') == 'borrador' ? 'selected' : '' }}>Borrador</option>
                    <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="finalizado" {{ request('estado') == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                    <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5">Buscar</button>
                <a href="{{ route('contratos.index') }}" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-4 py-2.5">Limpiar</a>
            </div>
        </form>
    </div>

    <!-- Tabla -->
    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3">Número</th>
                        <th scope="col" class="px-4 py-3">Título</th>
                        <th scope="col" class="px-4 py-3">Cliente</th>
                        <th scope="col" class="px-4 py-3">Contratista</th>
                        <th scope="col" class="px-4 py-3">Venta</th>
                        <th scope="col" class="px-4 py-3">Monto</th>
                        <th scope="col" class="px-4 py-3">Fecha</th>
                        <th scope="col" class="px-4 py-3">Estado</th>
                        <th scope="col" class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contratos as $contrato)
                        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $contrato->numero_contrato }}</td>
                            <td class="px-4 py-3">{{ Str::limit($contrato->titulo, 40) }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('clientes.show', $contrato->cliente_id) }}" class="text-blue-600 hover:underline">
                                    {{ $contrato->cliente->nombre_completo ?? 'N/A' }}
                                </a>
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('contratistas.show', $contrato->contratista_id) }}" class="text-blue-600 hover:underline">
                                    {{ $contrato->contratista->nombre_completo ?? 'N/A' }}
                                </a>
                            </td>
                            <td class="px-4 py-3">{{ $contrato->prestamo->numero_prestamo ?? 'N/A' }}</td>
                            <td class="px-4 py-3 font-semibold">
                                @if($contrato->monto_contrato)
                                    Q{{ number_format($contrato->monto_contrato, 2) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ $contrato->fecha_contrato->format('d/m/Y') }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $colors = ['borrador' => 'yellow', 'activo' => 'green', 'finalizado' => 'blue', 'cancelado' => 'red'];
                                    $color = $colors[$contrato->estado] ?? 'gray';
                                @endphp
                                <span class="bg-{{ $color }}-100 text-{{ $color }}-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-{{ $color }}-900 dark:text-{{ $color }}-300">
                                    {{ ucfirst($contrato->estado) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('contratos.show', $contrato) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400" title="Ver">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="{{ route('contratos.edit', $contrato) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400" title="Editar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('contratos.destroy', $contrato) }}" method="POST" onsubmit="return confirm('¿Está seguro de eliminar este contrato?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400" title="Eliminar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                                No se encontraron contratos.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($contratos->hasPages())
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                {{ $contratos->links() }}
            </div>
        @endif
    </div>
</x-flowbite-layout>
