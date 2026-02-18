<x-flowbite-layout>
    <!-- Header -->
    <div class="mb-4">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Editar Cotización</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Modificar la cotización: {{ $cotizacion->numero_cotizacion }}</p>
            </div>

            <!-- Formulario -->
            <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-6">
                <form action="{{ route('cotizaciones.update', $cotizacion) }}" method="POST" id="cotizacionForm">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <!-- Cliente -->
                        <div>
                            <label for="cliente_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cliente <span class="text-red-600">*</span></label>
                            <select id="cliente_id" name="cliente_id" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('cliente_id') border-red-500 @enderror">
                                <option value="">Seleccione un cliente</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('cliente_id', $cotizacion->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->nombre_completo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cliente_id')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Plan de Construcción (Opcional) -->
                        <div>
                            <label for="receta_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Plan de Construcción Base (Opcional)</label>
                            <select id="receta_id" name="receta_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('receta_id') border-red-500 @enderror">
                                <option value="">Sin plan base</option>
                                @foreach($recetas as $receta)
                                    <option value="{{ $receta->id }}" {{ old('receta_id', $cotizacion->receta_id) == $receta->id ? 'selected' : '' }}>
                                        {{ $receta->nombre }} - {{ $receta->tipo_vivienda }}
                                    </option>
                                @endforeach
                            </select>
                            @error('receta_id')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fecha de Emisión -->
                        <div>
                            <label for="fecha_emision" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de Emisión <span class="text-red-600">*</span></label>
                            <input type="date" id="fecha_emision" name="fecha_emision" value="{{ old('fecha_emision', $cotizacion->fecha_emision->format('Y-m-d')) }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('fecha_emision') border-red-500 @enderror">
                            @error('fecha_emision')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fecha de Vencimiento -->
                        <div>
                            <label for="fecha_vencimiento" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de Vencimiento <span class="text-red-600">*</span></label>
                            <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" value="{{ old('fecha_vencimiento', $cotizacion->fecha_vencimiento->format('Y-m-d')) }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('fecha_vencimiento') border-red-500 @enderror">
                            @error('fecha_vencimiento')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Descuento -->
                        <div>
                            <label for="descuento" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descuento (Q)</label>
                            <input type="number" id="descuento" name="descuento" value="{{ old('descuento', $cotizacion->descuento) }}" step="0.01" min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('descuento') border-red-500 @enderror">
                            @error('descuento')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Estado -->
                        <div>
                            <label for="estado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                            <select id="estado" name="estado" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('estado') border-red-500 @enderror">
                                <option value="pendiente" {{ old('estado', $cotizacion->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="aprobada" {{ old('estado', $cotizacion->estado) == 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                                <option value="rechazada" {{ old('estado', $cotizacion->estado) == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                                <option value="vencida" {{ old('estado', $cotizacion->estado) == 'vencida' ? 'selected' : '' }}>Vencida</option>
                                <option value="convertida" {{ old('estado', $cotizacion->estado) == 'convertida' ? 'selected' : '' }}>Convertida</option>
                            </select>
                            @error('estado')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Tipo de Venta -->
                    <div class="mb-6">
                        <label for="tipo_venta" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de Venta <span class="text-red-600">*</span></label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative flex items-center p-4 cursor-pointer bg-gray-50 dark:bg-gray-700 border-2 rounded-lg transition-all hover:shadow-md tipo-venta-option" data-tipo="contado">
                                <input type="radio" id="tipo_venta_contado" name="tipo_venta" value="contado" {{ old('tipo_venta', $cotizacion->tipo_venta ?? 'credito') == 'contado' ? 'checked' : '' }} class="hidden tipo-venta-radio">
                                <div class="flex items-center gap-3 w-full">
                                    <div class="flex-shrink-0">
                                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="flex-grow">
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white">Contado</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Pago único sin intereses</p>
                                    </div>
                                    <div class="radio-indicator hidden">
                                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                            </label>
                            <label class="relative flex items-center p-4 cursor-pointer bg-gray-50 dark:bg-gray-700 border-2 rounded-lg transition-all hover:shadow-md tipo-venta-option" data-tipo="credito">
                                <input type="radio" id="tipo_venta_credito" name="tipo_venta" value="credito" {{ old('tipo_venta', $cotizacion->tipo_venta ?? 'credito') == 'credito' ? 'checked' : '' }} class="hidden tipo-venta-radio">
                                <div class="flex items-center gap-3 w-full">
                                    <div class="flex-shrink-0">
                                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="flex-grow">
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white">Crédito</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Pago en cuotas con intereses</p>
                                    </div>
                                    <div class="radio-indicator hidden">
                                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('tipo_venta')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sección de Financiamiento -->
                    <div id="seccionFinanciamiento" class="mb-6 p-4 bg-blue-50 dark:bg-gray-700 rounded-lg border border-blue-200 dark:border-gray-600" style="{{ old('tipo_venta', $cotizacion->tipo_venta ?? 'credito') == 'contado' ? 'display: none;' : '' }}">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Opciones de Financiamiento</h3>

                        <div class="grid gap-4 md:grid-cols-4 mb-4">
                            <!-- Plazo -->
                            <div>
                                <label for="plazo_meses" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Plazo (Meses)</label>
                                <input type="number" id="plazo_meses" name="plazo_meses" value="{{ old('plazo_meses', $cotizacion->plazo_meses ?? 12) }}" min="1" max="360" step="1" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Número de cuotas mensuales</p>
                            </div>

                            <!-- Tasa de Interés Anual -->
                            <div>
                                <label for="tasa_interes_anual" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tasa de Interés Anual (%)</label>
                                <input type="number" id="tasa_interes_anual" name="tasa_interes_anual" value="{{ old('tasa_interes_anual', $cotizacion->tasa_interes_anual ?? 24) }}" min="0" max="100" step="0.01" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Tasa anual efectiva</p>
                            </div>

                            <!-- Tipo de Interés -->
                            <div>
                                <label for="tipo_interes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Plan de Cotización</label>
                                <select id="tipo_interes" name="tipo_interes" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                    <option value="cuota_fija" {{ old('tipo_interes', $cotizacion->tipo_interes ?? 'cuota_fija') == 'cuota_fija' ? 'selected' : '' }}>Nivelada</option>
                                    <option value="flat" {{ old('tipo_interes', $cotizacion->tipo_interes) == 'flat' ? 'selected' : '' }}>Flat Cuota Fija</option>
                                    <option value="sobre_saldos" {{ old('tipo_interes', $cotizacion->tipo_interes) == 'sobre_saldos' ? 'selected' : '' }}>Sobre Saldos</option>
                                </select>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Tipo de plan de pago</p>
                            </div>

                            <!-- Enganche -->
                            <div>
                                <label for="enganche" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Enganche (Q)</label>
                                <input type="number" id="enganche" name="enganche" value="{{ old('enganche', $cotizacion->enganche ?? 0) }}" min="0" step="0.01" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Pago inicial (opcional)</p>
                            </div>
                        </div>

                        <!-- Botón calcular -->
                        <div class="mb-4">
                            <button type="button" id="calcularPlanBtn" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-700 border border-transparent rounded-lg hover:bg-green-800 focus:ring-4 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z"/>
                                    <path d="M3 8a2 2 0 012-2v10h8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
                                </svg>
                                Calcular Plan de Pagos
                            </button>
                        </div>

                        <!-- Resultados de cálculo -->
                        <div id="resultadosFinanciamiento" class="mt-4 hidden">
                            <!-- Resumen Principal -->
                            <div class="bg-gray-100 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-lg p-6 mb-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Resumen del Financiamiento</p>
                                        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white" id="resumenPrincipal">
                                            Usted pagará Q 0.00 en 0 meses
                                        </h3>
                                        <p class="text-sm text-gray-700 dark:text-gray-300 mt-2" id="resumenDetalle">
                                            Con cuotas mensuales de <span class="font-semibold text-gray-900 dark:text-white" id="resumenCuota">Q 0.00</span>
                                        </p>
                                    </div>
                                    <div class="hidden md:flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Detalles del Plan -->
                            <div class="grid gap-4 md:grid-cols-4 mb-4">
                                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 p-4">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Monto a Financiar</p>
                                    <p class="text-xl font-bold text-blue-600 dark:text-blue-400" id="montoFinanciar">Q 0.00</p>
                                </div>
                                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 p-4">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Cuota Mensual</p>
                                    <p class="text-xl font-bold text-green-600 dark:text-green-400" id="cuotaMensual">Q 0.00</p>
                                </div>
                                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 p-4">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total de Intereses</p>
                                    <p class="text-xl font-bold text-yellow-600 dark:text-yellow-400" id="totalIntereses">Q 0.00</p>
                                </div>
                                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 p-4">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total a Pagar</p>
                                    <p class="text-xl font-bold text-purple-600 dark:text-purple-400" id="totalPagar">Q 0.00</p>
                                </div>
                            </div>

                            <!-- Botones de Acción -->
                            <div class="flex gap-3 mb-4">
                                <button type="button" id="verTablaBtn" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    Ver Tabla de Amortización Completa
                                </button>
                                <button type="button" id="imprimirPlanBtn" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-700 rounded-lg hover:bg-red-800 dark:bg-red-600 dark:hover:bg-red-700">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Imprimir Plan de Pagos
                                </button>
                            </div>

                            <!-- Tabla de Amortización (oculta inicialmente) -->
                            <div id="tablaAmortizacion" class="hidden overflow-x-auto">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th class="px-4 py-3">Cuota</th>
                                            <th class="px-4 py-3">Cuota Mensual</th>
                                            <th class="px-4 py-3">Capital</th>
                                            <th class="px-4 py-3">Interés</th>
                                            <th class="px-4 py-3">Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablaAmortizacionBody">
                                        <!-- Se llenará con JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Notas -->
                    <div class="mb-6">
                        <label for="notas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notas</label>
                        <textarea id="notas" name="notas" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('notas') border-red-500 @enderror">{{ old('notas', $cotizacion->notas) }}</textarea>
                        @error('notas')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Términos y Condiciones -->
                    <div class="mb-6">
                        <label for="terminos_condiciones" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Términos y Condiciones</label>
                        <textarea id="terminos_condiciones" name="terminos_condiciones" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('terminos_condiciones') border-red-500 @enderror">{{ old('terminos_condiciones', $cotizacion->terminos_condiciones) }}</textarea>
                        @error('terminos_condiciones')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Productos -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Productos</h3>
                            <button type="button" id="addProductoBtn" class="inline-flex items-center text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"/>
                                </svg>
                                Agregar Producto
                            </button>
                        </div>

                        <div id="productosContainer" class="space-y-4">
                            <!-- Los productos existentes se cargarán aquí -->
                            @foreach($cotizacion->items as $index => $item)
                            <div class="producto-row bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border">
                                <div class="grid gap-4 md:grid-cols-6 items-end">
                                    <div class="md:col-span-2">
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Producto</label>
                                        <select name="productos[{{ $index }}][producto_id]" required class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white producto-select">
                                            <option value="">Seleccione un producto</option>
                                            @foreach($productos as $producto)
                                                <option value="{{ $producto->id }}" data-precio="{{ $producto->precio_unitario }}" data-unidad="{{ $producto->unidad_medida }}" data-descripcion="{{ $producto->nombre }}" {{ $item->producto_id == $producto->id ? 'selected' : '' }}>
                                                    {{ $producto->codigo }} - {{ $producto->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cantidad</label>
                                        <input type="number" name="productos[{{ $index }}][cantidad]" value="{{ old('productos.' . $index . '.cantidad', $item->cantidad) }}" step="0.01" min="0.01" required class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white producto-cantidad">
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unidad</label>
                                        <input type="text" name="productos[{{ $index }}][unidad]" value="{{ old('productos.' . $index . '.unidad', $item->unidad) }}" readonly class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white producto-unidad">
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio Unit.</label>
                                        <input type="number" name="productos[{{ $index }}][precio_unitario]" value="{{ old('productos.' . $index . '.precio_unitario', $item->precio_unitario) }}" step="0.01" min="0" required class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white producto-precio">
                                    </div>
                                    <div class="flex gap-2">
                                        <div class="flex-1">
                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Subtotal</label>
                                            <input type="number" name="productos[{{ $index }}][subtotal]" value="{{ old('productos.' . $index . '.subtotal', $item->subtotal) }}" step="0.01" readonly class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white producto-subtotal">
                                        </div>
                                        <button type="button" class="remove-producto-btn text-red-600 hover:text-red-800 p-2">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                                    <input type="text" name="productos[{{ $index }}][descripcion]" value="{{ old('productos.' . $index . '.descripcion', $item->descripcion) }}" class="block p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white producto-descripcion">
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Subtotal:</span>
                                    <span id="subtotalDisplay" class="text-sm font-bold text-gray-900 dark:text-white">{{ money_symbol($cotizacion->subtotal ?? 0) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Descuento:</span>
                                    <span id="descuentoDisplay" class="text-sm font-bold text-green-600 dark:text-green-400">{{ money_symbol($cotizacion->descuento ?? 0) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-medium text-gray-900 dark:text-white">Total:</span>
                                    <span id="totalDisplay" class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ money_symbol($cotizacion->total ?? 0) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex gap-4">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Actualizar Cotización
                        </button>
                        <a href="{{ route('cotizaciones.show', $cotizacion) }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            Ver Cotización
                        </a>
                        <a href="{{ route('cotizaciones.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

    <!-- Template para productos -->
    <script type="text/template" id="productoTemplate">
        <div class="producto-row bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border">
            <div class="grid gap-4 md:grid-cols-6 items-end">
                <div class="md:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Producto</label>
                    <select name="productos[{index}][producto_id]" required class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white producto-select">
                        <option value="">Seleccione un producto</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}" data-precio="{{ $producto->precio_unitario }}" data-unidad="{{ $producto->unidad_medida }}" data-descripcion="{{ $producto->nombre }}">
                                {{ $producto->codigo }} - {{ $producto->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cantidad</label>
                    <input type="number" name="productos[{index}][cantidad]" step="0.01" min="0.01" required class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white producto-cantidad">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unidad</label>
                    <input type="text" name="productos[{index}][unidad]" readonly class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white producto-unidad">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio Unit.</label>
                    <input type="number" name="productos[{index}][precio_unitario]" step="0.01" min="0" required class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white producto-precio">
                </div>
                <div class="flex gap-2">
                    <div class="flex-1">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Subtotal</label>
                        <input type="number" name="productos[{index}][subtotal]" step="0.01" readonly class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white producto-subtotal">
                    </div>
                    <button type="button" class="remove-producto-btn text-red-600 hover:text-red-800 p-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="mt-3">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                <input type="text" name="productos[{index}][descripcion]" class="block p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white producto-descripcion">
            </div>
        </div>
    </script>

    <script>
        let productoIndex = {{ count($cotizacion->items) }};

        function addProducto(productoData = null) {
            const template = document.getElementById('productoTemplate').innerHTML;
            const productoHtml = template.replace(/{index}/g, productoIndex);
            const container = document.getElementById('productosContainer');
            container.insertAdjacentHTML('beforeend', productoHtml);

            // Agregar event listeners al nuevo producto
            const newProducto = container.lastElementChild;
            setupProductoListeners(newProducto);

            // Si hay datos del producto, cargarlos
            if (productoData) {
                const select = newProducto.querySelector('.producto-select');
                const cantidad = newProducto.querySelector('.producto-cantidad');
                const precio = newProducto.querySelector('.producto-precio');
                const descripcion = newProducto.querySelector('.producto-descripcion');
                const unidad = newProducto.querySelector('.producto-unidad');

                select.value = productoData.producto_id;
                cantidad.value = productoData.cantidad;
                precio.value = productoData.precio_unitario;
                descripcion.value = productoData.descripcion || productoData.producto?.nombre || '';

                if (productoData.unidad) {
                    unidad.value = productoData.unidad;
                }

                // Calcular subtotal
                calculateProductoSubtotal(cantidad, precio, newProducto.querySelector('.producto-subtotal'));
            }

            productoIndex++;
        }

        function setupProductoListeners(producto) {
            const productoSelect = producto.querySelector('.producto-select');
            const cantidadInput = producto.querySelector('.producto-cantidad');
            const precioInput = producto.querySelector('.producto-precio');
            const subtotalInput = producto.querySelector('.producto-subtotal');
            const unidadInput = producto.querySelector('.producto-unidad');
            const descripcionInput = producto.querySelector('.producto-descripcion');
            const removeBtn = producto.querySelector('.remove-producto-btn');

            productoSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const precio = selectedOption.getAttribute('data-precio') || 0;
                const unidad = selectedOption.getAttribute('data-unidad') || '';
                const descripcion = selectedOption.getAttribute('data-descripcion') || '';

                precioInput.value = precio;
                unidadInput.value = unidad;
                if (!descripcionInput.value) {
                    descripcionInput.value = descripcion;
                }
                calculateProductoSubtotal(cantidadInput, precioInput, subtotalInput);
                updateTotal();
            });

            cantidadInput.addEventListener('input', function() {
                calculateProductoSubtotal(this, precioInput, subtotalInput);
                updateTotal();
            });

            precioInput.addEventListener('input', function() {
                calculateProductoSubtotal(cantidadInput, this, subtotalInput);
                updateTotal();
            });

            removeBtn.addEventListener('click', function() {
                producto.remove();
                updateTotal();
            });
        }

        function calculateProductoSubtotal(cantidadInput, precioInput, subtotalInput) {
            const cantidad = parseFloat(cantidadInput.value) || 0;
            const precio = parseFloat(precioInput.value) || 0;
            const subtotal = cantidad * precio;
            subtotalInput.value = subtotal.toFixed(2);
        }

        function updateTotal() {
            let subtotal = 0;
            document.querySelectorAll('.producto-subtotal').forEach(function(input) {
                subtotal += parseFloat(input.value) || 0;
            });

            const descuento = parseFloat(document.getElementById('descuento').value) || 0;
            const total = subtotal - descuento;

            document.getElementById('subtotalDisplay').textContent = formatMoneySymbol(subtotal);
            document.getElementById('descuentoDisplay').textContent = formatMoneySymbol(descuento);
            document.getElementById('totalDisplay').textContent = formatMoneySymbol(total);
        }

        function loadRecetaProductos(recetaId) {
            // Limpiar productos existentes
            document.getElementById('productosContainer').innerHTML = '';

            if (!recetaId) {
                // Si no hay receta seleccionada, agregar un producto vacío
                addProducto();
                return;
            }

            // Cargar productos de la receta mediante AJAX
            fetch(`/api/recetas/${recetaId}/items`)
                .then(response => response.json())
                .then(data => {
                    if (data.items && data.items.length > 0) {
                        data.items.forEach(item => {
                            addProducto({
                                producto_id: item.producto_id,
                                cantidad: item.cantidad,
                                precio_unitario: item.precio_unitario,
                                descripcion: item.producto.nombre,
                                unidad: item.producto.unidad_medida
                            });
                        });
                        updateTotal();
                    } else {
                        alert('Esta receta no tiene productos asociados.');
                        addProducto();
                    }
                })
                .catch(error => {
                    console.error('Error cargando productos de receta:', error);
                    alert('Error al cargar los productos de la receta. Puede agregar productos manualmente con el botón "Agregar Producto".');
                });
        }

        // Manejo del tipo de venta
        document.addEventListener('DOMContentLoaded', function() {
            // Configurar listeners para productos existentes
            document.querySelectorAll('.producto-row').forEach(function(producto) {
                setupProductoListeners(producto);
            });

            // Actualizar total cuando cambia el descuento
            const descuentoInput = document.getElementById('descuento');
            if (descuentoInput) {
                descuentoInput.addEventListener('input', updateTotal);
            }

            // Calcular total inicial
            updateTotal();

            // Botón agregar producto
            const addProductoBtn = document.getElementById('addProductoBtn');
            if (addProductoBtn) {
                addProductoBtn.addEventListener('click', function() {
                    addProducto();
                });
            }

            // Cargar productos desde receta si se selecciona
            const recetaSelect = document.getElementById('receta_id');
            if (recetaSelect) {
                recetaSelect.addEventListener('change', function() {
                    const recetaId = this.value;
                    if (recetaId) {
                        loadRecetaProductos(recetaId);
                    }
                });
            }

            const tipoVentaOptions = document.querySelectorAll('.tipo-venta-option');
            const seccionFinanciamiento = document.getElementById('seccionFinanciamiento');

            // Función para actualizar el estado visual
            function updateTipoVentaUI() {
                tipoVentaOptions.forEach(option => {
                    const radio = option.querySelector('.tipo-venta-radio');
                    const indicator = option.querySelector('.radio-indicator');

                    if (radio.checked) {
                        option.classList.add('border-blue-600', 'bg-blue-50', 'dark:bg-blue-900/20');
                        option.classList.remove('border-gray-300');
                        indicator.classList.remove('hidden');

                        // Mostrar/ocultar sección de financiamiento
                        if (radio.value === 'credito') {
                            seccionFinanciamiento.style.display = 'block';
                        } else {
                            seccionFinanciamiento.style.display = 'none';
                        }
                    } else {
                        option.classList.remove('border-blue-600', 'bg-blue-50', 'dark:bg-blue-900/20');
                        option.classList.add('border-gray-300');
                        indicator.classList.add('hidden');
                    }
                });
            }

            // Event listeners para las opciones
            tipoVentaOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const radio = this.querySelector('.tipo-venta-radio');
                    radio.checked = true;
                    updateTipoVentaUI();
                });
            });

            // Inicializar el estado visual
            updateTipoVentaUI();

            // ==========================================
            // CÁLCULO DE PLAN DE PAGOS
            // ==========================================

            // Botón calcular plan de pagos
            document.getElementById('calcularPlanBtn')?.addEventListener('click', function() {
                calcularPlanPagos();
            });

            // Botón ver tabla
            document.getElementById('verTablaBtn')?.addEventListener('click', function() {
                const tabla = document.getElementById('tablaAmortizacion');
                if (tabla.classList.contains('hidden')) {
                    tabla.classList.remove('hidden');
                    this.textContent = 'Ocultar Tabla de Amortización';
                } else {
                    tabla.classList.add('hidden');
                    this.textContent = 'Ver Tabla de Amortización Completa';
                }
            });

            // Botón imprimir plan
            document.getElementById('imprimirPlanBtn')?.addEventListener('click', function() {
                imprimirPlan();
            });
        });

        function calcularPlanPagos() {
            // Obtener valores
            const totalElement = document.getElementById('totalDisplay');
            if (!totalElement) {
                console.error('No se encontró el elemento totalDisplay');
                return;
            }

            // Extraer solo números y puntos decimales del texto
            const totalText = totalElement.textContent.trim();
            const totalMatch = totalText.match(/[\d,]+\.?\d*/);
            const total = totalMatch ? parseFloat(totalMatch[0].replace(/,/g, '')) : 0;

            const enganche = parseFloat(document.getElementById('enganche').value) || 0;
            const plazo = parseInt(document.getElementById('plazo_meses').value) || 12;
            const tasaAnual = parseFloat(document.getElementById('tasa_interes_anual').value) || 0;
            const tipoInteres = document.getElementById('tipo_interes').value;

            console.log('Calculando plan:', {total, enganche, plazo, tasaAnual, tipoInteres});

            if (total <= 0) {
                alert('Debe agregar productos antes de calcular el plan de pagos.');
                return;
            }

            if (plazo <= 0) {
                alert('El plazo debe ser mayor a 0 meses.');
                return;
            }

            // Calcular monto a financiar
            const montoFinanciar = total - enganche;

            if (montoFinanciar <= 0) {
                alert('El enganche no puede ser mayor o igual al total.');
                return;
            }

            // Calcular tasa mensual
            const tasaMensual = tasaAnual / 12 / 100;

            // Calcular cuota según el tipo de interés
            let cuotaMensual;
            let totalIntereses;
            let totalPagar;

            if (tipoInteres === 'cuota_fija') {
                // Cuota Fija (Sistema Francés) - cuota constante
                if (tasaMensual === 0) {
                    cuotaMensual = montoFinanciar / plazo;
                    totalIntereses = 0;
                    totalPagar = montoFinanciar;
                } else {
                    const factor = Math.pow(1 + tasaMensual, plazo);
                    cuotaMensual = montoFinanciar * (tasaMensual * factor) / (factor - 1);
                    totalPagar = cuotaMensual * plazo;
                    totalIntereses = totalPagar - montoFinanciar;
                }
            } else if (tipoInteres === 'flat') {
                // Flat - interés sobre capital original, cuota constante
                const interesMensual = (montoFinanciar * tasaAnual / 100) / 12;
                const capitalMensual = montoFinanciar / plazo;
                cuotaMensual = capitalMensual + interesMensual;
                totalIntereses = interesMensual * plazo;
                totalPagar = montoFinanciar + totalIntereses;
            } else if (tipoInteres === 'sobre_saldos') {
                // Sobre Saldos (Sistema Alemán) - capital constante, cuota decreciente
                const capitalMensual = montoFinanciar / plazo;
                const primerInteres = montoFinanciar * tasaMensual;
                cuotaMensual = capitalMensual + primerInteres;
                totalIntereses = (montoFinanciar * tasaMensual * (plazo + 1)) / 2;
                totalPagar = montoFinanciar + totalIntereses;
            }

            // Mostrar resultados
            document.getElementById('montoFinanciar').textContent = formatMoneySymbol(montoFinanciar);

            if (tipoInteres === 'sobre_saldos') {
                document.getElementById('cuotaMensual').textContent = formatMoneySymbol(cuotaMensual) + ' (inicial)';
            } else {
                document.getElementById('cuotaMensual').textContent = formatMoneySymbol(cuotaMensual);
            }

            document.getElementById('totalIntereses').textContent = formatMoneySymbol(totalIntereses);
            document.getElementById('totalPagar').textContent = formatMoneySymbol(totalPagar + enganche);

            // Actualizar resumen principal
            const totalConEnganche = totalPagar + enganche;
            const plazoTexto = plazo === 1 ? 'mes' : 'meses';
            document.getElementById('resumenPrincipal').textContent =
                `Usted pagará ${formatMoneySymbol(totalConEnganche)} en ${plazo} ${plazoTexto}`;

            const cuotaTexto = tipoInteres === 'sobre_saldos'
                ? `${formatMoneySymbol(cuotaMensual)} (cuota inicial, luego decrece)`
                : formatMoneySymbol(cuotaMensual);
            document.getElementById('resumenCuota').textContent = cuotaTexto;

            // Mostrar sección de resultados
            document.getElementById('resultadosFinanciamiento').classList.remove('hidden');

            // Generar tabla de amortización
            generarTablaAmortizacion(montoFinanciar, tasaMensual, plazo, tipoInteres);
        }

        function generarTablaAmortizacion(montoInicial, tasaMensual, plazo, tipoInteres) {
            const tbody = document.getElementById('tablaAmortizacionBody');
            if (!tbody) return;

            tbody.innerHTML = '';
            let saldo = montoInicial;

            if (tipoInteres === 'cuota_fija') {
                let cuota;
                if (tasaMensual === 0) {
                    cuota = montoInicial / plazo;
                } else {
                    const factor = Math.pow(1 + tasaMensual, plazo);
                    cuota = montoInicial * (tasaMensual * factor) / (factor - 1);
                }

                for (let i = 1; i <= plazo; i++) {
                    const interes = saldo * tasaMensual;
                    const capital = cuota - interes;
                    saldo = saldo - capital;

                    if (i === plazo) saldo = 0;

                    const row = `
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-4 py-2">${i}</td>
                            <td class="px-4 py-2 font-medium">${formatMoneySymbol(cuota)}</td>
                            <td class="px-4 py-2 text-blue-600">${formatMoneySymbol(capital)}</td>
                            <td class="px-4 py-2 text-yellow-600">${formatMoneySymbol(interes)}</td>
                            <td class="px-4 py-2 font-medium">${formatMoneySymbol(saldo)}</td>
                        </tr>
                    `;
                    tbody.insertAdjacentHTML('beforeend', row);
                }
            } else if (tipoInteres === 'flat') {
                const interesMensual = (montoInicial * tasaMensual);
                const capitalMensual = montoInicial / plazo;
                const cuota = capitalMensual + interesMensual;

                for (let i = 1; i <= plazo; i++) {
                    saldo = saldo - capitalMensual;
                    if (i === plazo) saldo = 0;

                    const row = `
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-4 py-2">${i}</td>
                            <td class="px-4 py-2 font-medium">${formatMoneySymbol(cuota)}</td>
                            <td class="px-4 py-2 text-blue-600">${formatMoneySymbol(capitalMensual)}</td>
                            <td class="px-4 py-2 text-yellow-600">${formatMoneySymbol(interesMensual)}</td>
                            <td class="px-4 py-2 font-medium">${formatMoneySymbol(saldo)}</td>
                        </tr>
                    `;
                    tbody.insertAdjacentHTML('beforeend', row);
                }
            } else if (tipoInteres === 'sobre_saldos') {
                const capitalMensual = montoInicial / plazo;

                for (let i = 1; i <= plazo; i++) {
                    const interes = saldo * tasaMensual;
                    const cuota = capitalMensual + interes;
                    saldo = saldo - capitalMensual;

                    if (i === plazo) saldo = 0;

                    const row = `
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-4 py-2">${i}</td>
                            <td class="px-4 py-2 font-medium">${formatMoneySymbol(cuota)}</td>
                            <td class="px-4 py-2 text-blue-600">${formatMoneySymbol(capitalMensual)}</td>
                            <td class="px-4 py-2 text-yellow-600">${formatMoneySymbol(interes)}</td>
                            <td class="px-4 py-2 font-medium">${formatMoneySymbol(saldo)}</td>
                        </tr>
                    `;
                    tbody.insertAdjacentHTML('beforeend', row);
                }
            }
        }

        function imprimirPlan() {
            const printWindow = window.open('', '', 'height=800,width=900');
            const tabla = document.getElementById('tablaAmortizacion').innerHTML;
            const resumen = document.getElementById('resultadosFinanciamiento').innerHTML;

            printWindow.document.write('<html><head><title>Plan de Pagos</title>');
            printWindow.document.write('<style>');
            printWindow.document.write('body { font-family: Arial, sans-serif; padding: 20px; }');
            printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
            printWindow.document.write('th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }');
            printWindow.document.write('th { background-color: #4CAF50; color: white; }');
            printWindow.document.write('.resumen { margin-bottom: 20px; padding: 15px; background: #f5f5f5; border-radius: 8px; }');
            printWindow.document.write('</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write('<h1>Plan de Pagos - Cotización</h1>');
            printWindow.document.write('<div class="resumen">' + resumen + '</div>');
            printWindow.document.write(tabla);
            printWindow.document.write('</body></html>');
            printWindow.document.close();

            setTimeout(function() {
                printWindow.print();
            }, 250);
        }
    </script>
</x-flowbite-layout>
