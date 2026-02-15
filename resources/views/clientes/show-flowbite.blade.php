<x-flowbite-layout>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $cliente->nombre_completo }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">DPI: {{ $cliente->dpi }}</p>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('clientes.edit', $cliente->id) }}" class="text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:focus:ring-yellow-900">
                    Editar
                </a>
                <a href="{{ route('clientes.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                    Volver
                </a>
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

    <!-- Pestañas -->
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg border-blue-600 text-white bg-blue-600 hover:text-white hover:border-blue-600 dark:text-white dark:border-blue-500 dark:bg-blue-500" id="informacion-tab" data-tabs-target="#informacion" type="button" role="tab" aria-controls="informacion" aria-selected="true">Información General</button>
            </li>
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg text-white bg-gray-600 hover:text-white hover:bg-gray-700 dark:text-white dark:bg-gray-700 dark:hover:bg-gray-600" id="prestamos-tab" data-tabs-target="#prestamos" type="button" role="tab" aria-controls="prestamos" aria-selected="false">Préstamos</button>
            </li>
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg text-white bg-gray-600 hover:text-white hover:bg-gray-700 dark:text-white dark:bg-gray-700 dark:hover:bg-gray-600" id="archivos-tab" data-tabs-target="#archivos" type="button" role="tab" aria-controls="archivos" aria-selected="false">Archivos</button>
            </li>
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg text-white bg-gray-600 hover:text-white hover:bg-gray-700 dark:text-white dark:bg-gray-700 dark:hover:bg-gray-600" id="fotos-tab" data-tabs-target="#fotos" type="button" role="tab" aria-controls="fotos" aria-selected="false">Fotos del Proyecto</button>
            </li>
        </ul>
    </div>

    <div id="default-tab-content">
        <!-- Información General -->
        <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="informacion" role="tabpanel" aria-labelledby="informacion-tab">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <!-- Información Personal -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Información Personal</h2>
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre Completo</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cliente->nombre_completo }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">DPI</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cliente->dpi }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Nacimiento</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cliente->fecha_nacimiento ? $cliente->fecha_nacimiento->format('d/m/Y') : 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Género</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ ucfirst($cliente->genero ?? 'N/A') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado Civil</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $cliente->estado_civil ?? 'N/A')) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cliente->telefono }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cliente->email ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $cliente->estado === 'activo' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                        {{ ucfirst($cliente->estado) }}
                                    </span>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Información Adicional -->
                <div class="space-y-4">
                    <!-- Dirección -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Dirección</h2>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-gray-900 dark:text-white">{{ $cliente->direccion_completa }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                {{ $cliente->departamento }}, {{ $cliente->municipio }}
                                @if($cliente->zona)
                                    - Zona {{ $cliente->zona }}
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Información Laboral -->
                    @if($cliente->profesion || $cliente->lugar_trabajo || $cliente->ingreso_mensual)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Información Laboral</h2>
                        </div>
                        <div class="p-6">
                            <dl class="space-y-2">
                                @if($cliente->profesion)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Profesión</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cliente->profesion }}</dd>
                                </div>
                                @endif
                                @if($cliente->lugar_trabajo)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Lugar de Trabajo</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cliente->lugar_trabajo }}</dd>
                                </div>
                                @endif
                                @if($cliente->puesto_trabajo)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Puesto</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cliente->puesto_trabajo }}</dd>
                                </div>
                                @endif
                                @if($cliente->ingreso_mensual)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Ingreso Mensual</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ money_symbol($cliente->ingreso_mensual) }}</dd>
                                </div>
                                @endif
                            </dl>
                        </div>
                    </div>
                    @endif

                    <!-- Referencias -->
                    @if($cliente->referencia_nombre_1 || $cliente->referencia_nombre_2)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Referencias</h2>
                        </div>
                        <div class="p-6">
                            @if($cliente->referencia_nombre_1)
                            <div class="mb-4">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">Referencia 1</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $cliente->referencia_nombre_1 }}</p>
                                @if($cliente->referencia_telefono_1)
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $cliente->referencia_telefono_1 }}</p>
                                @endif
                                @if($cliente->referencia_parentesco_1)
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $cliente->referencia_parentesco_1 }}</p>
                                @endif
                            </div>
                            @endif
                            @if($cliente->referencia_nombre_2)
                            <div>
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">Referencia 2</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $cliente->referencia_nombre_2 }}</p>
                                @if($cliente->referencia_telefono_2)
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $cliente->referencia_telefono_2 }}</p>
                                @endif
                                @if($cliente->referencia_parentesco_2)
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $cliente->referencia_parentesco_2 }}</p>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Acceso al Portal del Cliente -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Portal del Cliente</h2>
                        </div>
                        <div class="p-6">
                            @if($cliente->portal_user_id && $cliente->portalUser)
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                                            Portal {{ $cliente->portal_activo ? 'Activo' : 'Desactivado' }}
                                        </span>
                                    </div>

                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Usuario</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cliente->portalUser->email }}</dd>
                                    </div>

                                    <div class="flex flex-wrap gap-2">
                                        @if($cliente->portal_activo)
                                            <form action="{{ route('clientes.desactivar-portal', $cliente->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2">
                                                    Desactivar Portal
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('clientes.activar-portal', $cliente->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2">
                                                    Reactivar Portal
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('clientes.regenerar-password', $cliente->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">
                                                Regenerar Contraseña
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                    El cliente aún no tiene acceso al portal. Activa el portal para que pueda consultar sus préstamos y subir comprobantes de pago.
                                </p>
                                <form action="{{ route('clientes.activar-portal', $cliente->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                        🔓 Activar Portal
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if($cliente->notas)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow mt-4">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Notas</h2>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-900 dark:text-white">{{ $cliente->notas }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Préstamos -->
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="prestamos" role="tabpanel" aria-labelledby="prestamos-tab">
            @if($cliente->prestamos->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Historial de Préstamos</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">N° Préstamo</th>
                                <th scope="col" class="px-6 py-3">Monto</th>
                                <th scope="col" class="px-6 py-3">Saldo</th>
                                <th scope="col" class="px-6 py-3">Estado</th>
                                <th scope="col" class="px-6 py-3">Fecha</th>
                                <th scope="col" class="px-6 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cliente->prestamos as $prestamo)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $prestamo->numero_prestamo }}</td>
                                <td class="px-6 py-4">{{ money_symbol($prestamo->monto_prestado) }}</td>
                                <td class="px-6 py-4">{{ money_symbol($prestamo->saldo_pendiente) }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $colors = [
                                            'activo' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                            'en_mora' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                            'completado' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                            'cancelado' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                        ];
                                    @endphp
                                    <span class="text-xs font-medium px-2.5 py-0.5 rounded {{ $colors[$prestamo->estado] ?? '' }}">
                                        {{ ucfirst(str_replace('_', ' ', $prestamo->estado)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ $prestamo->fecha_desembolso->format('d/m/Y') }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('prestamos.show', $prestamo->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Ver</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @else
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <p class="text-gray-500 dark:text-gray-400 text-center">Este cliente no tiene préstamos registrados.</p>
            </div>
            @endif
        </div>

        <!-- Archivos -->
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="archivos" role="tabpanel" aria-labelledby="archivos-tab">
            <div class="space-y-4">
                <!-- Formulario para subir archivos -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Subir Archivo</h2>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('clientes.archivos.store', $cliente) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="archivo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Archivo <span class="text-red-500">*</span></label>
                                    <input type="file" id="archivo" name="archivo" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif" required
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Formatos permitidos: PDF, DOC, DOCX, JPG, JPEG, PNG, GIF. Máximo 10MB.</p>
                                </div>
                                <div>
                                    <label for="descripcion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                                    <input type="text" id="descripcion" name="descripcion" maxlength="255"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Descripción opcional del archivo">
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Subir Archivo
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Lista de archivos -->
                @if($cliente->archivos->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Archivos Subidos ({{ $cliente->archivos->count() }})</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($cliente->archivos as $archivo)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <div class="flex items-start justify-between mb-2">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm font-medium text-gray-900 dark:text-white truncate" title="{{ $archivo->nombre_original }}">
                                            {{ $archivo->nombre_original }}
                                        </h3>
                                        @if($archivo->descripcion)
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $archivo->descripcion }}</p>
                                        @endif
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $archivo->tamano_formateado }} • {{ strtoupper($archivo->extension) }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            Subido por {{ $archivo->usuario->name }} el {{ $archivo->created_at->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Vista previa -->
                                <div class="mt-3 mb-3">
                                    @if($archivo->es_imagen)
                                    <div class="relative">
                                        <img src="{{ $archivo->url }}" alt="{{ $archivo->nombre_original }}" class="w-full h-32 object-cover rounded border">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-20 transition-opacity rounded flex items-center justify-center">
                                            <a href="{{ $archivo->url }}" target="_blank" class="opacity-0 hover:opacity-100 text-white font-medium text-sm bg-blue-600 px-3 py-1 rounded">
                                                Ver completo
                                            </a>
                                        </div>
                                    </div>
                                    @elseif($archivo->es_pdf)
                                    <div class="w-full h-32 bg-gray-100 dark:bg-gray-700 rounded border flex items-center justify-center">
                                        <div class="text-center">
                                            <svg class="w-12 h-12 text-red-500 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">PDF</p>
                                        </div>
                                    </div>
                                    @else
                                    <div class="w-full h-32 bg-gray-100 dark:bg-gray-700 rounded border flex items-center justify-center">
                                        <div class="text-center">
                                            <svg class="w-12 h-12 text-blue-500 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm0 2h12v10H4V5z"/>
                                            </svg>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ strtoupper($archivo->extension) }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <!-- Acciones -->
                                <div class="flex space-x-2">
                                    <a href="{{ $archivo->url }}" target="_blank" class="flex-1 text-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Ver
                                    </a>
                                    <form action="{{ route('clientes.archivos.destroy', [$cliente, $archivo]) }}" method="POST" class="flex-1" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este archivo?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @else
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="text-center">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm0 2h12v10H4V5z"/>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No hay archivos</h3>
                        <p class="text-gray-500 dark:text-gray-400">Aún no se han subido archivos para este cliente.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Fotos del Proyecto -->
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="fotos" role="tabpanel" aria-labelledby="fotos-tab">
            <div class="space-y-4">
                @if($cliente->fotosProyecto->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Fotos del Proyecto ({{ $cliente->fotosProyecto->count() }})</h2>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($cliente->fotosProyecto()->orderBy('fecha_avance', 'desc')->get() as $foto)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                                <img src="{{ asset('storage/' . $foto->ruta_imagen) }}" alt="{{ $foto->titulo }}" class="w-full h-48 object-cover">
                                <div class="p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="font-semibold text-sm text-gray-900 dark:text-white">{{ $foto->titulo }}</h4>
                                        @if($foto->estado === 'aprobado')
                                            <span class="inline-flex rounded-full bg-green-100 dark:bg-green-900 px-2 py-0.5 text-xs font-medium text-green-800 dark:text-green-300">Aprobado</span>
                                        @elseif($foto->estado === 'rechazado')
                                            <span class="inline-flex rounded-full bg-red-100 dark:bg-red-900 px-2 py-0.5 text-xs font-medium text-red-800 dark:text-red-300">Rechazado</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-yellow-100 dark:bg-yellow-900 px-2 py-0.5 text-xs font-medium text-yellow-800 dark:text-yellow-300">Pendiente</span>
                                        @endif
                                    </div>
                                    @if($foto->descripcion)
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">{{ Str::limit($foto->descripcion, 80) }}</p>
                                    @endif
                                    <div class="text-xs text-gray-500 dark:text-gray-400 space-y-0.5">
                                        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($foto->fecha_avance)->format('d/m/Y') }}</p>
                                        @if($foto->porcentaje_avance)
                                            <p><strong>Avance:</strong> {{ number_format($foto->porcentaje_avance, 0) }}%</p>
                                        @endif
                                        @if($foto->prestamo)
                                            <p><strong>Venta:</strong> {{ $foto->prestamo->numero_prestamo }}</p>
                                        @endif
                                    </div>

                                    @if($foto->estado === 'pendiente')
                                        <div class="mt-3 flex gap-2">
                                            <form action="{{ route('foto-proyecto.aprobar', $foto->id) }}" method="POST" class="flex-1">
                                                @csrf
                                                <button type="submit" class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-2 dark:bg-green-500 dark:hover:bg-green-600">
                                                    Aprobar
                                                </button>
                                            </form>
                                            <form action="{{ route('foto-proyecto.rechazar', $foto->id) }}" method="POST" class="flex-1" onsubmit="return confirm('¿Está seguro de rechazar esta foto?')">
                                                @csrf
                                                <button type="submit" class="w-full text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-2 dark:bg-red-500 dark:hover:bg-red-600">
                                                    Rechazar
                                                </button>
                                            </form>
                                        </div>
                                    @endif

                                    @if($foto->comentario_admin)
                                        <div class="mt-2 p-2 bg-blue-50 dark:bg-blue-900 rounded text-xs">
                                            <p class="text-blue-800 dark:text-blue-200"><strong>Comentario:</strong> {{ $foto->comentario_admin }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @else
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="text-center">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No hay fotos del proyecto</h3>
                        <p class="text-gray-500 dark:text-gray-400">El cliente aún no ha subido fotos de avance de su proyecto.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal de Credenciales --}}
    @if(session('credentials'))
    <div id="credentials-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white text-center mt-4">
                    ✅ Portal Activado
                </h3>
                <div class="mt-4 px-7 py-3">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 text-center">
                        Credenciales generadas correctamente
                    </p>

                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4">
                        <div class="mb-3">
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Usuario:</label>
                            <div class="flex items-center">
                                <input type="text" id="credential-email" value="{{ session('credentials')['email'] }}"
                                    readonly class="flex-1 bg-white dark:bg-gray-600 border border-gray-300 text-gray-900 dark:text-white text-sm rounded-lg p-2">
                                <button onclick="copyToClipboard('credential-email')" class="ml-2 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Contraseña:</label>
                            <div class="flex items-center">
                                <input type="text" id="credential-password" value="{{ session('credentials')['password'] }}"
                                    readonly class="flex-1 bg-white dark:bg-gray-600 border border-gray-300 text-gray-900 dark:text-white text-sm rounded-lg p-2 font-mono">
                                <button onclick="copyToClipboard('credential-password')" class="ml-2 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <button onclick="enviarWhatsApp()" class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Enviar por WhatsApp
                        </button>
                        <button onclick="closeModal()" class="w-full text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(elementId) {
            const element = document.getElementById(elementId);
            element.select();
            document.execCommand('copy');

            // Mostrar feedback
            const button = event.target.closest('button');
            const originalHTML = button.innerHTML;
            button.innerHTML = '<svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>';
            setTimeout(() => {
                button.innerHTML = originalHTML;
            }, 1000);
        }

        function enviarWhatsApp() {
            const telefono = "{{ session('credentials')['telefono'] ?? '' }}";
            const mensaje = {!! json_encode(session('credentials')['whatsapp_message'] ?? '') !!};
            const url = `https://wa.me/${telefono}?text=${encodeURIComponent(mensaje)}`;
            window.open(url, '_blank');
        }

        function closeModal() {
            document.getElementById('credentials-modal').style.display = 'none';
        }

        // Cerrar modal con ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
    </script>
    @endif
</x-flowbite-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar pestañas manualmente
    const tabs = document.querySelectorAll('[data-tabs-target]');
    const tabContents = document.querySelectorAll('[role="tabpanel"]');

    // Función para mostrar una pestaña
    function showTab(targetId) {
        // Ocultar todos los contenidos
        tabContents.forEach(content => {
            content.classList.add('hidden');
        });

        // Resetear todas las pestañas a estado inactivo
        tabs.forEach(tab => {
            tab.classList.remove('border-blue-600', 'text-white', 'bg-blue-600', 'dark:text-white', 'dark:border-blue-500', 'dark:bg-blue-500');
            tab.classList.add('text-white', 'bg-gray-600', 'hover:bg-gray-700', 'dark:text-white', 'dark:bg-gray-700', 'dark:hover:bg-gray-600');
        });

        // Mostrar el contenido seleccionado
        const targetContent = document.querySelector(targetId);
        if (targetContent) {
            targetContent.classList.remove('hidden');
        }

        // Activar el botón seleccionado
        const activeTab = document.querySelector(`[data-tabs-target="${targetId}"]`);
        if (activeTab) {
            activeTab.classList.remove('text-white', 'bg-gray-600', 'hover:bg-gray-700', 'dark:text-white', 'dark:bg-gray-700', 'dark:hover:bg-gray-600');
            activeTab.classList.add('border-blue-600', 'text-white', 'bg-blue-600', 'hover:text-white', 'hover:border-blue-600', 'dark:text-white', 'dark:border-blue-500', 'dark:bg-blue-500');
        }
    }

    // Agregar event listeners a los botones
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const target = this.getAttribute('data-tabs-target');
            showTab(target);
        });
    });

    // Mostrar la primera pestaña por defecto
    showTab('#informacion');
});
</script>
