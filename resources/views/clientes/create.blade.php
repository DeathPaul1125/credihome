<x-tailadmin-layout>
    @section('page-title', 'Nuevo Cliente')

    <div class="mb-6">
        <h2 class="text-title-md2 font-semibold text-gray-900 dark:text-white">
            Registrar Nuevo Cliente
        </h2>
        <p class="text-gray-500 dark:text-gray-400">Complete la información del cliente</p>
    </div>

    <form action="{{ route('clientes.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Información Personal -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/5">
                <h3 class="mb-6 text-lg font-semibold text-gray-900 dark:text-white">Información Personal</h3>

                <div class="space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Nombre Completo *</label>
                        <input type="text" name="nombre_completo" value="{{ old('nombre_completo') }}" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('nombre_completo') border-red-500 @enderror">
                        @error('nombre_completo')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">DPI * (13 dígitos)</label>
                            <div class="flex gap-2">
                                <input type="text" id="dpi" name="dpi" value="{{ old('dpi') }}" maxlength="13" required placeholder="2547854120101" class="flex-1 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('dpi') border-red-500 @enderror">
                                <button type="button" id="search-pdi" class="px-4 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300 transition-colors font-medium">
                                    🔍 Buscar PDI
                                </button>
                            </div>
                            @error('dpi')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Fecha de Nacimiento *</label>
                            <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('fecha_nacimiento') border-red-500 @enderror">
                            @error('fecha_nacimiento')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Género *</label>
                            <select name="genero" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('genero') border-red-500 @enderror">
                                <option value="">Seleccionar...</option>
                                <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="femenino" {{ old('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                <option value="otro" {{ old('genero') == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('genero')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Estado Civil *</label>
                            <select name="estado_civil" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('estado_civil') border-red-500 @enderror">
                                <option value="">Seleccionar...</option>
                                <option value="soltero" {{ old('estado_civil') == 'soltero' ? 'selected' : '' }}>Soltero/a</option>
                                <option value="casado" {{ old('estado_civil') == 'casado' ? 'selected' : '' }}>Casado/a</option>
                                <option value="union_libre" {{ old('estado_civil') == 'union_libre' ? 'selected' : '' }}>Unión Libre</option>
                                <option value="divorciado" {{ old('estado_civil') == 'divorciado' ? 'selected' : '' }}>Divorciado/a</option>
                                <option value="viudo" {{ old('estado_civil') == 'viudo' ? 'selected' : '' }}>Viudo/a</option>
                            </select>
                            @error('estado_civil')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contacto -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/5">
                <h3 class="mb-6 text-lg font-semibold text-gray-900 dark:text-white">Información de Contacto</h3>

                <div class="space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Teléfono Principal *</label>
                        <input type="tel" name="telefono" value="{{ old('telefono') }}" required placeholder="+502 5547-8965" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('telefono') border-red-500 @enderror">
                        @error('telefono')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Teléfono Alternativo</label>
                        <input type="tel" name="telefono_alternativo" value="{{ old('telefono_alternativo') }}" placeholder="+502 4456-7890" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="cliente@ejemplo.com" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Departamento *</label>
                            <input type="text" name="departamento" value="{{ old('departamento') }}" required placeholder="Guatemala" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('departamento') border-red-500 @enderror">
                            @error('departamento')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Municipio *</label>
                            <input type="text" name="municipio" value="{{ old('municipio') }}" required placeholder="Guatemala" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('municipio') border-red-500 @enderror">
                            @error('municipio')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Dirección Completa *</label>
                        <textarea name="direccion_completa" required rows="3" placeholder="Calle, avenida, número de casa..." class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('direccion_completa') border-red-500 @enderror">{{ old('direccion_completa') }}</textarea>
                        @error('direccion_completa')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Zona</label>
                        <input type="text" name="zona" value="{{ old('zona') }}" placeholder="Zona 1" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>
            </div>

            <!-- Información Laboral -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/5">
                <h3 class="mb-6 text-lg font-semibold text-gray-900 dark:text-white">Información Laboral</h3>

                <div class="space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Profesión u Oficio</label>
                        <input type="text" name="profesion" value="{{ old('profesion') }}" placeholder="Comerciante, albañil, etc." class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Lugar de Trabajo</label>
                        <input type="text" name="lugar_trabajo" value="{{ old('lugar_trabajo') }}" placeholder="Nombre de la empresa o negocio" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Puesto</label>
                        <input type="text" name="puesto_trabajo" value="{{ old('puesto_trabajo') }}" placeholder="Cargo o puesto" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Ingreso Mensual (Q)</label>
                        <input type="number" name="ingreso_mensual" value="{{ old('ingreso_mensual') }}" step="0.01" min="0" placeholder="0.00" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>
            </div>

            <!-- Referencias -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/5">
                <h3 class="mb-6 text-lg font-semibold text-gray-900 dark:text-white">Referencias Personales</h3>

                <div class="space-y-6">
                    <!-- Referencia 1 -->
                    <div class="space-y-4">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Referencia 1</h4>
                        <input type="text" name="referencia_nombre_1" value="{{ old('referencia_nombre_1') }}" placeholder="Nombre completo" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <div class="grid grid-cols-2 gap-4">
                            <input type="tel" name="referencia_telefono_1" value="{{ old('referencia_telefono_1') }}" placeholder="Teléfono" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <input type="text" name="referencia_parentesco_1" value="{{ old('referencia_parentesco_1') }}" placeholder="Parentesco" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>

                    <!-- Referencia 2 -->
                    <div class="space-y-4">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Referencia 2</h4>
                        <input type="text" name="referencia_nombre_2" value="{{ old('referencia_nombre_2') }}" placeholder="Nombre completo" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <div class="grid grid-cols-2 gap-4">
                            <input type="tel" name="referencia_telefono_2" value="{{ old('referencia_telefono_2') }}" placeholder="Teléfono" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <input type="text" name="referencia_parentesco_2" value="{{ old('referencia_parentesco_2') }}" placeholder="Parentesco" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notas -->
        <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/5">
            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Notas Adicionales</label>
            <textarea name="notas" rows="4" placeholder="Información adicional relevante..." class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('notas') }}</textarea>
        </div>

        <!-- Botones -->
        <div class="mt-6 flex gap-4">
            <button type="submit" class="flex-1 rounded-lg bg-brand-500 px-6 py-3 font-medium text-white hover:bg-brand-600 transition-colors">
                Guardar Cliente
            </button>
            <a href="{{ route('clientes.index') }}" class="flex-1 rounded-lg border border-gray-300 px-6 py-3 text-center font-medium text-gray-700 hover:bg-gray-50 transition-colors dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-800">
                Cancelar
            </a>
        </div>
    </form>
</x-tailadmin-layout>

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
                document.querySelector('input[name="nombre_completo"]').value = data.nombre_completo;
            }
            if (data.fecha_nacimiento) {
                document.querySelector('input[name="fecha_nacimiento"]').value = data.fecha_nacimiento;
            }
            if (data.genero) {
                const generoSelect = document.querySelector('select[name="genero"]');
                const generoValue = data.genero.toLowerCase() === 'masculino' ? 'masculino' :
                                   data.genero.toLowerCase() === 'femenino' ? 'femenino' : 'otro';
                generoSelect.value = generoValue;
            }
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
