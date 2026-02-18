<x-flowbite-layout>
    <!-- Header -->
    <div class="mb-4">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Nueva Cotización</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Crear una nueva cotización para un cliente</p>
            </div>

            <!-- Mensajes de error -->
            @if(session('error'))
                <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario -->
            <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-6">
                <form action="{{ route('cotizaciones.store') }}" method="POST" id="cotizacionForm">
                    @csrf

                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <!-- Cliente -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="cliente_id" class="text-sm font-medium text-gray-900 dark:text-white">Cliente <span class="text-red-600">*</span></label>
                                <button type="button" id="btnNuevoCliente" class="inline-flex items-center px-3 py-1 text-xs font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"/>
                                    </svg>
                                    Nuevo Cliente
                                </button>
                            </div>
                            <select id="cliente_id" name="cliente_id" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('cliente_id') border-red-500 @enderror">
                                <option value="">Seleccione un cliente</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->nombre_completo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cliente_id')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Plan de Construcción Base -->
                        <div>
                            <label for="receta_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Plan de Construcción Base <span class="text-red-600">*</span></label>
                            <select id="receta_id" name="receta_id" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('receta_id') border-red-500 @enderror">
                                <option value="">Seleccione un plan</option>
                                <option value="libre" {{ old('receta_id') == 'libre' ? 'selected' : '' }}>Plan Libre (Personalizado)</option>
                                @foreach($recetas as $receta)
                                    <option value="{{ $receta->id }}" data-costo="{{ $receta->costo_total }}" {{ old('receta_id') == $receta->id ? 'selected' : '' }}>
                                        {{ $receta->nombre }} - {{ $receta->tipo_vivienda }} ({{ money_symbol($receta->costo_total) }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Seleccione "Plan Libre" para crear una cotización personalizada sin plan base</p>
                            @error('receta_id')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fecha de Emisión -->
                        <div>
                            <label for="fecha_emision" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de Emisión <span class="text-red-600">*</span></label>
                            <input type="date" id="fecha_emision" name="fecha_emision" value="{{ old('fecha_emision', date('Y-m-d')) }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('fecha_emision') border-red-500 @enderror">
                            @error('fecha_emision')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fecha de Vencimiento -->
                        <div>
                            <label for="fecha_vencimiento" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de Vencimiento <span class="text-red-600">*</span></label>
                            <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" value="{{ old('fecha_vencimiento', date('Y-m-t')) }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('fecha_vencimiento') border-red-500 @enderror">
                            @error('fecha_vencimiento')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <!-- Tipo de Venta -->
                    <div class="mb-6">
                        <label for="tipo_venta" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de Venta <span class="text-red-600">*</span></label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative flex items-center p-4 cursor-pointer bg-gray-50 dark:bg-gray-700 border-2 rounded-lg transition-all hover:shadow-md tipo-venta-option" data-tipo="contado">
                                <input type="radio" id="tipo_venta_contado" name="tipo_venta" value="contado" {{ old('tipo_venta', 'credito') == 'contado' ? 'checked' : '' }} class="hidden tipo-venta-radio">
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
                                <input type="radio" id="tipo_venta_credito" name="tipo_venta" value="credito" {{ old('tipo_venta', 'credito') == 'credito' ? 'checked' : '' }} class="hidden tipo-venta-radio">
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
                    <div id="seccionFinanciamiento" class="mb-6 p-4 bg-blue-50 dark:bg-gray-700 rounded-lg border border-blue-200 dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Opciones de Financiamiento</h3>

                        <div class="grid gap-4 md:grid-cols-4">
                            <!-- Plazo -->
                            <div>
                                <label for="plazo_meses" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Plazo (Meses)</label>
                                <input type="number" id="plazo_meses" name="plazo_meses" value="{{ old('plazo_meses', 12) }}" min="1" max="360" step="1" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Número de cuotas mensuales</p>
                            </div>

                            <!-- Tasa de Interés Anual -->
                            <div>
                                <label for="tasa_interes_anual" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tasa de Interés Anual (%)</label>
                                <input type="number" id="tasa_interes_anual" name="tasa_interes_anual" value="{{ old('tasa_interes_anual', 24) }}" min="0" max="100" step="0.01" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Tasa anual efectiva</p>
                            </div>

                            <!-- Tipo de Interés -->
                            <div>
                                <label for="tipo_interes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Plan de Cotización</label>
                                <select id="tipo_interes" name="tipo_interes" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                    <option value="cuota_fija" {{ old('tipo_interes', 'cuota_fija') == 'cuota_fija' ? 'selected' : '' }}>Nivelada</option>
                                    <option value="flat" {{ old('tipo_interes') == 'flat' ? 'selected' : '' }}>Flat Cuota Fija</option>
                                    <option value="sobre_saldos" {{ old('tipo_interes') == 'sobre_saldos' ? 'selected' : '' }}>Sobre Saldos</option>
                                </select>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Tipo de plan de pago</p>
                            </div>

                            <!-- Enganche -->
                            <div>
                                <label for="enganche" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Enganche (Q)</label>
                                <input type="number" id="enganche" name="enganche" value="{{ old('enganche', 0) }}" min="0" step="0.01" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Pago inicial (opcional)</p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="button" id="calcularCuotasBtn" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
                                <svg class="w-4 h-4 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
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
                                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Monto a Financiar</p>
                                    <p class="text-lg font-bold text-blue-600 dark:text-blue-400" id="montoFinanciar">Q 0.00</p>
                                </div>
                                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Cuota Mensual</p>
                                    <p class="text-lg font-bold text-green-600 dark:text-green-400" id="cuotaMensual">Q 0.00</p>
                                </div>
                                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Total de Intereses</p>
                                    <p class="text-lg font-bold text-yellow-600 dark:text-yellow-400" id="totalIntereses">Q 0.00</p>
                                </div>
                                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Total a Pagar</p>
                                    <p class="text-lg font-bold text-purple-600 dark:text-purple-400" id="totalPagar">Q 0.00</p>
                                </div>
                            </div>

                            <!-- Acciones -->
                            <div class="flex gap-3 mb-4">
                                <button type="button" id="toggleAmortizacionBtn" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                    </svg>
                                    Ver Tabla de Amortización Completa
                                </button>
                                <button type="button" id="imprimirPlanBtn" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Imprimir Plan de Pagos
                                </button>
                            </div>

                            <!-- Tabla de amortización -->
                            <div id="tablaAmortizacion" class="hidden overflow-x-auto bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th class="px-4 py-3">#</th>
                                            <th class="px-4 py-3">Cuota</th>
                                            <th class="px-4 py-3">Capital</th>
                                            <th class="px-4 py-3">Interés</th>
                                            <th class="px-4 py-3">Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody id="amortizacionBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Notas -->
                    <div class="mb-6">
                        <label for="notas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notas</label>
                        <textarea id="notas" name="notas" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('notas') border-red-500 @enderror">{{ old('notas') }}</textarea>
                        @error('notas')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Términos y Condiciones -->
                    <div class="mb-6">
                        <label for="terminos_condiciones" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Términos y Condiciones</label>
                        <textarea id="terminos_condiciones" name="terminos_condiciones" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('terminos_condiciones') border-red-500 @enderror">{{ old('terminos_condiciones') }}</textarea>
                        @error('terminos_condiciones')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Productos -->
                    <div class="mb-6">
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Productos de la Receta</h3>
                        </div>

                        <div id="productosContainer" class="space-y-4">
                            <!-- Los productos se agregarán aquí dinámicamente -->
                        </div>

                        <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Subtotal:</span>
                                    <span id="subtotalDisplay" class="text-sm font-bold text-gray-900 dark:text-white">Q 0.00</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-medium text-gray-900 dark:text-white">Total:</span>
                                    <span id="totalDisplay" class="text-xl font-bold text-blue-600 dark:text-blue-400">Q 0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex gap-4">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Guardar Cotización
                        </button>
                        <a href="{{ route('cotizaciones.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            Cancelar
                        </a>
                    </div>
                </form>
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
        let productoIndex = 0;

        // Cargar productos desde receta si se selecciona
        document.getElementById('receta_id').addEventListener('change', function() {
            const recetaId = this.value;
            const container = document.getElementById('productosContainer');

            if (recetaId && recetaId !== 'libre') {
                // Cargar productos de la receta
                loadRecetaProductos(recetaId);
            } else if (recetaId === 'libre') {
                // Limpiar productos para receta libre
                container.innerHTML = '';
                productoIndex = 0;
                addProducto();
            }
        });

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

                select.value = productoData.producto_id;
                cantidad.value = productoData.cantidad;
                precio.value = productoData.precio_unitario;
                descripcion.value = productoData.descripcion || productoData.producto?.nombre || '';

                // Trigger change event to update unidad and subtotal
                select.dispatchEvent(new Event('change'));
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
            let total = 0;
            document.querySelectorAll('.producto-subtotal').forEach(function(input) {
                total += parseFloat(input.value) || 0;
            });

            document.getElementById('subtotalDisplay').textContent = formatMoneySymbol(total);
            document.getElementById('totalDisplay').textContent = formatMoneySymbol(total);
        }

        function loadRecetaProductos(recetaId) {
            // Limpiar productos existentes
            document.getElementById('productosContainer').innerHTML = '';
            productoIndex = 0;

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
                                descripcion: item.producto.nombre
                            });
                        });
                    } else {
                        alert('Esta receta no tiene productos asociados.');
                        addProducto();
                    }
                })
                .catch(error => {
                    console.error('Error cargando productos de receta:', error);
                    alert('Error al cargar los productos de la receta. Agregue productos manualmente.');
                    addProducto();
                });
        }

        // Inicialización: verificar si hay una receta seleccionada al cargar
        document.addEventListener('DOMContentLoaded', function() {
            const recetaId = document.getElementById('receta_id').value;
            if (recetaId && recetaId !== 'libre') {
                loadRecetaProductos(recetaId);
            } else if (recetaId === 'libre') {
                addProducto();
            }
            // Si no hay receta seleccionada, no cargar productos hasta que se seleccione una
        });

        // Validación del formulario antes de enviar
        document.getElementById('cotizacionForm').addEventListener('submit', function(e) {
            const productosCount = document.querySelectorAll('.producto-row').length;

            if (productosCount === 0) {
                e.preventDefault();
                alert('Debe seleccionar una receta para cargar los productos.');
                return false;
            }

            // Validar que todos los productos tengan datos completos
            let valid = true;
            document.querySelectorAll('.producto-row').forEach(function(row) {
                const productoId = row.querySelector('.producto-select').value;
                const cantidad = row.querySelector('.producto-cantidad').value;
                const precio = row.querySelector('.producto-precio').value;

                if (!productoId || !cantidad || !precio || parseFloat(cantidad) <= 0 || parseFloat(precio) < 0) {
                    valid = false;
                }
            });

            if (!valid) {
                e.preventDefault();
                alert('Por favor complete todos los campos de los productos correctamente.');
                return false;
            }
        });

        // Calcular cuotas
        document.getElementById('calcularCuotasBtn').addEventListener('click', function() {
            calcularPlanPagos();
        });

        // Toggle tabla de amortización
        document.getElementById('toggleAmortizacionBtn').addEventListener('click', function() {
            const tabla = document.getElementById('tablaAmortizacion');
            tabla.classList.toggle('hidden');
            const isHidden = tabla.classList.contains('hidden');

            // Actualizar icono y texto del botón
            if (isHidden) {
                this.innerHTML = `
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                    Ver Tabla de Amortización Completa
                `;
            } else {
                this.innerHTML = `
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                    Ocultar Tabla de Amortización
                `;
            }
        });

        // Imprimir plan de pagos
        document.getElementById('imprimirPlanBtn').addEventListener('click', function() {
            const tabla = document.getElementById('tablaAmortizacion');
            const tbody = document.getElementById('amortizacionBody');

            if (!tbody || tbody.children.length === 0) {
                alert('Primero debe calcular el plan de pagos.');
                return;
            }

            // Obtener datos para el preview
            const plazo = document.getElementById('plazo_meses').value;
            const tasa = document.getElementById('tasa_interes_anual').value;
            const tipoInteres = document.getElementById('tipo_interes').options[document.getElementById('tipo_interes').selectedIndex].text;
            const montoFinanciar = document.getElementById('montoFinanciar').textContent;
            const cuotaMensual = document.getElementById('cuotaMensual').textContent;
            const totalIntereses = document.getElementById('totalIntereses').textContent;
            const totalPagar = document.getElementById('totalPagar').textContent;

            // Crear ventana de impresión
            const printWindow = window.open('', '', 'height=800,width=900');
            printWindow.document.write('<html><head><title>Plan de Pagos - Cotización</title>');
            printWindow.document.write('<style>');
            printWindow.document.write('body { font-family: Arial, sans-serif; padding: 20px; }');
            printWindow.document.write('h1 { color: #1e40af; border-bottom: 3px solid #1e40af; padding-bottom: 10px; }');
            printWindow.document.write('h2 { color: #4b5563; margin-top: 30px; }');
            printWindow.document.write('.info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin: 20px 0; }');
            printWindow.document.write('.info-box { background: #f3f4f6; padding: 15px; border-radius: 8px; }');
            printWindow.document.write('.info-label { font-weight: bold; color: #6b7280; font-size: 12px; margin-bottom: 5px; }');
            printWindow.document.write('.info-value { font-size: 18px; color: #1f2937; font-weight: bold; }');
            printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
            printWindow.document.write('th { background: #1e40af; color: white; padding: 12px; text-align: left; }');
            printWindow.document.write('td { padding: 10px; border-bottom: 1px solid #e5e7eb; }');
            printWindow.document.write('tr:nth-child(even) { background: #f9fafb; }');
            printWindow.document.write('.resumen { background: linear-gradient(to right, #1e40af, #7c3aed); color: white; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center; }');
            printWindow.document.write('.resumen h2 { color: white; font-size: 24px; margin: 10px 0; }');
            printWindow.document.write('@media print { body { padding: 10px; } }');
            printWindow.document.write('</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write('<h1>Plan de Pagos - Cotización</h1>');
            printWindow.document.write('<div class="resumen">');
            printWindow.document.write('<h2>' + document.getElementById('resumenPrincipal').textContent + '</h2>');
            printWindow.document.write('<p style="margin: 5px 0;">' + document.getElementById('resumenDetalle').textContent + '</p>');
            printWindow.document.write('</div>');
            printWindow.document.write('<div class="info-grid">');
            printWindow.document.write('<div class="info-box"><div class="info-label">Monto a Financiar</div><div class="info-value">' + montoFinanciar + '</div></div>');
            printWindow.document.write('<div class="info-box"><div class="info-label">Cuota Mensual</div><div class="info-value">' + cuotaMensual + '</div></div>');
            printWindow.document.write('<div class="info-box"><div class="info-label">Plazo</div><div class="info-value">' + plazo + ' meses</div></div>');
            printWindow.document.write('<div class="info-box"><div class="info-label">Tasa de Interés Anual</div><div class="info-value">' + tasa + '%</div></div>');
            printWindow.document.write('<div class="info-box"><div class="info-label">Plan de Cotización</div><div class="info-value">' + tipoInteres + '</div></div>');
            printWindow.document.write('<div class="info-box"><div class="info-label">Total de Intereses</div><div class="info-value">' + totalIntereses + '</div></div>');
            printWindow.document.write('</div>');
            printWindow.document.write('<h2>Tabla de Amortización</h2>');
            printWindow.document.write('<table>');
            printWindow.document.write('<thead><tr><th>#</th><th>Cuota</th><th>Capital</th><th>Interés</th><th>Saldo</th></tr></thead>');
            printWindow.document.write('<tbody>');
            printWindow.document.write(tbody.innerHTML);
            printWindow.document.write('</tbody></table>');
            printWindow.document.write('<div style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #e5e7eb; text-align: center; color: #6b7280; font-size: 12px;">');
            printWindow.document.write('<p>Documento generado el ' + new Date().toLocaleDateString('es-GT') + '</p>');
            printWindow.document.write('</div>');
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.focus();

            // Esperar a que cargue y luego imprimir
            setTimeout(function() {
                printWindow.print();
            }, 250);
        });

        function calcularPlanPagos() {
            // Obtener valores
            const total = parseFloat(document.getElementById('totalDisplay').textContent.replace('Q ', '').replace(/,/g, '')) || 0;
            const enganche = parseFloat(document.getElementById('enganche').value) || 0;
            const plazo = parseInt(document.getElementById('plazo_meses').value) || 12;
            const tasaAnual = parseFloat(document.getElementById('tasa_interes_anual').value) || 0;
            const tipoInteres = document.getElementById('tipo_interes').value;

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
                    // Sin interés
                    cuotaMensual = montoFinanciar / plazo;
                    totalIntereses = 0;
                    totalPagar = montoFinanciar;
                } else {
                    // Con interés - Fórmula de cuota nivelada (sistema francés)
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
                // Para mostrar cuota promedio inicial
                const capitalMensual = montoFinanciar / plazo;
                const primerInteres = montoFinanciar * tasaMensual;
                cuotaMensual = capitalMensual + primerInteres; // Primera cuota (la más alta)

                // Calcular total de intereses (suma de serie aritmética)
                totalIntereses = (montoFinanciar * tasaMensual * (plazo + 1)) / 2;
                totalPagar = montoFinanciar + totalIntereses;
            }

            // Mostrar resultados
            document.getElementById('montoFinanciar').textContent = 'Q ' + formatMoney(montoFinanciar);

            // Para sobre_saldos, indicar que es la cuota inicial
            if (tipoInteres === 'sobre_saldos') {
                document.getElementById('cuotaMensual').textContent = 'Q ' + formatMoney(cuotaMensual) + ' (inicial)';
            } else {
                document.getElementById('cuotaMensual').textContent = 'Q ' + formatMoney(cuotaMensual);
            }

            document.getElementById('totalIntereses').textContent = 'Q ' + formatMoney(totalIntereses);
            document.getElementById('totalPagar').textContent = 'Q ' + formatMoney(totalPagar + enganche);

            // Actualizar resumen principal
            const totalConEnganche = totalPagar + enganche;
            const plazoTexto = plazo === 1 ? 'mes' : 'meses';
            document.getElementById('resumenPrincipal').textContent =
                `Usted pagará Q ${formatMoney(totalConEnganche)} en ${plazo} ${plazoTexto}`;

            const cuotaTexto = tipoInteres === 'sobre_saldos'
                ? `Q ${formatMoney(cuotaMensual)} (cuota inicial, luego decrece)`
                : `Q ${formatMoney(cuotaMensual)}`;
            document.getElementById('resumenCuota').textContent = cuotaTexto;

            // Mostrar sección de resultados
            document.getElementById('resultadosFinanciamiento').classList.remove('hidden');

            // Generar tabla de amortización
            generarTablaAmortizacion(montoFinanciar, tasaMensual, plazo, tipoInteres);
        }

        function generarTablaAmortizacion(montoInicial, tasaMensual, plazo, tipoInteres) {
            const tbody = document.getElementById('amortizacionBody');
            tbody.innerHTML = '';

            let saldo = montoInicial;

            if (tipoInteres === 'cuota_fija') {
                // Cuota Fija - cuota constante, interés decreciente sobre saldo
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

                    // Evitar saldos negativos por redondeo
                    if (i === plazo) {
                        saldo = 0;
                    }

                    const row = `
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-4 py-2">${i}</td>
                            <td class="px-4 py-2 font-medium">Q ${formatMoney(cuota)}</td>
                            <td class="px-4 py-2 text-blue-600">Q ${formatMoney(capital)}</td>
                            <td class="px-4 py-2 text-yellow-600">Q ${formatMoney(interes)}</td>
                            <td class="px-4 py-2 font-medium">Q ${formatMoney(saldo)}</td>
                        </tr>
                    `;
                    tbody.insertAdjacentHTML('beforeend', row);
                }
            } else if (tipoInteres === 'flat') {
                // Flat - interés constante sobre capital original
                const interesMensual = (montoInicial * tasaMensual);
                const capitalMensual = montoInicial / plazo;
                const cuota = capitalMensual + interesMensual;

                for (let i = 1; i <= plazo; i++) {
                    saldo = saldo - capitalMensual;

                    // Evitar saldos negativos por redondeo
                    if (i === plazo) {
                        saldo = 0;
                    }

                    const row = `
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-4 py-2">${i}</td>
                            <td class="px-4 py-2 font-medium">Q ${formatMoney(cuota)}</td>
                            <td class="px-4 py-2 text-blue-600">Q ${formatMoney(capitalMensual)}</td>
                            <td class="px-4 py-2 text-yellow-600">Q ${formatMoney(interesMensual)}</td>
                            <td class="px-4 py-2 font-medium">Q ${formatMoney(saldo)}</td>
                        </tr>
                    `;
                    tbody.insertAdjacentHTML('beforeend', row);
                }
            } else if (tipoInteres === 'sobre_saldos') {
                // Sobre Saldos - capital constante, cuota decreciente
                const capitalMensual = montoInicial / plazo;

                for (let i = 1; i <= plazo; i++) {
                    const interes = saldo * tasaMensual;
                    const cuota = capitalMensual + interes;
                    saldo = saldo - capitalMensual;

                    // Evitar saldos negativos por redondeo
                    if (i === plazo) {
                        saldo = 0;
                    }

                    const row = `
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-4 py-2">${i}</td>
                            <td class="px-4 py-2 font-medium">Q ${formatMoney(cuota)}</td>
                            <td class="px-4 py-2 text-blue-600">Q ${formatMoney(capitalMensual)}</td>
                            <td class="px-4 py-2 text-yellow-600">Q ${formatMoney(interes)}</td>
                            <td class="px-4 py-2 font-medium">Q ${formatMoney(saldo)}</td>
                        </tr>
                    `;
                    tbody.insertAdjacentHTML('beforeend', row);
                }
            }
        }

        function formatMoney(value) {
            return formatMoney(value);
        }

        // Manejo del tipo de venta
        document.addEventListener('DOMContentLoaded', function() {
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
                            seccionFinanciamiento.classList.remove('hidden');
                        } else {
                            seccionFinanciamiento.classList.add('hidden');
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
            // MODAL CREAR CLIENTE RÁPIDO
            // ==========================================
            const btnNuevoCliente = document.getElementById('btnNuevoCliente');
            const modalCrearCliente = document.getElementById('modalCrearCliente');
            const btnCerrarModal = document.getElementById('btnCerrarModal');
            const btnCancelarModal = document.getElementById('btnCancelarModal');
            const formCrearClienteRapido = document.getElementById('formCrearClienteRapido');
            const clienteIdSelect = document.getElementById('cliente_id');

            // Verificar que todos los elementos existan
            if (!btnNuevoCliente || !modalCrearCliente || !btnCerrarModal || !btnCancelarModal || !formCrearClienteRapido || !clienteIdSelect) {
                console.error('Error: No se encontraron todos los elementos del modal');
                console.log('btnNuevoCliente:', btnNuevoCliente);
                console.log('modalCrearCliente:', modalCrearCliente);
                console.log('btnCerrarModal:', btnCerrarModal);
                console.log('btnCancelarModal:', btnCancelarModal);
                console.log('formCrearClienteRapido:', formCrearClienteRapido);
                console.log('clienteIdSelect:', clienteIdSelect);
                return;
            }

            // Abrir modal
            btnNuevoCliente.addEventListener('click', function(e) {
                e.preventDefault();
                modalCrearCliente.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            });

            // Cerrar modal
            function cerrarModal() {
                modalCrearCliente.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                formCrearClienteRapido.reset();
                // Limpiar errores
                document.querySelectorAll('.error-message').forEach(el => el.remove());
            }

            btnCerrarModal.addEventListener('click', cerrarModal);
            btnCancelarModal.addEventListener('click', cerrarModal);

            // Cerrar modal al hacer clic fuera
            modalCrearCliente.addEventListener('click', function(e) {
                if (e.target === modalCrearCliente) {
                    cerrarModal();
                }
            });

            // Enviar formulario de creación de cliente
            formCrearClienteRapido.addEventListener('submit', function(e) {
                e.preventDefault();

                // Limpiar errores previos
                document.querySelectorAll('.error-message').forEach(el => el.remove());

                const formData = new FormData(this);
                const btnSubmit = document.getElementById('btnGuardarCliente');
                const btnSpinner = btnSubmit.querySelector('.spinner');
                const btnText = btnSubmit.querySelector('.btn-text');

                // Mostrar spinner
                btnSubmit.disabled = true;
                btnSpinner.classList.remove('hidden');
                btnText.textContent = 'Guardando...';

                fetch('{{ route("clientes.quick-store") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Agregar nuevo cliente al select
                        const newOption = document.createElement('option');
                        newOption.value = data.cliente.id;
                        newOption.textContent = data.cliente.nombre_completo;
                        newOption.selected = true;
                        clienteIdSelect.appendChild(newOption);

                        // Mostrar mensaje de éxito
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg';
                        alertDiv.innerHTML = '<p><strong>¡Éxito!</strong> ' + data.message + '</p>';
                        document.querySelector('.container').insertBefore(alertDiv, document.querySelector('.container').firstChild);

                        // Ocultar automáticamente después de 3 segundos
                        setTimeout(() => {
                            alertDiv.remove();
                        }, 3000);

                        // Cerrar modal
                        cerrarModal();
                    } else {
                        throw new Error(data.message || 'Error al crear el cliente');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);

                    // Mostrar mensaje de error
                    if (error.message) {
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'error-message mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg';
                        errorDiv.innerHTML = '<p><strong>Error:</strong> ' + error.message + '</p>';
                        formCrearClienteRapido.insertBefore(errorDiv, formCrearClienteRapido.firstChild);
                    }
                })
                .finally(() => {
                    // Restaurar botón
                    btnSubmit.disabled = false;
                    btnSpinner.classList.add('hidden');
                    btnText.textContent = 'Guardar Cliente';
                });
            });
        });
    </script>

    <!-- Modal Crear Cliente Rápido -->
    <div id="modalCrearCliente" class="hidden fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-50 flex items-center justify-center p-4">
        <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full">
            <!-- Header -->
            <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Crear Cliente Rápido
                </h3>
                <button id="btnCerrarModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div class="p-6">
                <form id="formCrearClienteRapido">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nombre Completo -->
                        <div class="md:col-span-2">
                            <label for="modal_nombre_completo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Nombre Completo <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="modal_nombre_completo" name="nombre_completo" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Ej: Juan Pérez García">
                        </div>

                        <!-- DPI -->
                        <div>
                            <label for="modal_dpi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                DPI <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="modal_dpi" name="dpi" required maxlength="13" pattern="[0-9]{13}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                placeholder="1234567890123">
                            <p class="mt-1 text-xs text-gray-500">13 dígitos numéricos</p>
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <label for="modal_telefono" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Teléfono <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="modal_telefono" name="telefono" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                placeholder="12345678">
                        </div>

                        <!-- Email (opcional) -->
                        <div class="md:col-span-2">
                            <label for="modal_email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Email
                            </label>
                            <input type="email" id="modal_email" name="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                placeholder="correo@ejemplo.com">
                        </div>

                        <!-- Dirección (opcional) -->
                        <div class="md:col-span-2">
                            <label for="modal_direccion_completa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Dirección Completa
                            </label>
                            <textarea id="modal_direccion_completa" name="direccion_completa" rows="2"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Dirección, zona, ciudad, departamento"></textarea>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="flex items-center justify-end space-x-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" id="btnCancelarModal"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600">
                            Cancelar
                        </button>
                        <button type="submit" id="btnGuardarCliente"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 inline-flex items-center">
                            <svg class="spinner hidden animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="btn-text">Guardar Cliente</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-flowbite-layout>
