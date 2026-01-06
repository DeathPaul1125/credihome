<x-flowbite-layout>
    <div class="p-4 sm:ml-64">
        <div class="p-4 mt-14">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $usuario->name }}</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $usuario->email }}</p>
                </div>
                <div class="flex gap-3">
                    @can('editar-usuarios')
                    <a href="{{ route('usuarios.edit', $usuario) }}" class="text-white bg-blue-700 hover:bg-blue-800 rounded-lg text-sm px-5 py-2.5">Editar</a>
                    @endcan
                    <a href="{{ route('usuarios.index') }}" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg text-sm px-5 py-2.5">Volver</a>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
                <div class="flex items-center gap-6">
                    <img src="{{ $usuario->profile_photo_url }}" alt="{{ $usuario->name }}" class="w-24 h-24 rounded-full">
                    <div class="flex-1">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre</dt>
                                <dd class="text-lg text-gray-900 dark:text-white mt-1">{{ $usuario->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                <dd class="text-lg text-gray-900 dark:text-white mt-1">{{ $usuario->email }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Rol</dt>
                                <dd class="mt-1">
                                    @foreach($usuario->roles as $role)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        @if($role->name === 'Super Admin') bg-red-100 text-red-800
                                        @elseif($role->name === 'Administrador') bg-purple-100 text-purple-800
                                        @elseif($role->name === 'Gerente') bg-blue-100 text-blue-800
                                        @elseif($role->name === 'Asesor') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $role->name }}
                                    </span>
                                    @endforeach
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Registro</dt>
                                <dd class="text-lg text-gray-900 dark:text-white mt-1">{{ $usuario->created_at->format('d/m/Y') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            @if($usuario->roles->first())
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Permisos del Rol: {{ $usuario->roles->first()->name }}</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                    @foreach($usuario->roles->first()->permissions as $permission)
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $permission->name }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</x-flowbite-layout>
