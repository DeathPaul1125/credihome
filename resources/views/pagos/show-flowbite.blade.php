<x-flowbite-layout>
    <!-- Header -->
    <div class="mb-6">
                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-2">
                    <a href="{{ route('pagos.index') }}" class="hover:text-blue-600">Pagos</a>
                    <i class="fas fa-chevron-right mx-2 text-xs"></i>
                    <span>Detalle del Pago</span>
                </div>
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detalle del Pago #{{ $pago->id }}</h1>
                    <div class="flex gap-2">
                        <a href="{{ route('pagos.index') }}" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            <i class="fas fa-arrow-left mr-2"></i>Volver
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Información del Pago -->
                <div class="lg:col-span-2">
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                                <i class="fas fa-money-bill-wave text-blue-600 mr-2"></i>Información del Pago
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Número de Recibo</label>
                                    <p class="text-base font-semibold text-gray-900 dark:text-white">{{ $pago->numero_recibo ?? 'N/A' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Estado</label>
                                    <div>
                                        @switch($pago->estado)
                                            @case('completado')
                                                <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded dark:bg-green-900 dark:text-green-300">
                                                    <i class="fas fa-check-circle mr-1"></i>Completado
                                                </span>
                                                @break
                                            @case('pendiente')
                                                <span class="bg-yellow-100 text-yellow-800 text-sm font-medium px-3 py-1 rounded dark:bg-yellow-900 dark:text-yellow-300">
                                                    <i class="fas fa-clock mr-1"></i>Pendiente
                                                </span>
                                                @break
                                            @case('rechazado')
                                                <span class="bg-red-100 text-red-800 text-sm font-medium px-3 py-1 rounded dark:bg-red-900 dark:text-red-300">
                                                    <i class="fas fa-times-circle mr-1"></i>Rechazado
                                                </span>
                                                @break
                                        @endswitch
                                    </div>
                                </div>

                                <div class="md:col-span-2 bg-blue-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Monto Pagado</label>
                                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">Q{{ number_format($pago->monto_pagado, 2) }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Fecha de Pago</label>
                                    <p class="text-base text-gray-900 dark:text-white">
                                        <i class="fas fa-calendar mr-2 text-gray-400"></i>
                                        {{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Método de Pago</label>
                                    <p class="text-base text-gray-900 dark:text-white">
                                        @switch($pago->metodo_pago)
                                            @case('efectivo')
                                                <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-green-800 bg-green-100 rounded dark:bg-green-900 dark:text-green-300">
                                                    <i class="fas fa-money-bill-wave mr-2"></i>Efectivo
                                                </span>
                                                @break
                                            @case('transferencia_bancaria')
                                                <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-blue-800 bg-blue-100 rounded dark:bg-blue-900 dark:text-blue-300">
                                                    <i class="fas fa-exchange-alt mr-2"></i>Transferencia Bancaria
                                                </span>
                                                @break
                                            @case('deposito_bancario')
                                                <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-purple-800 bg-purple-100 rounded dark:bg-purple-900 dark:text-purple-300">
                                                    <i class="fas fa-university mr-2"></i>Depósito Bancario
                                                </span>
                                                @break
                                            @case('cheque')
                                                <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-yellow-800 bg-yellow-100 rounded dark:bg-yellow-900 dark:text-yellow-300">
                                                    <i class="fas fa-money-check mr-2"></i>Cheque
                                                </span>
                                                @break
                                            @default
                                                <span class="text-gray-600">{{ $pago->metodo_pago }}</span>
                                        @endswitch
                                    </p>
                                </div>

                                @if($pago->notas)
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Notas</label>
                                    <p class="text-base text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">{{ $pago->notas }}</p>
                                </div>
                                @endif

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Fecha de Registro</label>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $pago->created_at->format('d/m/Y H:i') }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Última Actualización</label>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $pago->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información del Préstamo y Cliente -->
                <div class="space-y-6">
                    <!-- Información del Préstamo -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                                <i class="fas fa-hand-holding-usd text-green-600 mr-2"></i>Préstamo
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">ID del Préstamo</label>
                                    <a href="{{ route('prestamos.show', $pago->prestamo->id) }}" class="text-blue-600 hover:underline dark:text-blue-400 font-semibold">
                                        Préstamo #{{ $pago->prestamo->id }}
                                    </a>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Monto del Préstamo</label>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white">Q{{ number_format($pago->prestamo->monto_prestamo, 2) }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Saldo Pendiente</label>
                                    <p class="text-lg font-bold text-orange-600 dark:text-orange-400">Q{{ number_format($pago->prestamo->saldo_pendiente, 2) }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Estado del Préstamo</label>
                                    <span class="inline-block px-2 py-1 text-xs font-medium rounded
                                        @if($pago->prestamo->estado == 'activo') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                        @elseif($pago->prestamo->estado == 'completado') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                        {{ ucfirst($pago->prestamo->estado) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información del Cliente -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                                <i class="fas fa-user text-purple-600 mr-2"></i>Cliente
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Nombre</label>
                                    <a href="{{ route('clientes.show', $pago->prestamo->cliente->id) }}" class="text-blue-600 hover:underline dark:text-blue-400 font-semibold">
                                        {{ $pago->prestamo->cliente->nombre }}
                                    </a>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">DPI</label>
                                    <p class="text-base text-gray-900 dark:text-white">{{ $pago->prestamo->cliente->dpi }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Teléfono</label>
                                    <p class="text-base text-gray-900 dark:text-white">
                                        <i class="fas fa-phone mr-2 text-gray-400"></i>
                                        {{ $pago->prestamo->cliente->telefono }}
                                    </p>
                                </div>

                                @if($pago->prestamo->cliente->email)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Email</label>
                                    <p class="text-base text-gray-900 dark:text-white break-all">
                                        <i class="fas fa-envelope mr-2 text-gray-400"></i>
                                        {{ $pago->prestamo->cliente->email }}
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Historial de Auditoría -->
            @if($activityLogs->count() > 0)
            <div class="mt-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                        <i class="fas fa-history text-blue-600 mr-2"></i>Historial de Cambios
                    </h2>

                    <div class="relative">
                        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700"></div>

                        <div class="space-y-4">
@foreach($activityLogs as $log)
                            <div class="relative pl-10">
                                <div class="absolute left-0 top-0 w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                    @if(str_contains(strtolower($log->description), 'creado'))
                                        <i class="fas fa-plus text-blue-600 dark:text-blue-400 text-sm"></i>
                                    @elseif(str_contains(strtolower($log->description), 'editado'))
                                        <i class="fas fa-edit text-yellow-600 dark:text-yellow-400 text-sm"></i>
                                    @elseif(str_contains(strtolower($log->description), 'eliminado'))
                                        <i class="fas fa-trash text-red-600 dark:text-red-400 text-sm"></i>
                                    @else
                                        <i class="fas fa-circle text-gray-600 dark:text-gray-400 text-xs"></i>
                                    @endif
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="font-semibold text-gray-900 dark:text-white">{{ $log->description }}</h3>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $log->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                        Por: <span class="font-medium">{{ $log->causer->name ?? 'Sistema' }}</span>
                                        <span class="text-gray-400">•</span>
                                        {{ $log->created_at->format('d/m/Y H:i:s') }}
                                    </p>

                                    @if($log->properties && count($log->properties) > 0)
                                    <div class="mt-2 text-sm">
                                        @if(isset($log->properties['antes']) && isset($log->properties['despues']))
                                            <div class="bg-white dark:bg-gray-800 p-3 rounded">
                                                <p class="font-medium text-gray-700 dark:text-gray-300 mb-2">Cambios realizados:</p>
                                                @foreach($log->properties['despues'] as $campo => $valor)
                                                    @if($log->properties['antes'][$campo] != $valor)
                                                    <div class="flex items-center gap-2 text-xs mb-1">
                                                        <span class="text-gray-600 dark:text-gray-400">{{ ucfirst($campo) }}:</span>
                                                        <span class="text-red-600 line-through">{{ $log->properties['antes'][$campo] }}</span>
                                                        <i class="fas fa-arrow-right text-gray-400"></i>
                                                        <span class="text-green-600 font-medium">{{ $valor }}</span>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-gray-600 dark:text-gray-400">
                                                @foreach($log->properties as $key => $value)
                                                    @if(!is_array($value))
                                                    <span class="inline-block mr-3">
                                                        <strong>{{ ucfirst($key) }}:</strong> {{ $value }}
                                                    </span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
</x-flowbite-layout>
