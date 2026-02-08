{{--
    Botón de pago con Recurrente

    Uso:
    @include('components.recurrente-button', [
        'pago' => $pago,
        'text' => 'Pagar con Tarjeta',
        'size' => 'md' // sm, md, lg
    ])
--}}

@php
    $recurrente = recurrente();
    $isEnabled = $recurrente->isEnabled();
    $size = $size ?? 'md';
    $text = $text ?? 'Pagar con Recurrente';

    $sizeClasses = [
        'sm' => 'px-3 py-2 text-xs',
        'md' => 'px-5 py-2.5 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    $buttonClass = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

@if($isEnabled && isset($pago) && $pago->estado === 'pendiente')
    <form action="{{ route('recurrente.initPayment', $pago) }}" method="POST" class="inline-block">
        @csrf
        <button type="submit" class="inline-flex items-center {{ $buttonClass }} font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md dark:focus:ring-blue-800">
            <!-- Card Icon -->
            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
            </svg>
            {{ $text }}

            @if($recurrente->getMode() === 'test')
                <span class="ml-2 px-2 py-0.5 text-xs bg-yellow-400 text-yellow-900 rounded-full">TEST</span>
            @endif
        </button>
    </form>

    @if($recurrente->getMode() === 'test')
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
            <span class="inline-block w-2 h-2 bg-yellow-500 rounded-full mr-1"></span>
            Modo de prueba. Usa: 4242 4242 4242 4242
        </p>
    @endif
@elseif(!$isEnabled)
    <!-- Mensaje cuando Recurrente no está habilitado (opcional) -->
    <div class="text-xs text-gray-500 dark:text-gray-400 italic">
        Pagos en línea no disponibles
    </div>
@endif
