<x-tailadmin-layout>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Breadcrumb -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Detalle del Préstamo #{{ $prestamo->numero_prestamo }}
            </h2>
            <nav>
                <ol class="flex items-center gap-2">
                    <li>
                        <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
                    </li>
                    <li>
                        <a class="font-medium" href="{{ route('prestamos.index') }}">Préstamos /</a>
                    </li>
                    <li class="font-medium text-primary">#{{ $prestamo->numero_prestamo }}</li>
                </ol>
            </nav>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Información del Préstamo -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Estado y Datos Principales -->
                <div class="rounded-lg border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                        <h3 class="font-semibold text-black dark:text-white">Información General</h3>
                    </div>
                    <div class="p-7">
                        <div class="space-y-4">
                            <div class="text-center">
                                @if($prestamo->estado === 'activo')
                                    <span class="inline-flex rounded-full bg-success bg-opacity-10 px-4 py-2 text-base font-medium text-success">Activo</span>
                                @elseif($prestamo->estado === 'pagado')
                                    <span class="inline-flex rounded-full bg-primary bg-opacity-10 px-4 py-2 text-base font-medium text-primary">Pagado</span>
                                @elseif($prestamo->estado === 'en_mora')
                                    <span class="inline-flex rounded-full bg-danger bg-opacity-10 px-4 py-2 text-base font-medium text-danger">En Mora</span>
                                @elseif($prestamo->estado === 'vencido')
                                    <span class="inline-flex rounded-full bg-warning bg-opacity-10 px-4 py-2 text-base font-medium text-warning">Vencido</span>
                                @elseif($prestamo->estado === 'pendiente')
                                    <span class="inline-flex rounded-full bg-secondary bg-opacity-10 px-4 py-2 text-base font-medium text-secondary">Pendiente Aprobación</span>
                                @else
                                    <span class="inline-flex rounded-full bg-gray-400 bg-opacity-10 px-4 py-2 text-base font-medium text-gray-400">{{ ucfirst($prestamo->estado) }}</span>
                                @endif
                            </div>

                            <div class="border-t border-stroke pt-4 dark:border-strokedark">
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Cliente</label>
                                <a href="{{ route('clientes.show', $prestamo->cliente) }}" class="text-primary hover:underline">
                                    {{ $prestamo->cliente->nombre_completo }}
                                </a>
                                <p class="text-xs text-body-secondary">{{ $prestamo->cliente->dpi_formateado }}</p>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Número de Préstamo</label>
                                <p class="text-body font-mono">{{ $prestamo->numero_prestamo }}</p>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Fecha de Desembolso</label>
                                <p class="text-body">{{ \Carbon\Carbon::parse($prestamo->fecha_desembolso)->format('d/m/Y') }}</p>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Fecha de Finalización</label>
                                <p class="text-body">{{ \Carbon\Carbon::parse($prestamo->fecha_finalizacion)->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información del Cliente -->
                <div class="rounded-lg border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                        <h3 class="font-semibold text-black dark:text-white">Datos del Cliente</h3>
                    </div>
                    <div class="p-7">
                        <div class="space-y-3">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Teléfono</label>
                                <p class="text-body">{{ $prestamo->cliente->telefono_formateado }}</p>
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Dirección</label>
                                <p class="text-body text-sm">{{ $prestamo->cliente->direccion }}</p>
                                <p class="text-xs text-body-secondary">{{ $prestamo->cliente->municipio }}, {{ $prestamo->cliente->departamento }}</p>
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Ingreso Mensual</label>
                                <p class="text-body font-semibold">{{ money_symbol($prestamo->cliente->ingreso_mensual) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detalles Financieros -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Resumen Financiero -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                    <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                        <h4 class="text-sm font-medium text-body-secondary mb-2">Monto Prestado</h4>
                        <p class="text-2xl font-bold text-black dark:text-white">{{ money_symbol($prestamo->monto_prestado) }}</p>
                    </div>

                    <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                        <h4 class="text-sm font-medium text-body-secondary mb-2">Interés</h4>
                        <p class="text-2xl font-bold text-warning">{{ money_symbol($prestamo->total_interes) }}</p>
                        <p class="text-xs text-body-secondary">{{ $prestamo->tasa_interes }}% {{ $prestamo->tipo_interes }}</p>
                    </div>

                    <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                        <h4 class="text-sm font-medium text-body-secondary mb-2">Total a Pagar</h4>
                        <p class="text-2xl font-bold text-primary">{{ money_symbol($prestamo->total_a_pagar) }}</p>
                    </div>

                    <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                        <h4 class="text-sm font-medium text-body-secondary mb-2">Saldo Pendiente</h4>
                        <p class="text-2xl font-bold text-danger">{{ money_symbol($prestamo->saldo_pendiente) }}</p>
                    </div>
                </div>

                <!-- Detalles del Préstamo -->
                <div class="rounded-lg border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                        <h3 class="font-semibold text-black dark:text-white">Detalles del Préstamo</h3>
                    </div>
                    <div class="p-7">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Plazo</label>
                                <p class="text-body">{{ $prestamo->plazo }} {{ ucfirst($prestamo->frecuencia_pago) }}es</p>
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Frecuencia de Pago</label>
                                <p class="text-body">{{ ucfirst($prestamo->frecuencia_pago) }}</p>
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Monto de Cuota</label>
                                <p class="text-body font-semibold text-primary">{{ money_symbol($prestamo->monto_cuota) }}</p>
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Pagos Realizados</label>
                                <p class="text-body">{{ $prestamo->pagos_realizados }} de {{ $prestamo->plazo }}</p>
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Total Pagado</label>
                                <p class="text-body font-semibold text-success">{{ money_symbol($prestamo->total_pagado) }}</p>
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Primer Pago</label>
                                <p class="text-body">{{ $prestamo->fecha_primer_pago ? \Carbon\Carbon::parse($prestamo->fecha_primer_pago)->format('d/m/Y') : 'N/A' }}</p>
                            </div>
                        </div>

                        @if($prestamo->observaciones)
                            <div class="mt-6 pt-6 border-t border-stroke dark:border-strokedark">
                                <label class="mb-2 block text-sm font-medium text-black dark:text-white">Observaciones</label>
                                <p class="text-body">{{ $prestamo->observaciones }}</p>
                            </div>
                        @endif

                        <div class="mt-6 flex gap-3">
                            @if($prestamo->estado === 'pendiente')
                                <form action="{{ route('prestamos.aprobar', $prestamo) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-md bg-success px-4 py-2 text-center font-medium text-white hover:bg-opacity-90">
                                        Aprobar Préstamo
                                    </button>
                                </form>
                            @endif
                            @if(in_array($prestamo->estado, ['pendiente', 'activo']))
                                <a href="{{ route('prestamos.edit', $prestamo) }}" class="inline-flex items-center justify-center gap-2 rounded-md bg-primary px-4 py-2 text-center font-medium text-white hover:bg-opacity-90">
                                    Editar
                                </a>
                            @endif
                            @if(in_array($prestamo->estado, ['activo', 'en_mora']))
                                <a href="{{ route('pagos.create', ['prestamo_id' => $prestamo->id]) }}" class="inline-flex items-center justify-center gap-2 rounded-md bg-warning px-4 py-2 text-center font-medium text-white hover:bg-opacity-90">
                                    Registrar Pago
                                </a>
                            @endif
                            <a href="{{ route('prestamos.index') }}" class="inline-flex items-center justify-center gap-2 rounded-md border border-stroke px-4 py-2 text-center font-medium hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4">
                                Volver
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Historial de Pagos -->
                <div class="rounded-lg border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                        <h3 class="font-semibold text-black dark:text-white">Historial de Pagos</h3>
                    </div>
                    <div class="p-7">
                        @if($prestamo->pagos->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full table-auto">
                                    <thead>
                                        <tr class="bg-gray-2 text-left dark:bg-meta-4">
                                            <th class="px-4 py-3 font-medium text-black dark:text-white">Recibo</th>
                                            <th class="px-4 py-3 font-medium text-black dark:text-white">Fecha</th>
                                            <th class="px-4 py-3 font-medium text-black dark:text-white">Cuota #</th>
                                            <th class="px-4 py-3 font-medium text-black dark:text-white">Monto</th>
                                            <th class="px-4 py-3 font-medium text-black dark:text-white">Mora</th>
                                            <th class="px-4 py-3 font-medium text-black dark:text-white">Total</th>
                                            <th class="px-4 py-3 font-medium text-black dark:text-white">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($prestamo->pagos as $pago)
                                            <tr class="border-b border-stroke dark:border-strokedark">
                                                <td class="px-4 py-3 font-mono text-sm">{{ $pago->numero_recibo }}</td>
                                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}</td>
                                                <td class="px-4 py-3">{{ $pago->numero_cuota }}</td>
                                                <td class="px-4 py-3">{{ money_symbol($pago->monto_pagado) }}</td>
                                                <td class="px-4 py-3">
                                                    @if($pago->mora > 0)
                                                        <span class="text-danger">{{ money_symbol($pago->mora) }}</span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 font-semibold">{{ money_symbol($pago->monto_pagado + $pago->mora) }}</td>
                                                <td class="px-4 py-3">{!! $pago->badge_estado !!}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-gray-2 dark:bg-meta-4">
                                            <td colspan="3" class="px-4 py-3 font-semibold text-black dark:text-white">Totales</td>
                                            <td class="px-4 py-3 font-semibold text-black dark:text-white">{{ money_symbol($prestamo->pagos->sum('monto_pagado')) }}</td>
                                            <td class="px-4 py-3 font-semibold text-danger">{{ money_symbol($prestamo->pagos->sum('mora')) }}</td>
                                            <td class="px-4 py-3 font-semibold text-black dark:text-white">{{ money_symbol($prestamo->pagos->sum(function($p) { return $p->monto_pagado + $p->mora; })) }}</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <p class="text-center text-body py-8">No hay pagos registrados</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tailadmin-layout>
