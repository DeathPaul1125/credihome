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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
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
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado</dt>
                        <dd class="mt-1">
                            @if($cliente->estado == 'activo')
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Activo</span>
                            @else
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Inactivo</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Resumen -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Resumen</h2>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Préstamos</dt>
                    <dd class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">{{ $cliente->prestamos->count() }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Préstamos Activos</dt>
                    <dd class="mt-1 text-2xl font-bold text-green-600 dark:text-green-400">{{ $cliente->prestamos->whereIn('estado', ['activo', 'en_mora'])->count() }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Deuda Total</dt>
                    <dd class="mt-1 text-2xl font-bold text-blue-600 dark:text-blue-400">Q{{ number_format($cliente->prestamos->whereIn('estado', ['activo', 'en_mora'])->sum('saldo_pendiente'), 2) }}</dd>
                </div>
            </div>
        </div>
    </div>

    <!-- Contacto -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-4">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Información de Contacto</h2>
        </div>
        <div class="p-6">
            <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cliente->telefono }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono Alternativo</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cliente->telefono_alternativo ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cliente->email ?? 'N/A' }}</dd>
                </div>
                <div class="md:col-span-3">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dirección</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cliente->direccion_completa }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Departamento</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cliente->departamento }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Municipio</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cliente->municipio }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Zona</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cliente->zona ?? 'N/A' }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Información Laboral -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-4">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Información Laboral</h2>
        </div>
        <div class="p-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Profesión</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cliente->profesion ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Lugar de Trabajo</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cliente->lugar_trabajo ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Puesto</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cliente->puesto_trabajo ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Ingreso Mensual</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $cliente->ingreso_mensual ? 'Q' . number_format($cliente->ingreso_mensual, 2) : 'N/A' }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Referencias -->
    @if($cliente->referencia_nombre_1 || $cliente->referencia_nombre_2)
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-4">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Referencias</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($cliente->referencia_nombre_1)
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Referencia 1</h3>
                    <dl class="space-y-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $cliente->referencia_nombre_1 }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $cliente->referencia_telefono_1 ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Parentesco</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $cliente->referencia_parentesco_1 ?? 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>
                @endif
                @if($cliente->referencia_nombre_2)
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Referencia 2</h3>
                    <dl class="space-y-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $cliente->referencia_nombre_2 }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $cliente->referencia_telefono_2 ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Parentesco</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $cliente->referencia_parentesco_2 ?? 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Préstamos -->
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
                        <td class="px-6 py-4">Q{{ number_format($prestamo->monto_prestado, 2) }}</td>
                        <td class="px-6 py-4">Q{{ number_format($prestamo->saldo_pendiente, 2) }}</td>
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
    @endif

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
</x-flowbite-layout>
