<x-tailadmin-layout>
    @section('page-title', 'Nuevo Préstamo')

    <div class="mb-6">
        <h2 class="text-title-md2 font-semibold text-gray-900 dark:text-white">
            Registrar Nuevo Préstamo
        </h2>
        <p class="text-gray-500 dark:text-gray-400">Complete la información del préstamo</p>
    </div>

    <form action="{{ route('prestamos.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Selección de Cliente -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/5">
                <h3 class="mb-6 text-lg font-semibold text-gray-900 dark:text-white">Información del Cliente</h3>

                <div class="space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Cliente *</label>
                        <select name="cliente_id" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('cliente_id') border-red-500 @enderror">
                            <option value="">Seleccionar cliente...</option>
                            @foreach(\App\Models\Cliente::where('estado', 'activo')->orderBy('nombre_completo')->get() as $cliente)
                                <option value="{{ $cliente->id }}" {{ old('cliente_id', request('cliente_id')) == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->nombre_completo }} - {{ $cliente->dpi_formateado }}
                                </option>
                            @endforeach
                        </select>
                        @error('cliente_id')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Detalles del Préstamo -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/5">
                <h3 class="mb-6 text-lg font-semibold text-gray-900 dark:text-white">Detalles del Préstamo</h3>

                <div class="space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Monto a Prestar (Q) *</label>
                        <input type="number" name="monto_prestado" value="{{ old('monto_prestado') }}" step="0.01" min="100" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('monto_prestado') border-red-500 @enderror">
                        @error('monto_prestado')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Tasa de Interés (%) *</label>
                            <input type="number" name="tasa_interes" value="{{ old('tasa_interes', 5) }}" step="0.01" min="0" max="100" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('tasa_interes') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-gray-500">Recomendado: 3-6% mensual</p>
                            @error('tasa_interes')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Tipo de Interés *</label>
                            <select name="tipo_interes" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('tipo_interes') border-red-500 @enderror">
                                <option value="cuota_fija" {{ old('tipo_interes', 'cuota_fija') == 'cuota_fija' ? 'selected' : '' }}>Cuota Fija (Sistema Francés)</option>
                                <option value="flat" {{ old('tipo_interes') == 'flat' ? 'selected' : '' }}>Flat (Tasa Fija)</option>
                                <option value="sobre_saldos" {{ old('tipo_interes') == 'sobre_saldos' ? 'selected' : '' }}>Sobre Saldos (Cuota Decreciente)</option>
                                <option value="simple" {{ old('tipo_interes') == 'simple' ? 'selected' : '' }}>Simple</option>
                                <option value="compuesto" {{ old('tipo_interes') == 'compuesto' ? 'selected' : '' }}>Compuesto</option>
                            </select>
                            <p class="mt-1 text-xs text-gray-500">Cuota Fija: cuota constante | Flat: interés sobre capital original | Sobre Saldos: cuota decreciente</p>
                            @error('tipo_interes')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Plazo *</label>
                            <input type="number" name="plazo" value="{{ old('plazo', 12) }}" min="1" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('plazo') border-red-500 @enderror">
                            @error('plazo')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Frecuencia de Pago *</label>
                            <select name="frecuencia_pago" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('frecuencia_pago') border-red-500 @enderror">
                                <option value="semanal" {{ old('frecuencia_pago') == 'semanal' ? 'selected' : '' }}>Semanal</option>
                                <option value="quincenal" {{ old('frecuencia_pago') == 'quincenal' ? 'selected' : '' }}>Quincenal</option>
                                <option value="mensual" {{ old('frecuencia_pago', 'mensual') == 'mensual' ? 'selected' : '' }}>Mensual</option>
                            </select>
                            @error('frecuencia_pago')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Fecha de Desembolso *</label>
                        <input type="date" name="fecha_desembolso" value="{{ old('fecha_desembolso', date('Y-m-d')) }}" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('fecha_desembolso') border-red-500 @enderror">
                        @error('fecha_desembolso')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Observaciones -->
            <div class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/5">
                <h3 class="mb-6 text-lg font-semibold text-gray-900 dark:text-white">Información Adicional</h3>

                <div class="space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Observaciones</label>
                        <textarea name="observaciones" rows="4" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('observaciones') border-red-500 @enderror">{{ old('observaciones') }}</textarea>
                        @error('observaciones')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div class="rounded-lg bg-blue-50 p-4 dark:bg-blue-900/20">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">Información Importante</h3>
                                <div class="mt-2 text-sm text-blue-700 dark:text-blue-400">
                                    <ul class="list-disc pl-5 space-y-1">
                                        <li>El monto de la cuota y el total a pagar se calcularán automáticamente</li>
                                        <li>La fecha del primer pago se establecerá según la frecuencia seleccionada</li>
                                        <li>El préstamo quedará en estado "pendiente" hasta su aprobación</li>
                                        <li>Tasa recomendada: 3-6% mensual según perfil del cliente</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 flex gap-4">
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-600 px-6 py-3 text-center text-base font-semibold text-white hover:bg-brand-700 focus:outline-none focus:ring-4 focus:ring-brand-300 dark:bg-brand-600 dark:hover:bg-brand-700 dark:focus:ring-brand-800">
                Registrar Préstamo
            </button>
            <a href="{{ route('prestamos.index') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-3 text-center text-base font-medium text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                Cancelar
            </a>
        </div>
    </form>
</x-tailadmin-layout>
