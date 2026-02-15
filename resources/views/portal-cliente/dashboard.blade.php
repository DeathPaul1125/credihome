<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Portal del Cliente - Bienvenido, {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
