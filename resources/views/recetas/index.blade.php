<x-flowbite-layout>
    <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Recetas de Construcción</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Plantillas de materiales para proyectos</p>
                </div>
                <a href="{{ route('recetas.create') }}" class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"/>
                    </svg>
                    Nueva Receta
                </a>
            </div>

            @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <select name="tipo_vivienda" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Todos los tipos</option>
                        <option value="casa_basica" {{ request('tipo_vivienda') == 'casa_basica' ? 'selected' : '' }}>Casa Básica</option>
                        <option value="casa_mediana" {{ request('tipo_vivienda') == 'casa_mediana' ? 'selected' : '' }}>Casa Mediana</option>
                        <option value="casa_grande" {{ request('tipo_vivienda') == 'casa_grande' ? 'selected' : '' }}>Casa Grande</option>
                        <option value="ampliacion" {{ request('tipo_vivienda') == 'ampliacion' ? 'selected' : '' }}>Ampliación</option>
                    </select>
                    <select name="es_plantilla" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Todas</option>
                        <option value="1" {{ request('es_plantilla') === '1' ? 'selected' : '' }}>Solo Plantillas</option>
                        <option value="0" {{ request('es_plantilla') === '0' ? 'selected' : '' }}>Solo Personalizadas</option>
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
                            <th class="px-6 py-3">Nombre</th>
                            <th class="px-6 py-3">Tipo</th>
                            <th class="px-6 py-3">Cliente</th>
                            <th class="px-6 py-3">Área (m²)</th>
                            <th class="px-6 py-3">Costo Total</th>
                            <th class="px-6 py-3">Plantilla</th>
                            <th class="px-6 py-3">Estado</th>
                            <th class="px-6 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recetas as $receta)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $receta->nombre }}
                            </td>
                            <td class="px-6 py-4">{{ $receta->tipo_vivienda }}</td>
                            <td class="px-6 py-4">{{ $receta->cliente->nombre ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $receta->area_construccion ? number_format($receta->area_construccion, 2) : 'N/A' }}</td>
                            <td class="px-6 py-4 font-medium">Q {{ number_format($receta->costo_total, 2) }}</td>
                            <td class="px-6 py-4">
                                @if($receta->es_plantilla)
                                    <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-purple-900 dark:text-purple-300">Plantilla</span>
                                @else
                                    <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">Personalizada</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-{{ $receta->estado == 'activo' ? 'green' : 'red' }}-100 text-{{ $receta->estado == 'activo' ? 'green' : 'red' }}-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                    {{ ucfirst($receta->estado) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('recetas.show', $receta) }}" class="inline-flex items-center text-blue-600 hover:underline">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Ver
                                    </a>
                                    <a href="{{ route('recetas.edit', $receta) }}" class="inline-flex items-center text-yellow-600 hover:underline">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                        </svg>
                                        Editar
                                    </a>
                                    <form action="{{ route('recetas.clonar', $receta) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center text-purple-600 hover:underline">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M7 9a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2H9a2 2 0 01-2-2V9z"/>
                                                <path d="M5 3a2 2 0 00-2 2v6a2 2 0 002 2V5h8a2 2 0 00-2-2H5z"/>
                                            </svg>
                                            Clonar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">No se encontraron recetas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $recetas->links() }}
            </div>
        </div>
</x-flowbite-layout>
