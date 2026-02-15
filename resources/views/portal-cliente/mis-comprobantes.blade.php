<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis Comprobantes de Pago
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Navegación del Portal --}}
            <div class="mb-6 bg-white shadow-sm sm:rounded-lg">
                <div class="flex space-x-4 px-6 py-3 overflow-x-auto">
                    <a href="{{ route('portal.dashboard') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('portal.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Inicio
                    </a>
                    <a href="{{ route('portal.mis-comprobantes') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('portal.mis-comprobantes') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Mis Comprobantes
                    </a>
                    <a href="{{ route('portal.mis-avances') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('portal.mis-avances') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Avance del Proyecto
                    </a>
                </div>
            </div>

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
                                                {{ money_symbol($comprobante->monto_pagado) }}
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
                                Ver mis ventas
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
