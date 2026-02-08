<x-flowbite-layout>
    <!-- Header -->
    <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Editar Aportación</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Modificar los datos de la aportación al préstamo
            </p>
        </div>

        <!-- Información del Préstamo y Aportador -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="bg-blue-50 dark:bg-blue-900 dark:bg-opacity-20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                <h3 class="text-sm font-semibold text-blue-900 dark:text-blue-300 mb-2">
                    <i class="fas fa-user mr-2"></i>Aportador
                </h3>
                <p class="text-lg font-bold text-blue-900 dark:text-blue-200">{{ $aportacion->aportador->nombre }}</p>
                <p class="text-xs text-blue-700 dark:text-blue-400 mt-1">DPI: {{ $aportacion->aportador->dpi ?? 'N/A' }}</p>
            </div>

            <div class="bg-green-50 dark:bg-green-900 dark:bg-opacity-20 rounded-lg p-4 border border-green-200 dark:border-green-800">
                <h3 class="text-sm font-semibold text-green-900 dark:text-green-300 mb-2">
                    <i class="fas fa-hand-holding-usd mr-2"></i>Préstamo
                </h3>
                <p class="text-lg font-bold text-green-900 dark:text-green-200">
                    <a href="{{ route('prestamos.show', $aportacion->prestamo) }}" class="hover:underline">
                        Préstamo #{{ $aportacion->prestamo->id }}
                    </a>
                </p>
                <p class="text-xs text-green-700 dark:text-green-400 mt-1">
                    Cliente: {{ $aportacion->prestamo->cliente->nombre_completo ?? 'N/A' }}
                </p>
            </div>
        </div>

        <!-- Formulario de Edición -->
        <form action="{{ route('aportaciones.update', $aportacion) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-edit mr-2"></i>Datos de la Aportación
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Monto Aportado -->
                    <div>
                        <label for="monto_aportado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Monto Aportado <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400">Q</span>
                            </div>
                            <input type="number" step="0.01" id="monto_aportado" name="monto_aportado"
                                   value="{{ old('monto_aportado', $aportacion->monto_aportado) }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                   required>
                        </div>
                        @error('monto_aportado')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Porcentaje de Participación -->
                    <div>
                        <label for="porcentaje_participacion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Porcentaje de Participación <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" step="0.01" id="porcentaje_participacion" name="porcentaje_participacion"
                                   value="{{ old('porcentaje_participacion', $aportacion->porcentaje_participacion) }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                   required min="0" max="100">
                            <div class="absolute inset-y-0 end-0 flex items-center pe-3 pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400">%</span>
                            </div>
                        </div>
                        @error('porcentaje_participacion')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Monto Recuperado -->
                    <div>
                        <label for="monto_recuperado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Monto Recuperado
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400">Q</span>
                            </div>
                            <input type="number" step="0.01" id="monto_recuperado" name="monto_recuperado"
                                   value="{{ old('monto_recuperado', $aportacion->monto_recuperado) }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                        </div>
                        @error('monto_recuperado')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            <i class="fas fa-info-circle mr-1"></i>
                            Este valor se calcula automáticamente desde las distribuciones de pagos
                        </p>
                    </div>

                    <!-- Intereses Ganados -->
                    <div>
                        <label for="intereses_ganados" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Intereses Ganados
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400">Q</span>
                            </div>
                            <input type="number" step="0.01" id="intereses_ganados" name="intereses_ganados"
                                   value="{{ old('intereses_ganados', $aportacion->intereses_ganados) }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                        </div>
                        @error('intereses_ganados')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            <i class="fas fa-info-circle mr-1"></i>
                            Este valor se calcula automáticamente desde las distribuciones de pagos
                        </p>
                    </div>

                    <!-- Estado -->
                    <div>
                        <label for="estado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Estado <span class="text-red-500">*</span>
                        </label>
                        <select id="estado" name="estado" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            <option value="Activo" {{ old('estado', $aportacion->estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
                            <option value="Recuperado" {{ old('estado', $aportacion->estado) == 'Recuperado' ? 'selected' : '' }}>Recuperado</option>
                            <option value="Cancelado" {{ old('estado', $aportacion->estado) == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                        @error('estado')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror>
                    </div>

                    <!-- Notas -->
                    <div class="md:col-span-2">
                        <label for="notas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Notas / Observaciones
                        </label>
                        <textarea id="notas" name="notas" rows="3"
                                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                  placeholder="Información adicional sobre esta aportación...">{{ old('notas', $aportacion->notas) }}</textarea>
                        @error('notas')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Información Calculada -->
                <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">
                        <i class="fas fa-calculator mr-2"></i>Información Calculada
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <p class="text-gray-600 dark:text-gray-400">Saldo Pendiente</p>
                            <p class="font-bold text-gray-900 dark:text-white">{{ money_symbol($aportacion->saldo_pendiente) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400">ROI</p>
                            <p class="font-bold text-green-600 dark:text-green-400">{{ percentage($aportacion->roi) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400">% Recuperado</p>
                            <p class="font-bold text-blue-600 dark:text-blue-400">{{ percentage($aportacion->porcentaje_recuperado) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400">Fecha Aportación</p>
                            <p class="font-bold text-gray-900 dark:text-white">{{ $aportacion->fecha_aportacion->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="mt-6 flex items-center gap-3">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        <i class="fas fa-save mr-2"></i>Guardar Cambios
                    </button>

                    <a href="{{ route('aportadores.show', $aportacion->aportador_id) }}" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                        <i class="fas fa-times mr-2"></i>Cancelar
                    </a>
                </div>
            </div>
        </form>
</x-flowbite-layout>
