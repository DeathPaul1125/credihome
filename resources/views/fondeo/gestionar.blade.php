<x-flowbite-layout>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Gestionar Fondeo - {{ $prestamo->numero_prestamo }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Asignar aportadores al préstamo</p>
            </div>
            <a href="{{ route('fondeo.index') }}" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700">
                Volver
            </a>
        </div>
    </div>

    <!-- Mensajes -->
    @if(session('success'))
        <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Información del Préstamo -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Cliente</h3>
            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $prestamo->cliente->nombre_completo }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Monto del Préstamo</h3>
            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ money_symbol($prestamo->monto_prestado) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Plazo</h3>
            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $prestamo->plazo }} {{ $prestamo->frecuencia_pago }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Tasa de Interés</h3>
            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ percentage($prestamo->tasa_interes) }}</p>
        </div>
    </div>

    <!-- Estado del Fondeo -->
    <div class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-gray-800 dark:to-gray-700 rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Estado del Fondeo</h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">Monto Fondeado</p>
                <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ money_symbol($montoFondeado) }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">Monto Faltante</p>
                <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ money_symbol($montoFaltante) }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">Progreso</p>
                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($porcentajeFondeo, 1) }}%</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg p-4">
            <div class="w-full bg-gray-200 rounded-full h-4 dark:bg-gray-700">
                <div class="bg-blue-600 h-4 rounded-full transition-all duration-300" style="width: {{ min($porcentajeFondeo, 100) }}%"></div>
            </div>
        </div>

        @if($porcentajeFondeo >= 100)
            <div class="mt-4 p-4 bg-green-100 dark:bg-green-900/20 border border-green-300 dark:border-green-700 rounded-lg">
                <p class="text-green-800 dark:text-green-400 font-semibold">
                    ✓ El préstamo está completamente fondeado y listo para aprobación automática.
                </p>
            </div>
        @endif
    </div>

    <!-- Aportadores Asignados -->
    @if($prestamo->aportaciones->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Aportadores Asignados</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Aportador</th>
                                <th scope="col" class="px-6 py-3">Monto Aportado</th>
                                <th scope="col" class="px-6 py-3">Participación</th>
                                <th scope="col" class="px-6 py-3">Fecha</th>
                                <th scope="col" class="px-6 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prestamo->aportaciones as $aportacion)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $aportacion->aportador->nombre }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-green-600 dark:text-green-400">
                                        {{ money_symbol($aportacion->monto_aportado) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                            {{ percentage($aportacion->porcentaje_participacion) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $aportacion->fecha_aportacion ? $aportacion->fecha_aportacion->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @can('gestionar-fondeo-prestamos')
                                            <form action="{{ route('fondeo.eliminar-aportacion', [$prestamo, $aportacion]) }}"
                                                method="POST"
                                                onsubmit="return confirm('¿Eliminar esta aportación? El capital se devolverá al aportador.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-medium text-red-600 hover:text-red-700 dark:text-red-500">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- Agregar Nueva Aportación -->
    @can('gestionar-fondeo-prestamos')
        @if($montoFaltante > 0.01)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Agregar Aportación</h3>

                <form action="{{ route('fondeo.agregar-aportacion', $prestamo) }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Aportador -->
                        <div>
                            <label for="aportador_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Aportador <span class="text-red-600">*</span>
                            </label>
                            <select id="aportador_id" name="aportador_id" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('aportador_id') border-red-500 @enderror">
                                <option value="">Seleccione un aportador</option>
                                @foreach($aportadores as $aportador)
                                    <option value="{{ $aportador->id }}"
                                        data-capital="{{ $aportador->capital_disponible }}"
                                        {{ old('aportador_id') == $aportador->id ? 'selected' : '' }}>
                                        {{ $aportador->nombre }} - Capital disponible: {{ money_symbol($aportador->capital_disponible) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('aportador_id')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Monto -->
                        <div>
                            <label for="monto_aportado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Monto a Aportar <span class="text-red-600">*</span>
                            </label>
                            <input type="number" id="monto_aportado" name="monto_aportado"
                                value="{{ old('monto_aportado', $montoFaltante) }}"
                                step="0.01" min="0.01" max="{{ $montoFaltante }}" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('monto_aportado') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Máximo: {{ money_symbol($montoFaltante) }}
                            </p>
                            @error('monto_aportado')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700">
                            Agregar Aportación
                        </button>
                        <button type="button" id="btnFondeoCompleto" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700">
                            Fondear Monto Faltante Completo
                        </button>
                    </div>
                </form>
            </div>

            <script>
                // Botón para fondear el monto completo faltante
                document.getElementById('btnFondeoCompleto').addEventListener('click', function() {
                    const montoFaltante = {{ $montoFaltante }};
                    document.getElementById('monto_aportado').value = montoFaltante.toFixed(2);
                });

                // Validar capital disponible del aportador
                document.getElementById('aportador_id').addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const capitalDisponible = parseFloat(selectedOption.dataset.capital || 0);
                    const inputMonto = document.getElementById('monto_aportado');

                    if (capitalDisponible > 0 && capitalDisponible < parseFloat(inputMonto.value)) {
                        inputMonto.value = capitalDisponible.toFixed(2);
                        inputMonto.max = capitalDisponible;
                    }
                });
            </script>
        @endif
    @endcan
</x-flowbite-layout>
