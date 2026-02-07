<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Comprobante {{ $comprobante->numero_comprobante }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Detalles del Comprobante</h3>
                        <a href="{{ route('portal.mis-comprobantes') }}" class="text-blue-600 hover:text-blue-900 text-sm">
                            ← Volver a Mis Comprobantes
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Información --}}
                        <div>
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Número de Comprobante</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $comprobante->numero_comprobante }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Préstamo</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <a href="{{ route('portal.prestamo', $comprobante->prestamo_id) }}" class="text-blue-600 hover:underline">
                                            {{ $comprobante->prestamo->numero_prestamo }}
                                        </a>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Monto Pagado</dt>
                                    <dd class="mt-1 text-lg font-bold text-gray-900">Q {{ number_format($comprobante->monto_pagado, 2) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Fecha de Pago</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($comprobante->fecha_pago)->format('d/m/Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Método de Pago</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $comprobante->metodo_pago ?? 'No especificado' }}</dd>
                                </div>
                                @if($comprobante->referencia_pago)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Referencia / Boleta</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $comprobante->referencia_pago }}</dd>
                                </div>
                                @endif
                                @if($comprobante->notas)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Mis Notas</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $comprobante->notas }}</dd>
                                </div>
                                @endif
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Estado</dt>
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
                                    <dt class="text-sm font-medium text-gray-500">Subido el</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $comprobante->created_at->format('d/m/Y H:i') }}</dd>
                                </div>
                                @if($comprobante->isAprobado())
                                <div class="bg-green-50 p-4 rounded-lg">
                                    <dt class="text-sm font-medium text-green-700">✓ Aprobado</dt>
                                    <dd class="mt-1 text-sm text-green-900">
                                        Tu pago fue aprobado el {{ $comprobante->fecha_validacion->format('d/m/Y') }}
                                    </dd>
                                    @if($comprobante->notas_validacion)
                                        <dd class="mt-2 text-xs text-green-800">{{ $comprobante->notas_validacion }}</dd>
                                    @endif
                                </div>
                                @endif
                                @if($comprobante->isRechazado())
                                <div class="bg-red-50 p-4 rounded-lg">
                                    <dt class="text-sm font-medium text-red-700">✗ Rechazado</dt>
                                    <dd class="mt-1 text-sm text-red-900">
                                        Tu comprobante fue rechazado el {{ $comprobante->fecha_validacion->format('d/m/Y') }}
                                    </dd>
                                    @if($comprobante->motivo_rechazo)
                                        <dd class="mt-2 text-sm text-red-800">
                                            <strong>Motivo:</strong> {{ $comprobante->motivo_rechazo }}
                                        </dd>
                                    @endif
                                </div>
                                @endif
                            </dl>
                        </div>

                        {{-- Vista Previa --}}
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Comprobante Subido</h4>
                            @php
                                $extension = pathinfo($comprobante->archivo_comprobante, PATHINFO_EXTENSION);
                            @endphp

                            @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                                <img src="{{ Storage::url($comprobante->archivo_comprobante) }}"
                                    alt="Comprobante"
                                    class="w-full rounded-lg border border-gray-300">
                            @elseif(strtolower($extension) === 'pdf')
                                <div class="text-center py-8 border border-gray-300 rounded-lg">
                                    <svg class="mx-auto h-16 w-16 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500">Documento PDF</p>
                                </div>
                            @endif

                            <div class="mt-4">
                                <a href="{{ Storage::url($comprobante->archivo_comprobante) }}"
                                    download
                                    class="w-full text-center block bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg text-sm px-5 py-2.5">
                                    Descargar Archivo
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Información Adicional --}}
            @if($comprobante->isPendiente())
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <h4 class="font-semibold text-yellow-900 mb-2">⏳ En Proceso de Validación</h4>
                <p class="text-sm text-yellow-800">
                    Tu comprobante está siendo revisado por nuestro equipo. Te notificaremos cuando sea aprobado o si necesitamos más información.
                </p>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
