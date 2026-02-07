<x-flowbite-layout>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Nuevo Inversionista</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Registra un nuevo inversionista o financiador</p>
    </div>

            <form action="{{ route('aportadores.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Información Básica -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Información Básica</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="tipo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de Inversionista <span class="text-red-500">*</span></label>
                            <select id="tipo" name="tipo" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">Seleccione...</option>
                                <option value="Persona" {{ old('tipo') == 'Persona' ? 'selected' : '' }}>Persona</option>
                                <option value="Empresa" {{ old('tipo') == 'Empresa' ? 'selected' : '' }}>Empresa</option>
                                <option value="Institución" {{ old('tipo') == 'Institución' ? 'selected' : '' }}>Institución</option>
                            </select>
                            @error('tipo')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre Completo <span class="text-red-500">*</span></label>
                            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Juan Pérez">
                            @error('nombre')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="dpi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DPI</label>
                            <input type="text" id="dpi" name="dpi" value="{{ old('dpi') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="1234567890101">
                            @error('dpi')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="email@ejemplo.com">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="telefono" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono</label>
                            <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="12345678">
                            @error('telefono')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="direccion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dirección</label>
                            <input type="text" id="direccion" name="direccion" value="{{ old('direccion') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Zona 1, Guatemala">
                            @error('direccion')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Campos para Empresa -->
                    <div id="empresaFields" class="hidden mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="empresa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre de Empresa</label>
                            <input type="text" id="empresa" name="empresa" value="{{ old('empresa') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                        </div>

                        <div>
                            <label for="nit" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIT</label>
                            <input type="text" id="nit" name="nit" value="{{ old('nit') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                        </div>
                    </div>
                </div>

                <!-- Capital Inicial -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Capital Inicial</h2>

                    <div class="max-w-md">
                        <label for="capital_disponible" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Monto Inicial (Q) <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" id="capital_disponible" name="capital_disponible" value="{{ old('capital_disponible', '0.00') }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="0.00">
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Capital disponible para otorgar créditos</p>
                        @error('capital_disponible')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Preferencias de Inversión -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Preferencias de Inversión</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="tasa_interes_minima" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tasa de Interés Mínima (%)</label>
                            <input type="number" step="0.01" id="tasa_interes_minima" name="tasa_interes_minima" value="{{ old('tasa_interes_minima') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="0.00">
                        </div>

                        <div>
                            <label for="plazo_maximo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Plazo Máximo (meses)</label>
                            <input type="number" id="plazo_maximo" name="plazo_maximo" value="{{ old('plazo_maximo') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="12">
                        </div>

                        <div>
                            <label for="monto_minimo_prestamo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Monto Mínimo por Préstamo (Q)</label>
                            <input type="number" step="0.01" id="monto_minimo_prestamo" name="monto_minimo_prestamo" value="{{ old('monto_minimo_prestamo') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="0.00">
                        </div>

                        <div>
                            <label for="monto_maximo_prestamo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Monto Máximo por Préstamo (Q)</label>
                            <input type="number" step="0.01" id="monto_maximo_prestamo" name="monto_maximo_prestamo" value="{{ old('monto_maximo_prestamo') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="0.00">
                        </div>
                    </div>
                </div>

                <!-- Estado y Notas -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Información Adicional</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="estado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado <span class="text-red-500">*</span></label>
                            <select id="estado" name="estado" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="Activo" {{ old('estado', 'Activo') == 'Activo' ? 'selected' : '' }}>Activo</option>
                                <option value="Inactivo" {{ old('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                <option value="Suspendido" {{ old('estado') == 'Suspendido' ? 'selected' : '' }}>Suspendido</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label for="notas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notas</label>
                            <textarea id="notas" name="notas" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Información adicional...">{{ old('notas') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex items-center gap-4">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        Guardar Inversionista
                    </button>
                    <a href="{{ route('aportadores.index') }}" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                        Cancelar
                    </a>
        </div>
    </form>

    @push('scripts')
    <script>
        // Mostrar campos de empresa según el tipo seleccionado
        document.getElementById('tipo').addEventListener('change', function() {
            const empresaFields = document.getElementById('empresaFields');
            if (this.value === 'Empresa' || this.value === 'Institución') {
                empresaFields.classList.remove('hidden');
            } else {
                empresaFields.classList.add('hidden');
            }
        });

        // Ejecutar al cargar si ya hay un valor seleccionado
        if (document.getElementById('tipo').value === 'Empresa' || document.getElementById('tipo').value === 'Institución') {
            document.getElementById('empresaFields').classList.remove('hidden');
        }
    </script>
    @endpush
</x-flowbite-layout>
