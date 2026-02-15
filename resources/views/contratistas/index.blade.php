<x-flowbite-layout>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                <i class="fas fa-hard-hat mr-2"></i>Contratistas
            </h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Gestión de contratistas para construcción</p>
        </div>
        @can('crear-contratistas')
        <a href="{{ route('contratistas.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            <i class="fas fa-plus mr-2"></i>Nuevo Contratista
        </a>
        @endcan
    </div>

    <!-- Filtros -->
    <div class="mb-6 p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <form method="GET" action="{{ route('contratistas.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre, código, teléfono..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
            </div>
            <div class="w-48">
                <select name="estado" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Todos los estados</option>
                    <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    <option value="suspendido" {{ request('estado') == 'suspendido' ? 'selected' : '' }}>Suspendido</option>
                </select>
            </div>
            <div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <i class="fas fa-search mr-2"></i>Buscar
                </button>
            </div>
            @if(request()->hasAny(['buscar', 'estado']))
            <div>
                <a href="{{ route('contratistas.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                    <i class="fas fa-times mr-2"></i>Limpiar
                </a>
            </div>
            @endif
        </form>
    </div>

    <!-- Tabla de Contratistas -->
    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3">Código</th>
                        <th scope="col" class="px-4 py-3">Nombre</th>
                        <th scope="col" class="px-4 py-3">Empresa</th>
                        <th scope="col" class="px-4 py-3">Teléfono</th>
                        <th scope="col" class="px-4 py-3">Especialidad</th>
                        <th scope="col" class="px-4 py-3">Proyectos</th>
                        <th scope="col" class="px-4 py-3">Calificación</th>
                        <th scope="col" class="px-4 py-3">Estado</th>
                        <th scope="col" class="px-4 py-3">
                            <span class="sr-only">Acciones</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contratistas as $contratista)
                    <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                            {{ $contratista->codigo }}
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('contratistas.show', $contratista) }}" class="text-blue-600 hover:underline dark:text-blue-500">
                                {{ $contratista->nombre_completo }}
                            </a>
                        </td>
                        <td class="px-4 py-3">{{ $contratista->nombre_empresa ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <i class="fas fa-phone text-green-600 mr-1"></i>{{ $contratista->telefono1 }}
                        </td>
                        <td class="px-4 py-3">{{ $contratista->especialidad ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                {{ $contratista->proyectos_completados_count }}/{{ $contratista->proyectos_count }} completados
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @if($contratista->calificacion > 0)
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-400 mr-1"></i>
                                <span class="font-semibold">{{ number_format($contratista->calificacion, 1) }}</span>
                            </div>
                            @else
                            <span class="text-gray-400">Sin calificar</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($contratista->estado === 'activo')
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Activo</span>
                            @elseif($contratista->estado === 'inactivo')
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">Inactivo</span>
                            @else
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Suspendido</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 flex items-center justify-end gap-2">
                            <a href="{{ route('contratistas.show', $contratista) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-500" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            @can('editar-contratistas')
                            <a href="{{ route('contratistas.edit', $contratista) }}" class="text-green-600 hover:text-green-900 dark:text-green-500" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan
                            @can('eliminar-contratistas')
                            <form action="{{ route('contratistas.destroy', $contratista) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de eliminar este contratista?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-500" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                            No se encontraron contratistas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="px-4 py-3">
            {{ $contratistas->links() }}
        </div>
    </div>
</x-flowbite-layout>
