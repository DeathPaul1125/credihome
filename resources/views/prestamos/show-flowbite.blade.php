<x-flowbite-layout>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Préstamo {{ $prestamo->numero_prestamo }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Cliente: {{ $prestamo->cliente->nombre_completo }}</p>
            </div>
            <div class="flex items-center space-x-2">
                @if($prestamo->estado == 'activo' || $prestamo->estado == 'en_mora')
                <a href="{{ route('pagos.create', ['prestamo_id' => $prestamo->id]) }}" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                    Registrar Pago
                </a>
                @endif
                <a href="{{ route('prestamos.edit', $prestamo->id) }}" class="text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:focus:ring-yellow-900">
                    Editar
                </a>
                <a href="{{ route('prestamos.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                    Volver
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <div>{{ session('success') }}</div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
        <!-- Información del Préstamo -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Información del Préstamo</h2>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">N° Préstamo</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $prestamo->numero_prestamo }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado</dt>
                        <dd class="mt-1">
                            @if($prestamo->estado == 'activo')
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Activo</span>
                            @elseif($prestamo->estado == 'en_mora')
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">En Mora</span>
                            @elseif($prestamo->estado == 'completado')
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Completado</span>
                            @else
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">Cancelado</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto Prestado</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">Q{{ number_format($prestamo->monto_prestado, 2) }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tasa de Interés</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ number_format($prestamo->tasa_interes, 2) }}%</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Plazo</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $prestamo->plazo_meses }} meses</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Frecuencia de Pago</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ ucfirst($prestamo->frecuencia_pago) }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Desembolso</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $prestamo->fecha_desembolso->format('d/m/Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Vencimiento</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $prestamo->fecha_vencimiento ? $prestamo->fecha_vencimiento->format('d/m/Y') : 'N/A' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Resumen Financiero -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Resumen Financiero</h2>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Saldo Pendiente</dt>
                    <dd class="mt-1 text-2xl font-bold text-blue-600 dark:text-blue-400">Q{{ number_format($prestamo->saldo_pendiente, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pagado</dt>
                    <dd class="mt-1 text-2xl font-bold text-green-600 dark:text-green-400">Q{{ number_format($prestamo->pagos->sum('monto'), 2) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Pagos Realizados</dt>
                    <dd class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">{{ $prestamo->pagos->count() }}</dd>
                </div>
                @php
                    $progreso = $prestamo->monto_prestado > 0 ? (($prestamo->monto_prestado - $prestamo->saldo_pendiente) / $prestamo->monto_prestado) * 100 : 0;
                @endphp
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Progreso del Pago</dt>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $progreso }}%"></div>
                    </div>
                    <dd class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ number_format($progreso, 1) }}%</dd>
                </div>
            </div>
        </div>
    </div>

    <!-- Inversionistas del Préstamo -->
    @if($prestamo->aportaciones->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-4">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">💰 Inversionistas que Fondean este Préstamo</h2>
                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $prestamo->aportaciones->count() }} {{ $prestamo->aportaciones->count() == 1 ? 'inversionista' : 'inversionistas' }}</span>
            </div>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Inversionista</th>
                            <th scope="col" class="px-6 py-3 text-right">Monto Aportado</th>
                            <th scope="col" class="px-6 py-3 text-right">Participación</th>
                            <th scope="col" class="px-6 py-3 text-right">Recuperado</th>
                            <th scope="col" class="px-6 py-3 text-right">Intereses Ganados</th>
                            <th scope="col" class="px-6 py-3 text-right">Saldo Pendiente</th>
                            <th scope="col" class="px-6 py-3">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prestamo->aportaciones as $aportacion)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">
                                <a href="{{ route('aportadores.show', $aportacion->aportador->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                    {{ $aportacion->aportador->nombre }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-right font-medium text-gray-900 dark:text-white">
                                Q{{ number_format($aportacion->monto_aportado, 2) }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                    {{ number_format($aportacion->porcentaje_participacion, 2) }}%
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right text-green-600 dark:text-green-400">
                                Q{{ number_format($aportacion->monto_recuperado, 2) }}
                            </td>
                            <td class="px-6 py-4 text-right text-green-600 dark:text-green-400">
                                Q{{ number_format($aportacion->intereses_ganados, 2) }}
                            </td>
                            <td class="px-6 py-4 text-right text-gray-900 dark:text-white">
                                Q{{ number_format($aportacion->saldo_pendiente, 2) }}
                            </td>
                            <td class="px-6 py-4">
                                @if($aportacion->estado === 'Activo')
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                        Activo
                                    </span>
                                @elseif($aportacion->estado === 'Recuperado')
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                        Recuperado
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">
                                        {{ $aportacion->estado }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="font-semibold text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700">
                            <td class="px-6 py-3">TOTAL</td>
                            <td class="px-6 py-3 text-right">Q{{ number_format($prestamo->aportaciones->sum('monto_aportado'), 2) }}</td>
                            <td class="px-6 py-3 text-right">{{ number_format($prestamo->aportaciones->sum('porcentaje_participacion'), 2) }}%</td>
                            <td class="px-6 py-3 text-right text-green-600 dark:text-green-400">Q{{ number_format($prestamo->aportaciones->sum('monto_recuperado'), 2) }}</td>
                            <td class="px-6 py-3 text-right text-green-600 dark:text-green-400">Q{{ number_format($prestamo->aportaciones->sum('intereses_ganados'), 2) }}</td>
                            <td class="px-6 py-3 text-right">Q{{ number_format($prestamo->aportaciones->sum('saldo_pendiente'), 2) }}</td>
                            <td class="px-6 py-3"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Información del Cliente -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-4">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Información del Cliente</h2>
                <a href="{{ route('clientes.show', $prestamo->cliente->id) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    Ver perfil completo →
                </a>
            </div>
        </div>
        <div class="p-6">
            <dl class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $prestamo->cliente->nombre_completo }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">DPI</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $prestamo->cliente->dpi }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $prestamo->cliente->telefono }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dirección</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ Str::limit($prestamo->cliente->direccion_completa, 40) }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Historial de Pagos -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Historial de Pagos</h2>
        </div>
        @if($prestamo->pagos->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">N° Recibo</th>
                        <th scope="col" class="px-6 py-3">Fecha de Pago</th>
                        <th scope="col" class="px-6 py-3">Monto</th>
                        <th scope="col" class="px-6 py-3">Saldo Anterior</th>
                        <th scope="col" class="px-6 py-3">Saldo Después</th>
                        <th scope="col" class="px-6 py-3">Método</th>
                        <th scope="col" class="px-6 py-3">Notas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prestamo->pagos->sortByDesc('fecha_pago') as $pago)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $pago->numero_recibo }}</td>
                        <td class="px-6 py-4">{{ $pago->fecha_pago->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 font-semibold text-green-600">Q{{ number_format($pago->monto, 2) }}</td>
                        <td class="px-6 py-4">Q{{ number_format($pago->saldo_anterior ?? 0, 2) }}</td>
                        <td class="px-6 py-4">Q{{ number_format($pago->saldo_despues ?? 0, 2) }}</td>
                        <td class="px-6 py-4">{{ ucfirst($pago->metodo_pago ?? 'N/A') }}</td>
                        <td class="px-6 py-4">{{ $pago->notas ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="p-6 text-center text-gray-500 dark:text-gray-400">
            No se han registrado pagos para este préstamo
        </div>
        @endif
    </div>

    @if($prestamo->notas)
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow mt-4">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Notas</h2>
        </div>
        <div class="p-6">
            <p class="text-sm text-gray-900 dark:text-white">{{ $prestamo->notas }}</p>
        </div>
    </div>
    @endif
</x-flowbite-layout>
