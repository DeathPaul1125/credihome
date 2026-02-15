<x-flowbite-layout>
    <div class="mb-6 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <a href="{{ route('contratos.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $contrato->numero_contrato }}</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $contrato->titulo }}</p>
            </div>
        </div>
        <div class="flex gap-2">
            <button onclick="window.print()" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-4 py-2.5">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Imprimir
            </button>
            <a href="{{ route('contratos.edit', $contrato) }}" class="text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-4 py-2.5">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Editar
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Sidebar izquierdo - Info del contrato -->
        <div class="lg:col-span-1 space-y-4">
            <!-- Estado -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
                <div class="text-center">
                    @php
                        $colors = ['borrador' => 'yellow', 'activo' => 'green', 'finalizado' => 'blue', 'cancelado' => 'red'];
                        $color = $colors[$contrato->estado] ?? 'gray';
                    @endphp
                    <span class="bg-{{ $color }}-100 text-{{ $color }}-800 text-sm font-semibold px-4 py-1.5 rounded-full dark:bg-{{ $color }}-900 dark:text-{{ $color }}-300">
                        {{ ucfirst($contrato->estado) }}
                    </span>
                    @if($contrato->monto_contrato)
                        <p class="mt-3 text-2xl font-bold text-gray-900 dark:text-white">Q{{ number_format($contrato->monto_contrato, 2) }}</p>
                        <p class="text-xs text-gray-500">Monto del contrato</p>
                    @endif
                </div>
            </div>

            <!-- Cliente -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-3">Cliente</h3>
                <a href="{{ route('clientes.show', $contrato->cliente_id) }}" class="text-blue-600 hover:underline font-medium">
                    {{ $contrato->cliente->nombre_completo }}
                </a>
                @if($contrato->cliente->telefono)
                    <p class="text-xs text-gray-500 mt-1">Tel: {{ $contrato->cliente->telefono }}</p>
                @endif
            </div>

            <!-- Contratista -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-3">Contratista</h3>
                <a href="{{ route('contratistas.show', $contrato->contratista_id) }}" class="text-blue-600 hover:underline font-medium">
                    {{ $contrato->contratista->nombre_completo }}
                </a>
                @if($contrato->contratista->nombre_empresa)
                    <p class="text-xs text-gray-500 mt-1">{{ $contrato->contratista->nombre_empresa }}</p>
                @endif
                @if($contrato->contratista->telefono1)
                    <p class="text-xs text-gray-500">Tel: {{ $contrato->contratista->telefono1 }}</p>
                @endif
            </div>

            <!-- Venta -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-3">Venta Asociada</h3>
                <a href="{{ route('prestamos.show', $contrato->prestamo_id) }}" class="text-blue-600 hover:underline font-medium">
                    {{ $contrato->prestamo->numero_prestamo }}
                </a>
                <p class="text-xs text-gray-500 mt-1">Monto: Q{{ number_format($contrato->prestamo->monto_prestado, 2) }}</p>
                <p class="text-xs text-gray-500">Saldo: Q{{ number_format($contrato->prestamo->saldo_pendiente, 2) }}</p>
            </div>

            <!-- Fechas -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-3">Fechas</h3>
                <div class="space-y-2 text-sm">
                    <div>
                        <span class="text-gray-500">Contrato:</span>
                        <span class="font-medium">{{ $contrato->fecha_contrato->format('d/m/Y') }}</span>
                    </div>
                    @if($contrato->fecha_inicio)
                        <div>
                            <span class="text-gray-500">Inicio:</span>
                            <span class="font-medium">{{ $contrato->fecha_inicio->format('d/m/Y') }}</span>
                        </div>
                    @endif
                    @if($contrato->fecha_fin)
                        <div>
                            <span class="text-gray-500">Fin:</span>
                            <span class="font-medium">{{ $contrato->fecha_fin->format('d/m/Y') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Creado por -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-3">Información</h3>
                <div class="space-y-1 text-xs text-gray-500">
                    @if($contrato->creador)
                        <p>Creado por: {{ $contrato->creador->name }}</p>
                    @endif
                    <p>Creado: {{ $contrato->created_at->format('d/m/Y H:i') }}</p>
                    <p>Actualizado: {{ $contrato->updated_at->format('d/m/Y H:i') }}</p>
                </div>
                @if($contrato->notas)
                    <div class="mt-3 p-2 bg-yellow-50 dark:bg-yellow-900/20 rounded text-xs">
                        <p class="font-medium text-yellow-800 dark:text-yellow-300">Notas:</p>
                        <p class="text-yellow-700 dark:text-yellow-400">{{ $contrato->notas }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Contenido del Contrato -->
        <div class="lg:col-span-3">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="border-b border-gray-200 dark:border-gray-700 p-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Contenido del Contrato</h2>
                </div>
                <div class="p-8 print:p-4">
                    <div class="prose prose-sm max-w-none dark:prose-invert contrato-contenido">
                        {!! $contrato->contenido !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .contrato-contenido { font-family: Arial, sans-serif; line-height: 1.6; }
        .contrato-contenido h1 { font-size: 1.5em; margin-bottom: 0.5em; }
        .contrato-contenido h2 { font-size: 1.2em; margin-top: 1.5em; margin-bottom: 0.5em; }
        .contrato-contenido table { width: 100%; border-collapse: collapse; }
        .contrato-contenido td { padding: 8px; vertical-align: top; }
        .contrato-contenido ul { padding-left: 1.5em; }
        .contrato-contenido li { margin-bottom: 0.3em; }

        @media print {
            nav, aside, .no-print, header, footer, button, a[href*="edit"] { display: none !important; }
            .lg\:col-span-1 { display: none !important; }
            .lg\:col-span-3 { grid-column: span 4 !important; }
            body { background: white !important; }
            .shadow { box-shadow: none !important; }
        }
    </style>
</x-flowbite-layout>
