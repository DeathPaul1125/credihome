<x-flowbite-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            <i class="fas fa-hard-hat mr-2"></i>Nuevo Contratista
        </h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Registrar un nuevo contratista de construcción</p>
    </div>

    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg p-6">
        <form action="{{ route('contratistas.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Nombre Completo -->
                <div>
                    <label for="nombre_completo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre Completo *</label>
                    <input type="text" id="nombre_completo" name="nombre_completo" value="{{ old('nombre_completo') }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('nombre_completo') border-red-500 @enderror">
                    @error('nombre_completo')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nombre Empresa -->
                <div>
                    <label for="nombre_empresa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre de Empresa</label>
                    <input type="text" id="nombre_empresa" name="nombre_empresa" value="{{ old('nombre_empresa') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                </div>

                <!-- DPI -->
                <div>
                    <label for="dpi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DPI</label>
                    <input type="text" id="dpi" name="dpi" value="{{ old('dpi') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                </div>

                <!-- NIT -->
                <div>
                    <label for="nit" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIT</label>
                    <input type="text" id="nit" name="nit" value="{{ old('nit') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                </div>

                <!-- Teléfono 1 -->
                <div>
                    <label for="telefono1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono 1 *</label>
                    <input type="text" id="telefono1" name="telefono1" value="{{ old('telefono1') }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('telefono1') border-red-500 @enderror">
                    @error('telefono1')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Teléfono 2 -->
                <div>
                    <label for="telefono2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono 2</label>
                    <input type="text" id="telefono2" name="telefono2" value="{{ old('telefono2') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                </div>

                <!-- Especialidad -->
                <div>
                    <label for="especialidad" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Especialidad</label>
                    <input type="text" id="especialidad" name="especialidad" value="{{ old('especialidad') }}" placeholder="Ej: Construcción de viviendas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                </div>

                <!-- Tipo de Servicio -->
                <div>
                    <label for="tipo_servicio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de Servicio *</label>
                    <select id="tipo_servicio" name="tipo_servicio" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="ambos" {{ old('tipo_servicio') == 'ambos' ? 'selected' : '' }}>Ambos</option>
                        <option value="construccion" {{ old('tipo_servicio') == 'construccion' ? 'selected' : '' }}>Construcción</option>
                        <option value="remodelacion" {{ old('tipo_servicio') == 'remodelacion' ? 'selected' : '' }}>Remodelación</option>
                    </select>
                </div>

                <!-- Años de Experiencia -->
                <div>
                    <label for="anos_experiencia" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Años de Experiencia</label>
                    <input type="number" id="anos_experiencia" name="anos_experiencia" value="{{ old('anos_experiencia') }}" min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                </div>

                <!-- Calificación -->
                <div>
                    <label for="calificacion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Calificación (0-5)</label>
                    <input type="number" id="calificacion" name="calificacion" value="{{ old('calificacion', 0) }}" min="0" max="5" step="0.1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                </div>

                <!-- Municipio -->
                <div>
                    <label for="municipio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Municipio</label>
                    <input type="text" id="municipio" name="municipio" value="{{ old('municipio') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                </div>

                <!-- Departamento -->
                <div>
                    <label for="departamento" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Departamento</label>
                    <input type="text" id="departamento" name="departamento" value="{{ old('departamento') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                </div>

                <!-- Estado -->
                <div>
                    <label for="estado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado *</label>
                    <select id="estado" name="estado" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="activo" {{ old('estado', 'activo') == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        <option value="suspendido" {{ old('estado') == 'suspendido' ? 'selected' : '' }}>Suspendido</option>
                    </select>
                </div>
            </div>

            <!-- Dirección -->
            <div class="mb-6">
                <label for="direccion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dirección</label>
                <textarea id="direccion" name="direccion" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">{{ old('direccion') }}</textarea>
            </div>

            <!-- Servicios Ofrecidos -->
            <div class="mb-6">
                <label for="servicios_ofrecidos" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Servicios Ofrecidos</label>
                <textarea id="servicios_ofrecidos" name="servicios_ofrecidos" rows="3" placeholder="Describe los servicios que ofrece el contratista..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">{{ old('servicios_ofrecidos') }}</textarea>
            </div>

            <!-- Notas -->
            <div class="mb-6">
                <label for="notas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notas</label>
                <textarea id="notas" name="notas" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">{{ old('notas') }}</textarea>
            </div>

            <div class="flex items-center space-x-4">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <i class="fas fa-save mr-2"></i>Guardar Contratista
                </button>
                <a href="{{ route('contratistas.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-flowbite-layout>
