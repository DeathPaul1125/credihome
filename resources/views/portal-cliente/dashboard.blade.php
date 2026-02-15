<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Portal del Cliente - Bienvenido, {{ Auth::user()->name }}
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

            {{-- Información Principal --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Cuota a Pagar -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 overflow-hidden shadow-lg sm:rounded-xl">
                    <div class="p-8 text-white">
                        <div class="text-sm font-medium uppercase tracking-wide mb-2">Cuota a Pagar</div>
                        <div class="mt-2 text-4xl font-bold">{{ money_symbol($stats['cuota_a_pagar'] ?? 0) }}</div>
                        <div class="mt-2 text-blue-100 text-sm">Próximo pago</div>
                    </div>
                </div>

                <!-- Total que Resta por Pagar -->
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 overflow-hidden shadow-lg sm:rounded-xl">
                    <div class="p-8 text-white">
                        <div class="text-sm font-medium uppercase tracking-wide mb-2">Resta por Pagar</div>
                        <div class="mt-2 text-4xl font-bold">{{ money_symbol($stats['total_adeudado'] ?? 0) }}</div>
                        <div class="mt-2 text-orange-100 text-sm">Saldo pendiente</div>
                    </div>
                </div>

                <!-- Total de la Deuda -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 overflow-hidden shadow-lg sm:rounded-xl">
                    <div class="p-8 text-white">
                        <div class="text-sm font-medium uppercase tracking-wide mb-2">Total de la Deuda</div>
                        <div class="mt-2 text-4xl font-bold">{{ money_symbol($stats['total_deuda'] ?? 0) }}</div>
                        <div class="mt-2 text-purple-100 text-sm">Monto total</div>
                    </div>
                </div>
            </div>

            {{-- Mis Ventas --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Mis Ventas</h3>

                    @if($prestamos->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Número</th>
                                        <th scope="col" class="px-6 py-3">Cuota</th>
                                        <th scope="col" class="px-6 py-3">Saldo Pendiente</th>
                                        <th scope="col" class="px-6 py-3">Total Deuda</th>
                                        <th scope="col" class="px-6 py-3">Estado</th>
                                        <th scope="col" class="px-6 py-3">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($prestamos as $prestamo)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="px-6 py-4 font-medium text-gray-900">
                                                {{ $prestamo->numero_prestamo }}
                                            </td>
                                            <td class="px-6 py-4 font-semibold text-blue-600">
                                                {{ money_symbol($prestamo->monto_cuota) }}
                                            </td>
                                            <td class="px-6 py-4 font-semibold text-orange-600">
                                                {{ money_symbol($prestamo->saldo_pendiente) }}
                                            </td>
                                            <td class="px-6 py-4 font-semibold text-purple-600">
                                                {{ money_symbol($prestamo->monto_total) }}
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
                                                @if(in_array($prestamo->estado, ['activo', 'en_mora']))
                                                    <a href="{{ route('portal.subir-comprobante', $prestamo->id) }}" class="inline-flex items-center px-3 py-2 bg-green-600 text-white text-xs font-medium rounded-md hover:bg-green-700">
                                                        Pagar
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
        </div>
    </div>
</x-app-layout>
