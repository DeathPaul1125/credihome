<x-tailadmin-layout>
    @section('page-title', 'Editar Cliente')

    <div class="mb-6">
        <h2 class="text-title-md2 font-semibold text-gray-900 dark:text-white">
            Editar Cliente
        </h2>
        <p class="text-gray-500 dark:text-gray-400">Actualice la información del cliente</p>
    </div>

    <form action="{{ route('clientes.update', $cliente) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Información Personal -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/5">
                <h3 class="mb-6 text-lg font-semibold text-gray-900 dark:text-white">Información Personal</h3>

                <div class="space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Nombre Completo *</label>
                        <input type="text" name="nombre_completo" value="{{ old('nombre_completo', $cliente->nombre_completo) }}" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('nombre_completo') border-red-500 @enderror">
                        @error('nombre_completo')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">DPI * (13 dígitos)</label>
                            <input type="text" name="dpi" value="{{ old('dpi', $cliente->dpi) }}" maxlength="13" required placeholder="2547854120101" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('dpi') border-red-500 @enderror">
                            @error('dpi')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Fecha de Nacimiento *</label>
                            <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $cliente->fecha_nacimiento) }}" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('fecha_nacimiento') border-red-500 @enderror">
                            @error('fecha_nacimiento')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Género *</label>
                            <select name="genero" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('genero') border-red-500 @enderror">
                                <option value="">Seleccionar...</option>
                                <option value="masculino" {{ old('genero', $cliente->genero) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="femenino" {{ old('genero', $cliente->genero) == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                <option value="otro" {{ old('genero', $cliente->genero) == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('genero')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Estado Civil *</label>
                            <select name="estado_civil" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('estado_civil') border-red-500 @enderror">
                                <option value="">Seleccionar...</option>
                                <option value="soltero" {{ old('estado_civil', $cliente->estado_civil) == 'soltero' ? 'selected' : '' }}>Soltero/a</option>
                                <option value="casado" {{ old('estado_civil', $cliente->estado_civil) == 'casado' ? 'selected' : '' }}>Casado/a</option>
                                <option value="divorciado" {{ old('estado_civil', $cliente->estado_civil) == 'divorciado' ? 'selected' : '' }}>Divorciado/a</option>
                                <option value="viudo" {{ old('estado_civil', $cliente->estado_civil) == 'viudo' ? 'selected' : '' }}>Viudo/a</option>
                                <option value="union_libre" {{ old('estado_civil', $cliente->estado_civil) == 'union_libre' ? 'selected' : '' }}>Unión Libre</option>
                            </select>
                            @error('estado_civil')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Estado del Cliente *</label>
                        <select name="estado" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('estado') border-red-500 @enderror">
                            <option value="activo" {{ old('estado', $cliente->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ old('estado', $cliente->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            <option value="bloqueado" {{ old('estado', $cliente->estado) == 'bloqueado' ? 'selected' : '' }}>Bloqueado</option>
                        </select>
                        @error('estado')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Información de Contacto -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/5">
                <h3 class="mb-6 text-lg font-semibold text-gray-900 dark:text-white">Información de Contacto</h3>

                <div class="space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Teléfono * (8 dígitos)</label>
                        <input type="text" name="telefono" value="{{ old('telefono', $cliente->telefono) }}" maxlength="8" required placeholder="12345678" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('telefono') border-red-500 @enderror">
                        @error('telefono')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" name="email" value="{{ old('email', $cliente->email) }}" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('email') border-red-500 @enderror">
                        @error('email')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Departamento *</label>
                            <select name="departamento" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('departamento') border-red-500 @enderror">
                                <option value="">Seleccionar...</option>
                                @foreach(['Guatemala', 'Alta Verapaz', 'Baja Verapaz', 'Chimaltenango', 'Chiquimula', 'El Progreso', 'Escuintla', 'Huehuetenango', 'Izabal', 'Jalapa', 'Jutiapa', 'Petén', 'Quetzaltenango', 'Quiché', 'Retalhuleu', 'Sacatepéquez', 'San Marcos', 'Santa Rosa', 'Sololá', 'Suchitepéquez', 'Totonicapán', 'Zacapa'] as $depto)
                                    <option value="{{ $depto }}" {{ old('departamento', $cliente->departamento) == $depto ? 'selected' : '' }}>{{ $depto }}</option>
                                @endforeach
                            </select>
                            @error('departamento')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Municipio *</label>
                            <input type="text" name="municipio" value="{{ old('municipio', $cliente->municipio) }}" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('municipio') border-red-500 @enderror">
                            @error('municipio')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Dirección Completa *</label>
                        <textarea name="direccion" rows="3" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('direccion') border-red-500 @enderror">{{ old('direccion', $cliente->direccion) }}</textarea>
                        @error('direccion')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Información Laboral -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/5">
                <h3 class="mb-6 text-lg font-semibold text-gray-900 dark:text-white">Información Laboral</h3>

                <div class="space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Profesión u Oficio *</label>
                        <input type="text" name="profesion" value="{{ old('profesion', $cliente->profesion) }}" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('profesion') border-red-500 @enderror">
                        @error('profesion')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Ingreso Mensual (Q) *</label>
                        <input type="number" name="ingreso_mensual" value="{{ old('ingreso_mensual', $cliente->ingreso_mensual) }}" step="0.01" min="0" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('ingreso_mensual') border-red-500 @enderror">
                        @error('ingreso_mensual')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Referencias Personales -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/5">
                <h3 class="mb-6 text-lg font-semibold text-gray-900 dark:text-white">Referencias Personales</h3>

                @php
                    $referencias = json_decode($cliente->referencias, true);
                @endphp

                <!-- Referencia 1 -->
                <div class="mb-6 space-y-4 rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                    <h4 class="font-medium text-gray-900 dark:text-white">Referencia 1</h4>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Nombre Completo *</label>
                        <input type="text" name="referencias[0][nombre]" value="{{ old('referencias.0.nombre', $referencias[0]['nombre'] ?? '') }}" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Parentesco *</label>
                            <select name="referencias[0][parentesco]" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">Seleccionar...</option>
                                @foreach(['familiar', 'amigo', 'vecino', 'compañero', 'otro'] as $tipo)
                                    <option value="{{ $tipo }}" {{ old('referencias.0.parentesco', $referencias[0]['parentesco'] ?? '') == $tipo ? 'selected' : '' }}>{{ ucfirst($tipo) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Teléfono *</label>
                            <input type="text" name="referencias[0][telefono]" value="{{ old('referencias.0.telefono', $referencias[0]['telefono'] ?? '') }}" maxlength="8" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>

                <!-- Referencia 2 -->
                <div class="space-y-4 rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                    <h4 class="font-medium text-gray-900 dark:text-white">Referencia 2</h4>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Nombre Completo *</label>
                        <input type="text" name="referencias[1][nombre]" value="{{ old('referencias.1.nombre', $referencias[1]['nombre'] ?? '') }}" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Parentesco *</label>
                            <select name="referencias[1][parentesco]" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">Seleccionar...</option>
                                @foreach(['familiar', 'amigo', 'vecino', 'compañero', 'otro'] as $tipo)
                                    <option value="{{ $tipo }}" {{ old('referencias.1.parentesco', $referencias[1]['parentesco'] ?? '') == $tipo ? 'selected' : '' }}>{{ ucfirst($tipo) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Teléfono *</label>
                            <input type="text" name="referencias[1][telefono]" value="{{ old('referencias.1.telefono', $referencias[1]['telefono'] ?? '') }}" maxlength="8" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 flex gap-4">
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-600 px-6 py-3 text-center text-base font-semibold text-white hover:bg-brand-700 focus:outline-none focus:ring-4 focus:ring-brand-300 dark:bg-brand-600 dark:hover:bg-brand-700 dark:focus:ring-brand-800">
                Actualizar Cliente
            </button>
            <a href="{{ route('clientes.show', $cliente) }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-3 text-center text-base font-medium text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                Cancelar
            </a>
        </div>
    </form>
</x-tailadmin-layout>
