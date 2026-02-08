<x-flowbite-layout>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Comprobante {{ $comprobante->numero_comprobante }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Validación de comprobante de pago</p>
            </div>
            <div>
                <a href="{{ route('admin.comprobantes.index') }}"
                    class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
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

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        {{-- Información del Comprobante --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Información del Comprobante</h2>
            </div>
            <div class="p-6">
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Cliente</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $comprobante->cliente->nombre_completo }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Préstamo</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                            <a href="{{ route('prestamos.show', $comprobante->prestamo_id) }}" class="text-blue-600 hover:underline">
                                {{ $comprobante->prestamo->numero_prestamo }}
                            </a>
                        </dd>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto Pagado</dt>
                            <dd class="mt-1 text-lg font-bold text-gray-900 dark:text-white">{{ money_symbol($comprobante->monto_pagado) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Pago</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($comprobante->fecha_pago)->format('d/m/Y') }}</dd>
                        </div>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Método de Pago</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $comprobante->metodo_pago ?? 'No especificado' }}</dd>
                    </div>
                    @if($comprobante->referencia_pago)
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Referencia / Boleta</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $comprobante->referencia_pago }}</dd>
                    </div>
                    @endif
                    @if($comprobante->notas)
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Notas del Cliente</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $comprobante->notas }}</dd>
                    </div>
                    @endif
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado</dt>
                        <dd class="mt-1">
                            @php
                                $colorEstado = match($comprobante->estado) {
                                    'pendiente' => 'yellow',
                                    'aprobado' => 'green',
                                    'rechazado' => 'red',
                                    default => 'gray'
                                };
                            @endphp
                            <span class="px-3 py-1 text-sm font-medium rounded-full bg-{{ $colorEstado }}-100 text-{{ $colorEstado }}-800">
                                {{ ucfirst($comprobante->estado) }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Subido el</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $comprobante->created_at->format('d/m/Y H:i') }}</dd>
                    </div>
                    @if($comprobante->validado_por)
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Validado por</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $comprobante->validador->name }} el {{ $comprobante->fecha_validacion->format('d/m/Y H:i') }}
                        </dd>
                    </div>
                    @endif
                    @if($comprobante->motivo_rechazo)
                    <div>
                        <dt class="text-sm font-medium text-red-500">Motivo de Rechazo</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $comprobante->motivo_rechazo }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>

        {{-- Vista Previa del Comprobante --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Vista Previa del Comprobante</h2>
            </div>
            <div class="p-6">
                @php
                    $extension = pathinfo($comprobante->archivo_comprobante, PATHINFO_EXTENSION);
                @endphp

                @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                    <img src="{{ Storage::url($comprobante->archivo_comprobante) }}"
                        alt="Comprobante"
                        class="w-full rounded-lg border border-gray-300">
                @elseif(strtolower($extension) === 'pdf')
                    <div class="text-center py-8">
                        <svg class="mx-auto h-24 w-24 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                        </svg>
                        <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">Documento PDF</p>
                        <a href="{{ Storage::url($comprobante->archivo_comprobante) }}"
                            target="_blank"
                            class="mt-4 inline-block text-white bg-red-600 hover:bg-red-700 font-medium rounded-lg text-sm px-5 py-2.5">
                            Ver PDF
                        </a>
                    </div>
                @endif

                <div class="mt-4">
                    <a href="{{ Storage::url($comprobante->archivo_comprobante) }}"
                        download
                        class="w-full text-center block text-white bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        Descargar Archivo
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Formularios de Aprobación/Rechazo --}}
    @if($comprobante->isPendiente())
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-4">
            {{-- Aprobar --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-green-50 dark:bg-green-900/20">
                    <h2 class="text-xl font-semibold text-green-900 dark:text-white">✓ Aprobar Comprobante</h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.comprobantes.aprobar', $comprobante->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="monto_pagado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Monto a Registrar <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">Q</span>
                                <input type="number" step="0.01" name="monto_pagado" id="monto_pagado"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-8 p-2.5"
                                    value="{{ $comprobante->monto_pagado }}" required>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Puedes ajustar el monto si es necesario</p>
                        </div>

                        <div class="mb-4">
                            <label for="fecha_pago" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Fecha de Pago <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="fecha_pago" id="fecha_pago"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                                value="{{ \Carbon\Carbon::parse($comprobante->fecha_pago)->format('Y-m-d') }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="notas_aprobacion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Notas de Validación
                            </label>
                            <textarea name="notas" id="notas_aprobacion" rows="3"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                                placeholder="Notas adicionales sobre la validación..."></textarea>
                        </div>

                        <button type="submit"
                            class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5">
                            Aprobar y Registrar Pago
                        </button>
                    </form>
                </div>
            </div>

            {{-- Rechazar --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-red-50 dark:bg-red-900/20">
                    <h2 class="text-xl font-semibold text-red-900 dark:text-white">✗ Rechazar Comprobante</h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.comprobantes.rechazar', $comprobante->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="motivo_rechazo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Motivo de Rechazo <span class="text-red-500">*</span>
                            </label>
                            <textarea name="motivo_rechazo" id="motivo_rechazo" rows="5"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5"
                                placeholder="Explica al cliente por qué se rechaza el comprobante..."
                                required></textarea>
                            <p class="mt-1 text-xs text-gray-500">Este mensaje será visible para el cliente</p>
                        </div>

                        <button type="submit"
                            class="w-full text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5">
                            Rechazar Comprobante
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</x-flowbite-layout>
