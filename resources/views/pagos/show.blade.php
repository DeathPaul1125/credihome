<x-tailadmin-layout>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Breadcrumb -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Detalle del Pago
            </h2>
            <nav>
                <ol class="flex items-center gap-2">
                    <li>
                        <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
                    </li>
                    <li>
                        <a class="font-medium" href="{{ route('pagos.index') }}">Pagos /</a>
                    </li>
                    <li class="font-medium text-primary">{{ $pago->numero_recibo }}</li>
                </ol>
            </nav>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Información del Pago -->
            <div class="lg:col-span-1">
                <div class="rounded-lg border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                        <h3 class="font-semibold text-black dark:text-white">Información del Pago</h3>
                    </div>
                    <div class="p-7">
                        <div class="space-y-4">
                            <div class="text-center mb-4">
                                {!! $pago->badge_estado !!}
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Número de Recibo</label>
                                <p class="text-body font-mono">{{ $pago->numero_recibo }}</p>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Fecha de Pago</label>
                                <p class="text-body">{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}</p>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Método de Pago</label>
                                <p class="text-body">{{ ucfirst($pago->metodo_pago) }}</p>
                            </div>

                            <div class="border-t border-stroke pt-4 dark:border-strokedark">
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Monto Pagado</label>
                                <p class="text-2xl font-bold text-success">Q {{ number_format($pago->monto_pagado, 2) }}</p>
                            </div>

                            @if($pago->mora > 0)
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-black dark:text-white">Mora</label>
                                    <p class="text-xl font-semibold text-danger">Q {{ number_format($pago->mora, 2) }}</p>
                                    @if($pago->dias_atraso > 0)
                                        <p class="text-xs text-body-secondary">{{ $pago->dias_atraso }} días de atraso</p>
                                    @endif
                                </div>

                                <div>
                                    <label class="mb-1 block text-sm font-medium text-black dark:text-white">Total Recibido</label>
                                    <p class="text-2xl font-bold text-black dark:text-white">Q {{ number_format($pago->monto_pagado + $pago->mora, 2) }}</p>
                                </div>
                            @endif

                            <div class="border-t border-stroke pt-4 dark:border-strokedark">
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Recibido por</label>
                                <p class="text-body">{{ $pago->usuario->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Préstamo y Cliente -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Información del Préstamo -->
                <div class="rounded-lg border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                        <h3 class="font-semibold text-black dark:text-white">Información del Préstamo</h3>
                    </div>
                    <div class="p-7">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Número de Préstamo</label>
                                <a href="{{ route('prestamos.show', $pago->prestamo) }}" class="text-primary hover:underline font-mono">
                                    {{ $pago->prestamo->numero_prestamo }}
                                </a>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Cliente</label>
                                <a href="{{ route('clientes.show', $pago->cliente) }}" class="text-primary hover:underline">
                                    {{ $pago->cliente->nombre_completo }}
                                </a>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Número de Cuota</label>
                                <p class="text-body">{{ $pago->numero_cuota }} de {{ $pago->prestamo->plazo }}</p>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Monto de Cuota Regular</label>
                                <p class="text-body">Q {{ number_format($pago->prestamo->monto_cuota, 2) }}</p>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Saldo Anterior</label>
                                <p class="text-body">Q {{ number_format($pago->saldo_anterior, 2) }}</p>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Saldo Nuevo</label>
                                <p class="text-body font-semibold {{ $pago->saldo_nuevo > 0 ? 'text-danger' : 'text-success' }}">
                                    Q {{ number_format($pago->saldo_nuevo, 2) }}
                                </p>
                            </div>
                        </div>

                        @if($pago->fecha_vencimiento)
                            <div class="mt-6 pt-6 border-t border-stroke dark:border-strokedark">
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Fecha de Vencimiento de Cuota</label>
                                <p class="text-body">{{ \Carbon\Carbon::parse($pago->fecha_vencimiento)->format('d/m/Y') }}</p>
                                @if($pago->dias_atraso > 0)
                                    <p class="text-xs text-danger">Pago realizado {{ $pago->dias_atraso }} días después del vencimiento</p>
                                @elseif($pago->estado === 'anticipado')
                                    <p class="text-xs text-success">Pago anticipado</p>
                                @else
                                    <p class="text-xs text-success">Pago puntual</p>
                                @endif
                            </div>
                        @endif

                        @if($pago->observaciones)
                            <div class="mt-6 pt-6 border-t border-stroke dark:border-strokedark">
                                <label class="mb-2 block text-sm font-medium text-black dark:text-white">Observaciones</label>
                                <p class="text-body">{{ $pago->observaciones }}</p>
                            </div>
                        @endif

                        <div class="mt-6 flex gap-3">
                            <a href="{{ route('prestamos.show', $pago->prestamo) }}" class="inline-flex items-center justify-center gap-2 rounded-md bg-primary px-4 py-2 text-center font-medium text-white hover:bg-opacity-90">
                                Ver Préstamo
                            </a>
                            <a href="{{ route('clientes.show', $pago->cliente) }}" class="inline-flex items-center justify-center gap-2 rounded-md bg-success px-4 py-2 text-center font-medium text-white hover:bg-opacity-90">
                                Ver Cliente
                            </a>
                            <a href="{{ route('pagos.index') }}" class="inline-flex items-center justify-center gap-2 rounded-md border border-stroke px-4 py-2 text-center font-medium hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4">
                                Volver
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Comprobante de Pago -->
                <div class="rounded-lg border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold text-black dark:text-white">Comprobante de Pago</h3>
                            <button onclick="window.print()" class="inline-flex items-center justify-center gap-2 rounded-md bg-secondary px-4 py-2 text-center font-medium text-white hover:bg-opacity-90">
                                <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                    <path d="M15.75 5.25H14.25V2.25C14.25 1.425 13.575 0.75 12.75 0.75H5.25C4.425 0.75 3.75 1.425 3.75 2.25V5.25H2.25C1.425 5.25 0.75 5.925 0.75 6.75V12C0.75 12.825 1.425 13.5 2.25 13.5H3.75V15.75C3.75 16.575 4.425 17.25 5.25 17.25H12.75C13.575 17.25 14.25 16.575 14.25 15.75V13.5H15.75C16.575 13.5 17.25 12.825 17.25 12V6.75C17.25 5.925 16.575 5.25 15.75 5.25ZM5.25 2.25H12.75V5.25H5.25V2.25ZM12.75 15.75H5.25V11.25H12.75V15.75Z"/>
                                </svg>
                                Imprimir
                            </button>
                        </div>
                    </div>
                    <div class="p-7">
                        <div class="text-center mb-6">
                            <h2 class="text-2xl font-bold text-black dark:text-white">RECIBO DE PAGO</h2>
                            <p class="text-body-secondary">{{ $pago->numero_recibo }}</p>
                        </div>

                        <table class="w-full">
                            <tbody>
                                <tr class="border-b border-stroke dark:border-strokedark">
                                    <td class="py-3 px-2 font-medium">Cliente:</td>
                                    <td class="py-3 px-2">{{ $pago->cliente->nombre_completo }}</td>
                                </tr>
                                <tr class="border-b border-stroke dark:border-strokedark">
                                    <td class="py-3 px-2 font-medium">Préstamo:</td>
                                    <td class="py-3 px-2">{{ $pago->prestamo->numero_prestamo }}</td>
                                </tr>
                                <tr class="border-b border-stroke dark:border-strokedark">
                                    <td class="py-3 px-2 font-medium">Fecha de Pago:</td>
                                    <td class="py-3 px-2">{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}</td>
                                </tr>
                                <tr class="border-b border-stroke dark:border-strokedark">
                                    <td class="py-3 px-2 font-medium">Cuota #:</td>
                                    <td class="py-3 px-2">{{ $pago->numero_cuota }} de {{ $pago->prestamo->plazo }}</td>
                                </tr>
                                <tr class="border-b border-stroke dark:border-strokedark">
                                    <td class="py-3 px-2 font-medium">Monto Pagado:</td>
                                    <td class="py-3 px-2 font-semibold">Q {{ number_format($pago->monto_pagado, 2) }}</td>
                                </tr>
                                @if($pago->mora > 0)
                                    <tr class="border-b border-stroke dark:border-strokedark">
                                        <td class="py-3 px-2 font-medium">Mora:</td>
                                        <td class="py-3 px-2 text-danger">Q {{ number_format($pago->mora, 2) }}</td>
                                    </tr>
                                @endif
                                <tr class="border-b border-stroke dark:border-strokedark">
                                    <td class="py-3 px-2 font-medium text-lg">Total Recibido:</td>
                                    <td class="py-3 px-2 font-bold text-lg">Q {{ number_format($pago->monto_pagado + $pago->mora, 2) }}</td>
                                </tr>
                                <tr class="border-b border-stroke dark:border-strokedark">
                                    <td class="py-3 px-2 font-medium">Método de Pago:</td>
                                    <td class="py-3 px-2">{{ ucfirst($pago->metodo_pago) }}</td>
                                </tr>
                                <tr class="border-b border-stroke dark:border-strokedark">
                                    <td class="py-3 px-2 font-medium">Saldo Restante:</td>
                                    <td class="py-3 px-2 font-semibold {{ $pago->saldo_nuevo > 0 ? 'text-danger' : 'text-success' }}">Q {{ number_format($pago->saldo_nuevo, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-8 pt-6 border-t border-stroke dark:border-strokedark text-center">
                            <p class="text-sm text-body-secondary">Recibido por: {{ $pago->usuario->name }}</p>
                            <p class="text-xs text-body-secondary mt-2">{{ \Carbon\Carbon::parse($pago->created_at)->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tailadmin-layout>
