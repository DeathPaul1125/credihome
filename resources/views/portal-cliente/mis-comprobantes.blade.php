<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis Comprobantes de Pago
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Historial de Comprobantes</h3>
                        <a href="{{ route('portal.dashboard') }}" class="text-blue-600 hover:text-blue-900 text-sm">
                            ← Volver al Inicio
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
                                        <th scope="col" class="px-6 py-3">Fecha Pago</th>
                                        <th scope="col" class="px-6 py-3">Método</th>
                                        <th scope="col" class="px-6 py-3">Subido</th>
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
                                                <a href="{{ route('portal.prestamo', $comprobante->prestamo_id) }}" class="text-blue-600 hover:underline">
                                                    {{ $comprobante->prestamo->numero_prestamo }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4">
                                                Q {{ number_format($comprobante->monto_pagado, 2) }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ \Carbon\Carbon::parse($comprobante->fecha_pago)->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $comprobante->metodo_pago ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $comprobante->created_at->format('d/m/Y') }}
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

                        {{-- Paginación --}}
                        @if($comprobantes->hasPages())
                            <div class="mt-4">
                                {{ $comprobantes->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 mb-4">No has subido ningún comprobante aún.</p>
                            <a href="{{ route('portal.dashboard') }}" class="text-blue-600 hover:text-blue-900">
                                Ver mis préstamos
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
