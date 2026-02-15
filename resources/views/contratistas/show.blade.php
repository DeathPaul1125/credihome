<x-flowbite-layout>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                <i class="fas fa-hard-hat mr-2"></i>{{ $contratista->nombre_completo }}
            </h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Código: {{ $contratista->codigo }}</p>
        </div>
        <div class="flex gap-2">
            @can('editar-contratistas')
            <a href="{{ route('contratistas.edit', $contratista) }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                <i class="fas fa-edit mr-2"></i>Editar
            </a>
            @endcan
            <a href="{{ route('contratistas.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                <i class="fas fa-arrow-left mr-2"></i>Volver
            </a>
        </div>
    </div>

    <!-- Tabs -->
    <div class="mb-6 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" role="tablist">
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg {{ request('tab', 'info') == 'info' ? 'border-blue-600 text-blue-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}" type="button" role="tab" onclick="window.location.href='{{ route('contratistas.show', ['contratista' => $contratista->id, 'tab' => 'info']) }}'">
                    <i class="fas fa-info-circle mr-2"></i>Información
                </button>
            </li>
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg {{ request('tab') == 'proyectos' ? 'border-blue-600 text-blue-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}" type="button" role="tab" onclick="window.location.href='{{ route('contratistas.show', ['contratista' => $contratista->id, 'tab' => 'proyectos']) }}'">
                    <i class="fas fa-building mr-2"></i>Proyectos ({{ $contratista->proyectos->count() }})
                </button>
            </li>
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg {{ request('tab') == 'archivos' ? 'border-blue-600 text-blue-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}" type="button" role="tab" onclick="window.location.href='{{ route('contratistas.show', ['contratista' => $contratista->id, 'tab' => 'archivos']) }}'">
                    <i class="fas fa-file-alt mr-2"></i>Archivos ({{ $contratista->archivos->count() }})
                </button>
            </li>
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg {{ request('tab') == 'contratos' ? 'border-blue-600 text-blue-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}" type="button" role="tab" onclick="window.location.href='{{ route('contratistas.show', ['contratista' => $contratista->id, 'tab' => 'contratos']) }}'">
                    <i class="fas fa-file-contract mr-2"></i>Contratos ({{ $contratista->contratos->count() }})
                </button>
            </li>
        </ul>
    </div>

    <!-- Tab Content: Información -->
    @if(request('tab', 'info') == 'info')
    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Información Personal -->
            <div class="col-span-2">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-user mr-2 text-blue-600"></i>Información Personal
                </h3>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Nombre Completo</label>
                <p class="text-gray-900 dark:text-white">{{ $contratista->nombre_completo }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Nombre de Empresa</label>
                <p class="text-gray-900 dark:text-white">{{ $contratista->nombre_empresa ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">DPI</label>
                <p class="text-gray-900 dark:text-white">{{ $contratista->dpi ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">NIT</label>
                <p class="text-gray-900 dark:text-white">{{ $contratista->nit ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Estado</label>
                @if($contratista->estado === 'activo')
                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Activo</span>
                @elseif($contratista->estado === 'inactivo')
                <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">Inactivo</span>
                @else
                <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Suspendido</span>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Calificación</label>
                @if($contratista->calificacion > 0)
                <div class="flex items-center">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $contratista->calificacion)
                        <i class="fas fa-star text-yellow-400"></i>
                        @else
                        <i class="far fa-star text-gray-300"></i>
                        @endif
                    @endfor
                    <span class="ml-2 text-gray-900 dark:text-white font-semibold">{{ number_format($contratista->calificacion, 1) }}</span>
                </div>
                @else
                <span class="text-gray-400">Sin calificar</span>
                @endif
            </div>

            <!-- Información de Contacto -->
            <div class="col-span-2 mt-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-phone mr-2 text-green-600"></i>Información de Contacto
                </h3>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Teléfono 1</label>
                <p class="text-gray-900 dark:text-white">
                    <a href="tel:{{ $contratista->telefono1 }}" class="text-blue-600 hover:underline">{{ $contratista->telefono1 }}</a>
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Teléfono 2</label>
                <p class="text-gray-900 dark:text-white">
                    @if($contratista->telefono2)
                    <a href="tel:{{ $contratista->telefono2 }}" class="text-blue-600 hover:underline">{{ $contratista->telefono2 }}</a>
                    @else
                    -
                    @endif
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Email</label>
                <p class="text-gray-900 dark:text-white">
                    @if($contratista->email)
                    <a href="mailto:{{ $contratista->email }}" class="text-blue-600 hover:underline">{{ $contratista->email }}</a>
                    @else
                    -
                    @endif
                </p>
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Dirección</label>
                <p class="text-gray-900 dark:text-white">{{ $contratista->direccion ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Municipio</label>
                <p class="text-gray-900 dark:text-white">{{ $contratista->municipio ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Departamento</label>
                <p class="text-gray-900 dark:text-white">{{ $contratista->departamento ?? '-' }}</p>
            </div>

            <!-- Información Profesional -->
            <div class="col-span-2 mt-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-briefcase mr-2 text-purple-600"></i>Información Profesional
                </h3>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Especialidad</label>
                <p class="text-gray-900 dark:text-white">{{ $contratista->especialidad ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo de Servicio</label>
                @if($contratista->tipo_servicio === 'construccion')
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Construcción</span>
                @elseif($contratista->tipo_servicio === 'remodelacion')
                <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-purple-900 dark:text-purple-300">Remodelación</span>
                @else
                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Ambos</span>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Años de Experiencia</label>
                <p class="text-gray-900 dark:text-white">{{ $contratista->anos_experiencia ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Proyectos Completados</label>
                <p class="text-gray-900 dark:text-white font-semibold">{{ $contratista->proyectosCompletados()->count() }}</p>
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Servicios Ofrecidos</label>
                <p class="text-gray-900 dark:text-white">{{ $contratista->servicios_ofrecidos ?? '-' }}</p>
            </div>

            @if($contratista->notas)
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Notas</label>
                <p class="text-gray-900 dark:text-white">{{ $contratista->notas }}</p>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Tab Content: Proyectos -->
    @if(request('tab') == 'proyectos')
    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg p-6">
        @can('crear-contratistas')
        <div class="mb-6">
            <button type="button" onclick="document.getElementById('modal-proyecto').classList.remove('hidden')" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                <i class="fas fa-plus mr-2"></i>Agregar Proyecto
            </button>
        </div>
        @endcan

        @if($contratista->proyectos->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3">Proyecto</th>
                        <th scope="col" class="px-4 py-3">Cliente</th>
                        <th scope="col" class="px-4 py-3">Tipo</th>
                        <th scope="col" class="px-4 py-3">Monto</th>
                        <th scope="col" class="px-4 py-3">Fechas</th>
                        <th scope="col" class="px-4 py-3">Estado</th>
                        <th scope="col" class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contratista->proyectos as $proyecto)
                    <tr class="border-b dark:border-gray-700">
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-900 dark:text-white">{{ $proyecto->nombre_proyecto }}</div>
                            @if($proyecto->ubicacion)
                            <div class="text-xs text-gray-500"><i class="fas fa-map-marker-alt mr-1"></i>{{ $proyecto->ubicacion }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $proyecto->cliente ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @if($proyecto->tipo_proyecto === 'construccion_nueva')
                            <span class="text-xs">Construcción Nueva</span>
                            @elseif($proyecto->tipo_proyecto === 'remodelacion')
                            <span class="text-xs">Remodelación</span>
                            @elseif($proyecto->tipo_proyecto === 'ampliacion')
                            <span class="text-xs">Ampliación</span>
                            @else
                            <span class="text-xs">Otro</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $proyecto->monto_proyecto ? money_symbol($proyecto->monto_proyecto) : '-' }}</td>
                        <td class="px-4 py-3">
                            @if($proyecto->fecha_inicio)
                            <div class="text-xs">{{ $proyecto->fecha_inicio->format('d/m/Y') }}</div>
                            @if($proyecto->fecha_fin)
                            <div class="text-xs text-gray-500">al {{ $proyecto->fecha_fin->format('d/m/Y') }}</div>
                            @endif
                            @else
                            -
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($proyecto->estado === 'completado')
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Completado</span>
                            @elseif($proyecto->estado === 'en_proceso')
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">En Proceso</span>
                            @elseif($proyecto->estado === 'planificacion')
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Planificación</span>
                            @else
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Cancelado</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @can('eliminar-contratistas')
                            <form action="{{ route('contratistas.eliminar-proyecto', ['contratista' => $contratista, 'proyecto' => $proyecto]) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este proyecto?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-center text-gray-500 dark:text-gray-400 py-8">No hay proyectos registrados.</p>
        @endif
    </div>
    @endif

    <!-- Tab Content: Archivos -->
    @if(request('tab') == 'archivos')
    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg p-6">
        @can('crear-contratistas')
        <div class="mb-6">
            <button type="button" onclick="document.getElementById('modal-archivo').classList.remove('hidden')" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                <i class="fas fa-upload mr-2"></i>Subir Archivo
            </button>
        </div>
        @endcan

        @if($contratista->archivos->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($contratista->archivos as $archivo)
            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                <div class="flex items-start justify-between mb-2">
                    <div class="flex-1">
                        <div class="flex items-center mb-1">
                            @if(str_contains($archivo->mime_type, 'pdf'))
                            <i class="fas fa-file-pdf text-red-600 text-2xl mr-2"></i>
                            @elseif(str_contains($archivo->mime_type, 'image'))
                            <i class="fas fa-file-image text-blue-600 text-2xl mr-2"></i>
                            @elseif(str_contains($archivo->mime_type, 'word'))
                            <i class="fas fa-file-word text-blue-700 text-2xl mr-2"></i>
                            @else
                            <i class="fas fa-file text-gray-600 text-2xl mr-2"></i>
                            @endif
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ $archivo->nombre_archivo }}</h4>
                                <p class="text-xs text-gray-500">{{ $archivo->tamano_kb }} KB</p>
                            </div>
                        </div>
                        <div class="mt-2">
                            @if($archivo->tipo_documento === 'dpi')
                            <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded">DPI</span>
                            @elseif($archivo->tipo_documento === 'cedula_comercio')
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">Cédula Comercio</span>
                            @elseif($archivo->tipo_documento === 'patente_comercio')
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Patente</span>
                            @else
                            <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">{{ ucfirst(str_replace('_', ' ', $archivo->tipo_documento)) }}</span>
                            @endif
                        </div>
                        @if($archivo->descripcion)
                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">{{ $archivo->descripcion }}</p>
                        @endif
                        @if($archivo->fecha_vigencia)
                        <div class="mt-2 text-xs">
                            @if($archivo->esta_vencido)
                            <span class="text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>Vencido</span>
                            @elseif($archivo->esta_por_vencer)
                            <span class="text-yellow-600"><i class="fas fa-clock mr-1"></i>Por vencer</span>
                            @else
                            <span class="text-green-600"><i class="fas fa-check-circle mr-1"></i>Vigente</span>
                            @endif
                            <span class="text-gray-500">hasta {{ $archivo->fecha_vigencia->format('d/m/Y') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="flex gap-2 mt-3">
                    <a href="{{ route('contratistas.descargar-archivo', ['contratista' => $contratista, 'archivo' => $archivo]) }}" class="text-blue-600 hover:text-blue-800 text-xs">
                        <i class="fas fa-download mr-1"></i>Descargar
                    </a>
                    @can('eliminar-contratistas')
                    <form action="{{ route('contratistas.eliminar-archivo', ['contratista' => $contratista, 'archivo' => $archivo]) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este archivo?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-xs">
                            <i class="fas fa-trash mr-1"></i>Eliminar
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-center text-gray-500 dark:text-gray-400 py-8">No hay archivos adjuntos.</p>
        @endif
    </div>
    @endif

    <!-- Tab Content: Contratos -->
    @if(request('tab') == 'contratos')
    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Contratos</h2>
            <a href="{{ route('contratos.create') }}?contratista_id={{ $contratista->id }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nuevo Contrato
            </a>
        </div>

        @if($contratista->contratos->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-3">Número</th>
                        <th class="px-4 py-3">Título</th>
                        <th class="px-4 py-3">Cliente</th>
                        <th class="px-4 py-3">Monto</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contratista->contratos as $contrato)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $contrato->numero_contrato }}</td>
                        <td class="px-4 py-3">{{ $contrato->titulo }}</td>
                        <td class="px-4 py-3">
                            @if($contrato->cliente)
                                <a href="{{ route('clientes.show', $contrato->cliente_id) }}" class="text-blue-600 hover:underline">{{ $contrato->cliente->nombre_completo }}</a>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $contrato->monto_contrato ? 'Q' . number_format($contrato->monto_contrato, 2) : '-' }}</td>
                        <td class="px-4 py-3">
                            @php
                                $colors = ['borrador' => 'yellow', 'activo' => 'green', 'finalizado' => 'blue', 'cancelado' => 'red'];
                                $cc = $colors[$contrato->estado] ?? 'gray';
                            @endphp
                            <span class="bg-{{ $cc }}-100 text-{{ $cc }}-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-{{ $cc }}-900 dark:text-{{ $cc }}-300">{{ ucfirst($contrato->estado) }}</span>
                        </td>
                        <td class="px-4 py-3">{{ $contrato->fecha_contrato->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('contratos.show', $contrato) }}" class="text-blue-600 hover:underline text-xs mr-2">Ver</a>
                            <a href="{{ route('contratos.edit', $contrato) }}" class="text-yellow-600 hover:underline text-xs">Editar</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-center text-gray-500 dark:text-gray-400 py-8">No hay contratos registrados para este contratista.</p>
        @endif
    </div>
    @endif

    <!-- Modal Agregar Proyecto -->
    <div id="modal-proyecto" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Agregar Proyecto</h3>
                <button onclick="document.getElementById('modal-proyecto').classList.add('hidden')" class="text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('contratistas.agregar-proyecto', $contratista) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del Proyecto *</label>
                        <input type="text" name="nombre_proyecto" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cliente</label>
                        <input type="text" name="cliente" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ubicación</label>
                        <input type="text" name="ubicacion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de Proyecto *</label>
                        <select name="tipo_proyecto" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="construccion_nueva">Construcción Nueva</option>
                            <option value="remodelacion">Remodelación</option>
                            <option value="ampliacion">Ampliación</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Monto del Proyecto (Q)</label>
                        <input type="number" name="monto_proyecto" step="0.01" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha Fin</label>
                        <input type="date" name="fecha_fin" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado *</label>
                        <select name="estado" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="planificacion">Planificación</option>
                            <option value="en_proceso">En Proceso</option>
                            <option value="completado">Completado</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                        <textarea name="descripcion" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                    </div>
                    <div class="col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Materiales Utilizados</label>
                        <textarea name="materiales_utilizados" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                    </div>
                </div>
                <div class="flex gap-2 mt-4">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        Guardar Proyecto
                    </button>
                    <button type="button" onclick="document.getElementById('modal-proyecto').classList.add('hidden')" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Subir Archivo -->
    <div id="modal-archivo" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-lg">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Subir Archivo</h3>
                <button onclick="document.getElementById('modal-archivo').classList.add('hidden')" class="text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('contratistas.subir-archivo', $contratista) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de Documento *</label>
                        <select name="tipo_documento" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="dpi">DPI</option>
                            <option value="cedula_comercio">Cédula de Comercio</option>
                            <option value="patente_comercio">Patente de Comercio</option>
                            <option value="certificacion_laboral">Certificación Laboral</option>
                            <option value="certificacion_tecnica">Certificación Técnica</option>
                            <option value="titulo_profesional">Título Profesional</option>
                            <option value="referencias">Referencias</option>
                            <option value="contrato">Contrato</option>
                            <option value="foto_proyecto">Foto de Proyecto</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Archivo * (Máx. 10MB)</label>
                        <input type="file" name="archivo" required class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de Vigencia</label>
                        <input type="date" name="fecha_vigencia" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <p class="mt-1 text-xs text-gray-500">Para documentos con vencimiento</p>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                        <textarea name="descripcion" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                    </div>
                </div>
                <div class="flex gap-2 mt-4">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        Subir Archivo
                    </button>
                    <button type="button" onclick="document.getElementById('modal-archivo').classList.add('hidden')" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-flowbite-layout>
