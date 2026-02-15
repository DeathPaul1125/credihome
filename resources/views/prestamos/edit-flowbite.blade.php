<x-flowbite-layout>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Editar Venta</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Actualizar información de la venta {{ $prestamo->numero_prestamo }}</p>
            </div>
            <a href="{{ route('prestamos.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                Volver
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6">
            <form action="{{ route('prestamos.update', $prestamo->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Cliente -->
                    <div class="md:col-span-2">
                        <label for="cliente_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cliente <span class="text-red-500">*</span></label>
                        <select id="cliente_id" name="cliente_id" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('cliente_id') border-red-500 @enderror">
                            <option value="">Seleccionar cliente...</option>
                            @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ old('cliente_id', $prestamo->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nombre_completo }} - {{ $cliente->dpi }}
                            </option>
                            @endforeach
                        </select>
                        @error('cliente_id')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Monto de la Venta -->
                    <div>
                        <label for="monto_prestado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Monto de la Venta (Q) <span class="text-red-500">*</span></label>
                        <input type="number" id="monto_prestado" name="monto_prestado" value="{{ old('monto_prestado', $prestamo->monto_prestado) }}" step="0.01" min="0" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('monto_prestado') border-red-500 @enderror" placeholder="5000.00">
                        @error('monto_prestado')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tasa de Interés -->
                    <div>
                        <label for="tasa_interes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tasa de Interés (%) <span class="text-red-500">*</span></label>
                        <input type="number" id="tasa_interes" name="tasa_interes" value="{{ old('tasa_interes', $prestamo->tasa_interes) }}" step="0.01" min="0" max="100" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('tasa_interes') border-red-500 @enderror" placeholder="15.00">
                        @error('tasa_interes')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Plazo en Meses -->
                    <div>
                        <label for="plazo_meses" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Plazo (meses) <span class="text-red-500">*</span></label>
                        <input type="number" id="plazo_meses" name="plazo_meses" value="{{ old('plazo_meses', $prestamo->plazo_meses) }}" min="1" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('plazo_meses') border-red-500 @enderror" placeholder="12">
                        @error('plazo_meses')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Frecuencia de Pago -->
                    <div>
                        <label for="frecuencia_pago" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Frecuencia de Pago <span class="text-red-500">*</span></label>
                        <select id="frecuencia_pago" name="frecuencia_pago" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('frecuencia_pago') border-red-500 @enderror">
                            <option value="">Seleccionar...</option>
                            <option value="diaria" {{ old('frecuencia_pago', $prestamo->frecuencia_pago) == 'diaria' ? 'selected' : '' }}>Diaria</option>
                            <option value="semanal" {{ old('frecuencia_pago', $prestamo->frecuencia_pago) == 'semanal' ? 'selected' : '' }}>Semanal</option>
                            <option value="quincenal" {{ old('frecuencia_pago', $prestamo->frecuencia_pago) == 'quincenal' ? 'selected' : '' }}>Quincenal</option>
                            <option value="mensual" {{ old('frecuencia_pago', $prestamo->frecuencia_pago) == 'mensual' ? 'selected' : '' }}>Mensual</option>
                        </select>
                        @error('frecuencia_pago')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha de Desembolso -->
                    <div>
                        <label for="fecha_desembolso" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de Desembolso <span class="text-red-500">*</span></label>
                        <input type="date" id="fecha_desembolso" name="fecha_desembolso" value="{{ old('fecha_desembolso', $prestamo->fecha_desembolso->format('Y-m-d')) }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('fecha_desembolso') border-red-500 @enderror">
                        @error('fecha_desembolso')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha de Vencimiento -->
                    <div>
                        <label for="fecha_vencimiento" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de Vencimiento</label>
                        <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" value="{{ old('fecha_vencimiento', $prestamo->fecha_vencimiento ? $prestamo->fecha_vencimiento->format('Y-m-d') : '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('fecha_vencimiento') border-red-500 @enderror">
                        @error('fecha_vencimiento')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Saldo Pendiente -->
                    <div>
                        <label for="saldo_pendiente" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Saldo Pendiente (Q) <span class="text-red-500">*</span></label>
                        <input type="number" id="saldo_pendiente" name="saldo_pendiente" value="{{ old('saldo_pendiente', $prestamo->saldo_pendiente) }}" step="0.01" min="0" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('saldo_pendiente') border-red-500 @enderror">
                        @error('saldo_pendiente')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Estado -->
                    <div>
                        <label for="estado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado <span class="text-red-500">*</span></label>
                        <select id="estado" name="estado" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('estado') border-red-500 @enderror">
                            <option value="activo" {{ old('estado', $prestamo->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="en_mora" {{ old('estado', $prestamo->estado) == 'en_mora' ? 'selected' : '' }}>En Mora</option>
                            <option value="completado" {{ old('estado', $prestamo->estado) == 'completado' ? 'selected' : '' }}>Completado</option>
                            <option value="cancelado" {{ old('estado', $prestamo->estado) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                        @error('estado')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <!-- Notas -->
                    <label for="notas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notas Adicionales</label>
                    <textarea id="notas" name="notas" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('notas') border-red-500 @enderror">{{ old('notas', $prestamo->notas) }}</textarea>
                    @error('notas')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center space-x-4">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Actualizar Venta
                    </button>
                    <a href="{{ route('prestamos.show', $prestamo->id) }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-flowbite-layout>
