<x-flowbite-layout>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Editar Inversionista</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Modifica la información del inversionista</p>
    </div>

            <form action="{{ route('aportadores.update', $aportador) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Información Básica -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Información Básica</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="tipo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de Aportador <span class="text-red-500">*</span></label>
                            <select id="tipo" name="tipo" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">Seleccione...</option>
                                <option value="Persona" {{ old('tipo', $aportador->tipo) == 'Persona' ? 'selected' : '' }}>Persona</option>
                                <option value="Empresa" {{ old('tipo', $aportador->tipo) == 'Empresa' ? 'selected' : '' }}>Empresa</option>
                                <option value="Institución" {{ old('tipo', $aportador->tipo) == 'Institución' ? 'selected' : '' }}>Institución</option>
                            </select>
                            @error('tipo')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre Completo <span class="text-red-500">*</span></label>
                            <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $aportador->nombre) }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Juan Pérez">
                            @error('nombre')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="dpi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DPI</label>
                            <input type="text" id="dpi" name="dpi" value="{{ old('dpi', $aportador->dpi) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="1234567890101">
                            @error('dpi')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $aportador->email) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="email@ejemplo.com">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="telefono" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono</label>
                            <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $aportador->telefono) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="12345678">
                            @error('telefono')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="direccion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dirección</label>
                            <input type="text" id="direccion" name="direccion" value="{{ old('direccion', $aportador->direccion) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Zona 1, Guatemala">
                            @error('direccion')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Campos para Empresa -->
                    <div id="empresaFields" class="hidden mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="empresa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre de Empresa</label>
                            <input type="text" id="empresa" name="empresa" value="{{ old('empresa', $aportador->empresa) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                        </div>

                        <div>
                            <label for="nit" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIT</label>
                            <input type="text" id="nit" name="nit" value="{{ old('nit', $aportador->nit) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                        </div>
                    </div>
                </div>

                <!-- Capital Actual (solo lectura) -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Estado de Capital</h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Capital Disponible</label>
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-2.5 text-gray-900 dark:text-white">
                                Q {{ number_format($aportador->capital_disponible, 2) }}
                            </div>
                            <p class="mt-2 text-xs text-gray-600 dark:text-gray-400">Usa "Agregar Capital" o "Retirar Capital" en la vista de detalles</p>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Capital Invertido</label>
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-2.5 text-gray-900 dark:text-white">
                                Q {{ number_format($aportador->capital_invertido, 2) }}
                            </div>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ganancias Totales</label>
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-2.5 text-green-600 dark:text-green-500">
                                Q {{ number_format($aportador->ganancias_totales, 2) }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preferencias de Inversión -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Preferencias de Inversión</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="tasa_interes_minima" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tasa de Interés Mínima (%)</label>
                            <input type="number" step="0.01" id="tasa_interes_minima" name="tasa_interes_minima" value="{{ old('tasa_interes_minima', $aportador->tasa_interes_minima) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="0.00">
                        </div>

                        <div>
                            <label for="plazo_maximo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Plazo Máximo (meses)</label>
                            <input type="number" id="plazo_maximo" name="plazo_maximo" value="{{ old('plazo_maximo', $aportador->plazo_maximo) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="12">
                        </div>

                        <div>
                            <label for="monto_minimo_prestamo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Monto Mínimo por Préstamo (Q)</label>
                            <input type="number" step="0.01" id="monto_minimo_prestamo" name="monto_minimo_prestamo" value="{{ old('monto_minimo_prestamo', $aportador->monto_minimo_prestamo) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="0.00">
                        </div>

                        <div>
                            <label for="monto_maximo_prestamo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Monto Máximo por Préstamo (Q)</label>
                            <input type="number" step="0.01" id="monto_maximo_prestamo" name="monto_maximo_prestamo" value="{{ old('monto_maximo_prestamo', $aportador->monto_maximo_prestamo) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="0.00">
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
                                <option value="Activo" {{ old('estado', $aportador->estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
                                <option value="Inactivo" {{ old('estado', $aportador->estado) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                <option value="Suspendido" {{ old('estado', $aportador->estado) == 'Suspendido' ? 'selected' : '' }}>Suspendido</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label for="notas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notas</label>
                            <textarea id="notas" name="notas" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Información adicional...">{{ old('notas', $aportador->notas) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex items-center justify-between">
                    <div class="flex gap-4">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            Actualizar Aportador
                        </button>
                        <a href="{{ route('aportadores.show', $aportador) }}" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            Cancelar
                        </a>
                    </div>

                    @if($aportador->capital_invertido == 0)
                    <form action="{{ route('aportadores.destroy', $aportador) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este aportador?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">
                            Eliminar
                        </button>
                    </form>
                    @endif
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

        // Ejecutar al cargar
        const tipoValue = document.getElementById('tipo').value;
        if (tipoValue === 'Empresa' || tipoValue === 'Institución') {
            document.getElementById('empresaFields').classList.remove('hidden');
        }
    </script>
    @endpush
</x-flowbite-layout>
