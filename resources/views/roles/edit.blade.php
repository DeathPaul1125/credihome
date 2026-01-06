<x-flowbite-layout>
    <div class="mb-4">
        <div class="flex items-center space-x-2">
            <a href="{{ route('roles.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Editar Rol: {{ $role->name }}</h1>
                <p class="text-gray-600 dark:text-gray-400">Modifica el nombre y permisos del rol</p>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <form method="POST" action="{{ route('roles.update', $role) }}">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del Rol</label>
                <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @error('name')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block mb-4 text-sm font-medium text-gray-900 dark:text-white">Permisos</label>
                
                @foreach($permissions as $module => $modulePermissions)
                <div class="mb-4 p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-md font-semibold text-gray-800 dark:text-gray-200 capitalize">{{ $module }}</h3>
                        <button type="button" onclick="toggleModule('{{ $module }}')" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">
                            Seleccionar todos
                        </button>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($modulePermissions as $permission)
                        <div class="flex items-center">
                            <input 
                                id="permission-{{ $permission->id }}" 
                                type="checkbox" 
                                name="permissions[]" 
                                value="{{ $permission->name }}" 
                                {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}
                                class="module-{{ $module }} w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            >
                            <label for="permission-{{ $permission->id }}" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                {{ ucfirst(str_replace('-', ' ', explode('-', $permission->name)[0])) }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <div class="flex space-x-2">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Actualizar Rol
                </button>
                <a href="{{ route('roles.index') }}" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        function toggleModule(module) {
            const checkboxes = document.querySelectorAll('.module-' + module);
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = !allChecked;
            });
        }
    </script>
    @endpush
</x-flowbite-layout>
