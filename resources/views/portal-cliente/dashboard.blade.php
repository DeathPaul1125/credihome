<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Portal del Cliente - Bienvenido, {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Estadísticas --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 uppercase">Total Ventas</div>
                        <div class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['total_prestamos'] }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 uppercase">Ventas Activas</div>
                        <div class="mt-2 text-3xl font-bold text-green-600">{{ $stats['prestamos_activos'] }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 uppercase">Total Adeudado</div>
                        <div class="mt-2 text-3xl font-bold text-red-600">{{ money_symbol($stats['total_adeudado']) }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 uppercase">Comprobantes Pendientes</div>
                        <div class="mt-2 text-3xl font-bold text-yellow-600">{{ $stats['comprobantes_pendientes'] }}</div>
                    </div>
                </div>
            </div>

            {{-- Mis Préstamos --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Mis Préstamos</h3>

                    @if($prestamos->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Número</th>
                                        <th scope="col" class="px-6 py-3">Monto Prestado</th>
                                        <th scope="col" class="px-6 py-3">Saldo Pendiente</th>
                                        <th scope="col" class="px-6 py-3">Estado</th>
                                        <th scope="col" class="px-6 py-3">Próximo Pago</th>
                                        <th scope="col" class="px-6 py-3">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($prestamos as $prestamo)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="px-6 py-4 font-medium text-gray-900">
                                                {{ $prestamo->numero_prestamo }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ money_symbol($prestamo->monto_prestado) }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ money_symbol($prestamo->saldo_pendiente) }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @php
                                                    $colorEstado = match($prestamo->estado) {
                                                        'activo' => 'green',
                                                        'pendiente' => 'yellow',
                                                        'en_mora' => 'red',
                                                        'pagado' => 'blue',
                                                        default => 'gray'
                                                    };
                                                @endphp
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-{{ $colorEstado }}-100 text-{{ $colorEstado }}-800">
                                                    {{ ucfirst($prestamo->estado) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($prestamo->proximo_pago)
                                                    {{ \Carbon\Carbon::parse($prestamo->proximo_pago)->format('d/m/Y') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <a href="{{ route('portal.prestamo', $prestamo->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                                    Ver Detalle
                                                </a>
                                                @if(in_array($prestamo->estado, ['activo', 'en_mora']))
                                                    <a href="{{ route('portal.subir-comprobante', $prestamo->id) }}" class="text-green-600 hover:text-green-900">
                                                        Subir Comprobante
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">No tienes ventas registradas.</p>
                    @endif
                </div>
            </div>

            {{-- Comprobantes Recientes --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Comprobantes Recientes</h3>
                        <a href="{{ route('portal.mis-comprobantes') }}" class="text-blue-600 hover:text-blue-900 text-sm">
                            Ver Todos
                        </a>
                    </div>

                    @if($comprobantes->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Número</th>
                                        <th scope="col" class="px-6 py-3">Préstamo</th>
                                        <th scope="col" class="px-6 py-3">Monto</th>
                                        <th scope="col" class="px-6 py-3">Fecha</th>
                                        <th scope="col" class="px-6 py-3">Estado</th>
                                        <th scope="col" class="px-6 py-3">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($comprobantes as $comprobante)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="px-6 py-4 font-medium text-gray-900">
                                                {{ $comprobante->numero_comprobante }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $comprobante->prestamo->numero_prestamo }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ money_symbol($comprobante->monto_pagado) }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ \Carbon\Carbon::parse($comprobante->fecha_pago)->format('d/m/Y') }}
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
                                                    Ver
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">No hay comprobantes registrados.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
