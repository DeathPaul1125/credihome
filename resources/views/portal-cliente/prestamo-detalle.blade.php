<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Préstamo {{ $prestamo->numero_prestamo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Acciones --}}
            <div class="flex justify-between items-center mb-6">
                <a href="{{ route('portal.dashboard') }}" class="text-blue-600 hover:text-blue-900">
                    ← Volver al Inicio
                </a>
                @if(in_array($prestamo->estado, ['activo', 'en_mora']))
                <a href="{{ route('portal.subir-comprobante', $prestamo->id) }}"
                    class="bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm px-5 py-2.5">
                    Subir Comprobante de Pago
                </a>
                @endif
            </div>

            {{-- Información del Préstamo --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold">Información del Préstamo</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <span class="text-sm text-gray-600">Número de Préstamo</span>
                            <p class="font-semibold text-lg">{{ $prestamo->numero_prestamo }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Estado</span>
                            <p>
                                @php
                                    $colorEstado = match($prestamo->estado) {
                                        'activo' => 'green',
                                        'pendiente' => 'yellow',
                                        'en_mora' => 'red',
                                        'pagado' => 'blue',
                                        default => 'gray'
                                    };
                                @endphp
                                <span class="px-3 py-1 text-sm font-medium rounded-full bg-{{ $colorEstado }}-100 text-{{ $colorEstado }}-800">
                                    {{ ucfirst($prestamo->estado) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Fecha de Inicio</span>
                            <p class="font-semibold">{{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Monto Prestado</span>
                            <p class="font-semibold text-lg text-blue-600">{{ money_symbol($prestamo->monto_prestado) }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Saldo Pendiente</span>
                            <p class="font-semibold text-lg text-red-600">{{ money_symbol($prestamo->saldo_pendiente) }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Total a Pagar</span>
                            <p class="font-semibold text-lg">{{ money_symbol($prestamo->total_pagar) }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Tasa de Interés</span>
                            <p class="font-semibold">{{ $prestamo->tasa_interes }}%</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Plazo</span>
                            <p class="font-semibold">{{ $prestamo->plazo_meses }} meses</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Frecuencia de Pago</span>
                            <p class="font-semibold">{{ ucfirst($prestamo->frecuencia_pago) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Progreso del Préstamo --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Progreso del Préstamo</h3>
                    @php
                        $porcentajePagado = $prestamo->total_pagar > 0
                            ? (($prestamo->total_pagar - $prestamo->saldo_pendiente) / $prestamo->total_pagar) * 100
                            : 0;
                    @endphp
                    <div class="w-full bg-gray-200 rounded-full h-6 mb-2">
                        <div class="bg-green-600 h-6 rounded-full flex items-center justify-center text-white text-xs font-medium"
                            style="width: {{ percentage($porcentajePagado) }}">
                            {{ percentage($porcentajePagado) }}
                        </div>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>{{ money_symbol($prestamo->total_pagar - $prestamo->saldo_pendiente) }} pagado</span>
                        <span>{{ money_symbol($prestamo->saldo_pendiente) }} pendiente</span>
                    </div>
                </div>
            </div>

            {{-- Tabla de Amortización --}}
            @if($tablaAmortizacion && count($tablaAmortizacion) > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold">Tabla de Amortización</h3>
                    <p class="text-sm text-gray-600 mt-1">Detalle de tus cuotas y pagos</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3">Cuota</th>
                                <th scope="col" class="px-4 py-3">Fecha Vencimiento</th>
                                <th scope="col" class="px-4 py-3">Cuota Total</th>
                                <th scope="col" class="px-4 py-3">Capital</th>
                                <th scope="col" class="px-4 py-3">Interés</th>
                                <th scope="col" class="px-4 py-3">Saldo</th>
                                <th scope="col" class="px-4 py-3">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tablaAmortizacion as $cuota)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-4 py-3 font-medium text-gray-900">
                                        #{{ $cuota['numero_cuota'] }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ \Carbon\Carbon::parse($cuota['fecha_vencimiento'])->format('d/m/Y') }}
                                    </td>
                                    <td class="px-4 py-3 font-semibold">
                                        {{ money_symbol($cuota['cuota']) }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ money_symbol($cuota['capital']) }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ money_symbol($cuota['interes']) }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ money_symbol($cuota['saldo']) }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $colorEstado = match($cuota['estado']) {
                                                'pagada' => 'green',
                                                'pendiente' => 'yellow',
                                                'vencida' => 'red',
                                                default => 'gray'
                                            };
                                        @endphp
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-{{ $colorEstado }}-100 text-{{ $colorEstado }}-800">
                                            {{ ucfirst($cuota['estado']) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <td colspan="2" class="px-4 py-3 font-bold">TOTALES</td>
                                <td class="px-4 py-3 font-bold">
                                    {{ money_symbol(collect($tablaAmortizacion)->sum('cuota')) }}
                                </td>
                                <td class="px-4 py-3 font-bold">
                                    {{ money_symbol(collect($tablaAmortizacion)->sum('capital')) }}
                                </td>
                                <td class="px-4 py-3 font-bold">
                                    {{ money_symbol(collect($tablaAmortizacion)->sum('interes')) }}
                                </td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            @endif

            {{-- Historial de Pagos / Comprobantes --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold">Historial de Comprobantes</h3>
                </div>
                <div class="p-6">
                    @if($prestamo->comprobantes->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Número</th>
                                        <th scope="col" class="px-6 py-3">Fecha Pago</th>
                                        <th scope="col" class="px-6 py-3">Monto</th>
                                        <th scope="col" class="px-6 py-3">Estado</th>
                                        <th scope="col" class="px-6 py-3">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($prestamo->comprobantes()->orderBy('created_at', 'desc')->get() as $comprobante)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="px-6 py-4 font-medium text-gray-900">
                                                {{ $comprobante->numero_comprobante }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ \Carbon\Carbon::parse($comprobante->fecha_pago)->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ money_symbol($comprobante->monto_pagado) }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @php
                                                    $colorEstado = match($comprobante->estado) {
                                                        'pendiente' => 'yellow',
                                                        'aprobado' => 'green',
                                                        'rechazado' => 'red',
                                                        default => 'gray'
                                                    };
                                                @endphp
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-{{ $colorEstado }}-100 text-{{ $colorEstado }}-800">
                                                    {{ ucfirst($comprobante->estado) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <a href="{{ route('portal.comprobante', $comprobante->id) }}" class="text-blue-600 hover:text-blue-900">
                                                    Ver Detalle
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No hay comprobantes registrados para este préstamo.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
