<x-flowbite-layout>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Nuevo Cliente</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Registrar un nuevo cliente en el sistema</p>
            </div>
            <a href="{{ route('clientes.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                Volver
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6">
            <form action="{{ route('clientes.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- DPI -->
                    <div>
                        <label for="dpi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DPI (13 dígitos) <span class="text-red-500">*</span></label>
                        <div class="flex gap-2">
                            <input type="text" id="dpi" name="dpi" value="{{ old('dpi') }}" required maxlength="13" pattern="[0-9]{13}" class="flex-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('dpi') border-red-500 @enderror" placeholder="1234567890123">
                            <button type="button" id="search-pdi" class="px-4 py-2.5 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">
                                Buscar PDI
                            </button>
                        </div>
                        @error('dpi')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nombre -->
                    <div>
                        <label for="nombre_completo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre Completo <span class="text-red-500">*</span></label>
                        <input type="text" id="nombre_completo" name="nombre_completo" value="{{ old('nombre_completo') }}" required readonly class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('nombre_completo') border-red-500 @enderror">
                        @error('nombre_completo')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label for="telefono" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono <span class="text-red-500">*</span></label>
                        <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('telefono') border-red-500 @enderror" placeholder="+502 1234-5678">
                        @error('telefono')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('email') border-red-500 @enderror" placeholder="correo@ejemplo.com">
                        @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <!-- Dirección -->
                    <label for="direccion_completa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dirección Completa <span class="text-red-500">*</span></label>
                    <textarea id="direccion_completa" name="direccion_completa" rows="3" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('direccion_completa') border-red-500 @enderror">{{ old('direccion_completa') }}</textarea>
                    @error('direccion_completa')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Departamento -->
                    <div>
                        <label for="departamento" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Departamento <span class="text-red-500">*</span></label>
                        <select id="departamento" name="departamento" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('departamento') border-red-500 @enderror">
                            <option value="">Seleccionar...</option>
                            <option value="Guatemala" {{ old('departamento') == 'Guatemala' ? 'selected' : '' }}>Guatemala</option>
                            <option value="Alta Verapaz" {{ old('departamento') == 'Alta Verapaz' ? 'selected' : '' }}>Alta Verapaz</option>
                            <option value="Baja Verapaz" {{ old('departamento') == 'Baja Verapaz' ? 'selected' : '' }}>Baja Verapaz</option>
                            <option value="Chimaltenango" {{ old('departamento') == 'Chimaltenango' ? 'selected' : '' }}>Chimaltenango</option>
                            <option value="Chiquimula" {{ old('departamento') == 'Chiquimula' ? 'selected' : '' }}>Chiquimula</option>
                            <option value="El Progreso" {{ old('departamento') == 'El Progreso' ? 'selected' : '' }}>El Progreso</option>
                            <option value="Escuintla" {{ old('departamento') == 'Escuintla' ? 'selected' : '' }}>Escuintla</option>
                            <option value="Huehuetenango" {{ old('departamento') == 'Huehuetenango' ? 'selected' : '' }}>Huehuetenango</option>
                            <option value="Izabal" {{ old('departamento') == 'Izabal' ? 'selected' : '' }}>Izabal</option>
                            <option value="Jalapa" {{ old('departamento') == 'Jalapa' ? 'selected' : '' }}>Jalapa</option>
                            <option value="Jutiapa" {{ old('departamento') == 'Jutiapa' ? 'selected' : '' }}>Jutiapa</option>
                            <option value="Petén" {{ old('departamento') == 'Petén' ? 'selected' : '' }}>Petén</option>
                            <option value="Quetzaltenango" {{ old('departamento') == 'Quetzaltenango' ? 'selected' : '' }}>Quetzaltenango</option>
                            <option value="Quiché" {{ old('departamento') == 'Quiché' ? 'selected' : '' }}>Quiché</option>
                            <option value="Retalhuleu" {{ old('departamento') == 'Retalhuleu' ? 'selected' : '' }}>Retalhuleu</option>
                            <option value="Sacatepéquez" {{ old('departamento') == 'Sacatepéquez' ? 'selected' : '' }}>Sacatepéquez</option>
                            <option value="San Marcos" {{ old('departamento') == 'San Marcos' ? 'selected' : '' }}>San Marcos</option>
                            <option value="Santa Rosa" {{ old('departamento') == 'Santa Rosa' ? 'selected' : '' }}>Santa Rosa</option>
                            <option value="Sololá" {{ old('departamento') == 'Sololá' ? 'selected' : '' }}>Sololá</option>
                            <option value="Suchitepéquez" {{ old('departamento') == 'Suchitepéquez' ? 'selected' : '' }}>Suchitepéquez</option>
                            <option value="Totonicapán" {{ old('departamento') == 'Totonicapán' ? 'selected' : '' }}>Totonicapán</option>
                            <option value="Zacapa" {{ old('departamento') == 'Zacapa' ? 'selected' : '' }}>Zacapa</option>
                        </select>
                        @error('departamento')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Municipio -->
                    <div>
                        <label for="municipio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Municipio <span class="text-red-500">*</span></label>
                        <input type="text" id="municipio" name="municipio" value="{{ old('municipio') }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('municipio') border-red-500 @enderror">
                        @error('municipio')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha de Nacimiento -->
                    <div>
                        <label for="fecha_nacimiento" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de Nacimiento <span class="text-red-500">*</span></label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('fecha_nacimiento') border-red-500 @enderror">
                        @error('fecha_nacimiento')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Género -->
                    <div>
                        <label for="genero" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Género <span class="text-red-500">*</span></label>
                        <select id="genero" name="genero" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('genero') border-red-500 @enderror">
                            <option value="">Seleccionar...</option>
                            <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="femenino" {{ old('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                            <option value="otro" {{ old('genero') == 'otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('genero')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Estado Civil -->
                    <div>
                        <label for="estado_civil" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado Civil <span class="text-red-500">*</span></label>
                        <select id="estado_civil" name="estado_civil" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('estado_civil') border-red-500 @enderror">
                            <option value="">Seleccionar...</option>
                            <option value="soltero" {{ old('estado_civil') == 'soltero' ? 'selected' : '' }}>Soltero</option>
                            <option value="casado" {{ old('estado_civil') == 'casado' ? 'selected' : '' }}>Casado</option>
                            <option value="union_libre" {{ old('estado_civil') == 'union_libre' ? 'selected' : '' }}>Unión Libre</option>
                            <option value="divorciado" {{ old('estado_civil') == 'divorciado' ? 'selected' : '' }}>Divorciado</option>
                            <option value="viudo" {{ old('estado_civil') == 'viudo' ? 'selected' : '' }}>Viudo</option>
                        </select>
                        @error('estado_civil')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <!-- Notas -->
                    <label for="notas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notas Adicionales</label>
                    <textarea id="notas" name="notas" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('notas') border-red-500 @enderror">{{ old('notas') }}</textarea>
                    @error('notas')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center space-x-4">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Guardar Cliente
                    </button>
                    <a href="{{ route('clientes.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-flowbite-layout>

<script>
document.getElementById('search-pdi').addEventListener('click', function() {
    const dpi = document.getElementById('dpi').value;
    if (!dpi || dpi.length !== 13) {
        alert('Por favor ingrese un DPI válido de 13 dígitos.');
        return;
    }

    // Mostrar loading
    this.disabled = true;
    this.textContent = 'Buscando...';

    fetch('{{ route("clientes.search-pdi") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ dpi: dpi })
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert('Error: ' + data.error);
        } else {
            // Llenar los campos
            if (data.nombre_completo) {
                document.getElementById('nombre_completo').value = data.nombre_completo;
            }
            // Nota: La API FEL no devuelve fecha de nacimiento ni género
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al buscar PDI. Intente nuevamente.');
    })
    .finally(() => {
        // Restaurar botón
        this.disabled = false;
        this.textContent = 'Buscar PDI';
    });
});
</script>
