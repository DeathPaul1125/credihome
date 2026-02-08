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

    @if(session('error'))
    <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <div>{{ session('error') }}</div>
    </div>
    @endif

    @if($prestamo->cotizacion_id && $prestamo->cotizacion)
    <div class="flex items-center p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800" role="alert">
        <svg class="flex-shrink-0 inline w-5 h-5 me-3" fill="currentColor" viewBox="0 0 20 20">
            <path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"/>
        </svg>
        <div class="flex items-center justify-between w-full">
            <span>
                <strong>Préstamo generado desde cotización:</strong>
                Este préstamo fue creado a partir de la cotización {{ $prestamo->cotizacion->numero_cotizacion }}
            </span>
            <a href="{{ route('cotizaciones.show', $prestamo->cotizacion) }}" class="ml-4 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-semibold flex items-center">
                Ver Cotización
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
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
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ money_symbol($prestamo->monto_prestado) }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tasa de Interés</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ percentage($prestamo->tasa_interes) }}</dd>
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
                    <dd class="mt-1 text-2xl font-bold text-blue-600 dark:text-blue-400">{{ money_symbol($prestamo->saldo_pendiente) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pagado</dt>
                    <dd class="mt-1 text-2xl font-bold text-green-600 dark:text-green-400">{{ money_symbol($prestamo->pagos->sum('monto')) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Pagos Realizados</dt>
                    <dd class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">{{ $prestamo->pagos->count() }}</dd>
                </div>
                @php
                    $totalPagado = $prestamo->pagos->sum('monto');
                    $progreso = $prestamo->monto_total > 0 ? ($totalPagado / $prestamo->monto_total) * 100 : 0;
                    $progreso = max(0, min($progreso, 100)); // Asegurar que esté entre 0 y 100
                @endphp
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Progreso del Pago</dt>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $progreso }}%"></div>
                    </div>
                    <dd class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ percentage($progreso, 1) }}</dd>
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
                                {{ money_symbol($aportacion->monto_aportado) }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                    {{ percentage($aportacion->porcentaje_participacion) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right text-green-600 dark:text-green-400">
                                {{ money_symbol($aportacion->monto_recuperado) }}
                            </td>
                            <td class="px-6 py-4 text-right text-green-600 dark:text-green-400">
                                {{ money_symbol($aportacion->intereses_ganados) }}
                            </td>
                            <td class="px-6 py-4 text-right text-gray-900 dark:text-white">
                                {{ money_symbol($aportacion->saldo_pendiente) }}
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
                            <td class="px-6 py-3 text-right">{{ money_symbol($prestamo->aportaciones->sum('monto_aportado')) }}</td>
                            <td class="px-6 py-3 text-right">{{ percentage($prestamo->aportaciones->sum('porcentaje_participacion')) }}</td>
                            <td class="px-6 py-3 text-right text-green-600 dark:text-green-400">{{ money_symbol($prestamo->aportaciones->sum('monto_recuperado')) }}</td>
                            <td class="px-6 py-3 text-right text-green-600 dark:text-green-400">{{ money_symbol($prestamo->aportaciones->sum('intereses_ganados')) }}</td>
                            <td class="px-6 py-3 text-right">{{ money_symbol($prestamo->aportaciones->sum('saldo_pendiente')) }}</td>
                            <td class="px-6 py-3"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Tabla de Amortización -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-4">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">📊 Tabla de Amortización</h2>
                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $prestamo->plazo }} cuotas</span>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-center">#</th>
                        <th scope="col" class="px-4 py-3">Fecha Vencimiento</th>
                        <th scope="col" class="px-4 py-3 text-right">Cuota</th>
                        <th scope="col" class="px-4 py-3 text-right">Capital</th>
                        <th scope="col" class="px-4 py-3 text-right">Interés</th>
                        <th scope="col" class="px-4 py-3 text-right">Saldo</th>
                        <th scope="col" class="px-4 py-3 text-center">Estado</th>
                        <th scope="col" class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tablaAmortizacion as $cuota)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600
                        {{ $cuota['estado'] === 'vencida' ? 'bg-red-50 dark:bg-red-900/20' : '' }}
                        {{ $cuota['estado'] === 'pagada' ? 'bg-green-50 dark:bg-green-900/20' : '' }}">
                        <td class="px-4 py-3 text-center font-medium text-gray-900 dark:text-white">
                            {{ $cuota['numero_cuota'] }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-col">
                                <span class="text-gray-900 dark:text-white">{{ $cuota['fecha_vencimiento']->format('d/m/Y') }}</span>
                                @if($cuota['fecha_pago'])
                                <span class="text-xs text-green-600 dark:text-green-400">Pagado: {{ $cuota['fecha_pago']->format('d/m/Y') }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 text-right font-medium text-gray-900 dark:text-white">
                            {{ money_symbol($cuota['cuota']) }}
                        </td>
                        <td class="px-4 py-3 text-right text-blue-600 dark:text-blue-400">
                            {{ money_symbol($cuota['capital']) }}
                        </td>
                        <td class="px-4 py-3 text-right text-orange-600 dark:text-orange-400">
                            {{ money_symbol($cuota['interes']) }}
                        </td>
                        <td class="px-4 py-3 text-right text-gray-900 dark:text-white">
                            {{ money_symbol($cuota['saldo']) }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($cuota['estado'] === 'pagada')
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                    ✓ Pagada
                                </span>
                            @elseif($cuota['estado'] === 'vencida')
                                <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">
                                    ⚠ Vencida
                                </span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">
                                    ⏱ Pendiente
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($cuota['estado'] === 'pagada')
                                @if($cuota['numero_recibo'])
                                <a href="{{ route('pagos.recibo', $cuota['pago_id']) }}" target="_blank"
                                   class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium text-xs"
                                   title="Ver recibo">
                                    📄 {{ $cuota['numero_recibo'] }}
                                </a>
                                @endif
                            @elseif($prestamo->estado === 'activo' || $prestamo->estado === 'en_mora')
                                <a href="{{ route('pagos.create', ['prestamo_id' => $prestamo->id, 'numero_cuota' => $cuota['numero_cuota']]) }}"
                                   class="inline-flex items-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded text-xs px-3 py-1.5 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800"
                                   title="Registrar pago">
                                    💰 Pagar
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="text-xs font-semibold text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <td colspan="2" class="px-4 py-3 text-right">TOTALES:</td>
                        <td class="px-4 py-3 text-right text-gray-900 dark:text-white">
                            {{ money_symbol($prestamo->monto_total) }}
                        </td>
                        <td class="px-4 py-3 text-right text-blue-600 dark:text-blue-400">
                            {{ money_symbol($prestamo->monto_prestado) }}
                        </td>
                        <td class="px-4 py-3 text-right text-orange-600 dark:text-orange-400">
                            {{ money_symbol($prestamo->interes_total) }}
                        </td>
                        <td colspan="3" class="px-4 py-3"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="p-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                <div>
                    <span class="text-gray-600 dark:text-gray-400">Cuotas Pagadas:</span>
                    <span class="font-semibold text-green-600 dark:text-green-400 ml-2">
                        {{ collect($tablaAmortizacion)->where('estado', 'pagada')->count() }} / {{ $prestamo->plazo }}
                    </span>
                </div>
                <div>
                    <span class="text-gray-600 dark:text-gray-400">Cuotas Vencidas:</span>
                    <span class="font-semibold text-red-600 dark:text-red-400 ml-2">
                        {{ collect($tablaAmortizacion)->where('estado', 'vencida')->count() }}
                    </span>
                </div>
                <div>
                    <span class="text-gray-600 dark:text-gray-400">Cuotas Pendientes:</span>
                    <span class="font-semibold text-yellow-600 dark:text-yellow-400 ml-2">
                        {{ collect($tablaAmortizacion)->where('estado', 'pendiente')->count() }}
                    </span>
                </div>
                <div>
                    <span class="text-gray-600 dark:text-gray-400">Progreso:</span>
                    <span class="font-semibold text-blue-600 dark:text-blue-400 ml-2">
                        {{ round((collect($tablaAmortizacion)->where('estado', 'pagada')->count() / $prestamo->plazo) * 100, 1) }}%
                    </span>
                </div>
            </div>
        </div>
    </div>

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
                        @if(Auth::check() && Auth::user()->hasPermissionTo('eliminar-pagos'))
                        <th scope="col" class="px-6 py-3">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($prestamo->pagos->sortByDesc('fecha_pago') as $pago)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $pago->numero_recibo }}</td>
                        <td class="px-6 py-4">{{ $pago->fecha_pago->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 font-semibold text-green-600">{{ money_symbol($pago->monto) }}</td>
                        <td class="px-6 py-4">{{ money_symbol($pago->saldo_anterior ?? 0) }}</td>
                        <td class="px-6 py-4">{{ money_symbol($pago->saldo_despues ?? 0) }}</td>
                        <td class="px-6 py-4">{{ ucfirst($pago->metodo_pago ?? 'N/A') }}</td>
                        <td class="px-6 py-4">{{ $pago->notas ?? '-' }}</td>
                        @if(Auth::check() && Auth::user()->hasPermissionTo('eliminar-pagos'))
                        <td class="px-6 py-4">
                            <form action="{{ route('pagos.destroy', $pago->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de eliminar este pago? Solo se puede eliminar el último pago registrado.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                        @endif
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
