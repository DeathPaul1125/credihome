<x-flowbite-layout>
    <div class="p-4">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Configuración del Sistema</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Configure los parámetros generales de la aplicación
            </p>
        </div>

        <!-- Alert de éxito -->
        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                <span class="font-medium">¡Éxito!</span> {{ session('success') }}
            </div>
        @endif

        <!-- Alert de errores -->
        @if($errors->any())
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium">Error:</span>
                <ul class="mt-2 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('configuracion.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Tabs -->
            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="config-tabs" data-tabs-toggle="#config-tabs-content" role="tablist">
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg text-gray-900 dark:text-white hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="general-tab" data-tabs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="false">
                            General
                        </button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg text-gray-900 dark:text-white hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="imagenes-tab" data-tabs-target="#imagenes" type="button" role="tab" aria-controls="imagenes" aria-selected="false">
                            Imágenes
                        </button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg text-gray-900 dark:text-white hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="pdf-tab" data-tabs-target="#pdf" type="button" role="tab" aria-controls="pdf" aria-selected="false">
                            PDFs
                        </button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg text-gray-900 dark:text-white hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="tema-tab" data-tabs-target="#tema" type="button" role="tab" aria-controls="tema" aria-selected="false">
                            Tema
                        </button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg text-gray-900 dark:text-white hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="negocios-tab" data-tabs-target="#negocios" type="button" role="tab" aria-controls="negocios" aria-selected="false">
                            Negocios
                        </button>
                    </li>
                    <li role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg text-gray-900 dark:text-white hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="notificaciones-tab" data-tabs-target="#notificaciones" type="button" role="tab" aria-controls="notificaciones" aria-selected="false">
                            Notificaciones
                        </button>
                    </li>
                </ul>
            </div>

            <div id="config-tabs-content">
                <!-- Tab General -->
                <div class="hidden p-6 bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700" id="general" role="tabpanel" aria-labelledby="general-tab">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nombre_aplicacion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Nombre de la Aplicación <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nombre_aplicacion" id="nombre_aplicacion" value="{{ old('nombre_aplicacion', $configuracion->nombre_aplicacion) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                        </div>

                        <div>
                            <label for="slogan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Slogan
                            </label>
                            <input type="text" name="slogan" id="slogan" value="{{ old('slogan', $configuracion->slogan) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                        </div>

                        <div>
                            <label for="telefono" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Teléfono
                            </label>
                            <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $configuracion->telefono) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                        </div>

                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Email
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email', $configuracion->email) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                        </div>

                        <div class="md:col-span-2">
                            <label for="direccion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Dirección
                            </label>
                            <textarea name="direccion" id="direccion" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">{{ old('direccion', $configuracion->direccion) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Tab Imágenes -->
                <div class="hidden p-6 bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700" id="imagenes" role="tabpanel" aria-labelledby="imagenes-tab">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Logo Login -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Logo para Pantalla de Login
                            </label>
                            @if($configuracion->logo_login)
                                <img src="{{ Storage::url($configuracion->logo_login) }}" alt="Logo Login" class="mb-2 h-20 object-contain">
                            @endif
                            <input type="file" name="logo_login" accept="image/png,image/jpeg,image/jpg" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, JPG (MAX. 2MB)</p>
                        </div>

                        <!-- Logo Sidebar -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Logo para Sidebar
                            </label>
                            @if($configuracion->logo_sidebar)
                                <img src="{{ Storage::url($configuracion->logo_sidebar) }}" alt="Logo Sidebar" class="mb-2 h-20 object-contain">
                            @endif
                            <input type="file" name="logo_sidebar" accept="image/png,image/jpeg,image/jpg" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, JPG (MAX. 2MB)</p>
                        </div>

                        <!-- Logo Reportes -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Logo para Reportes/PDFs
                            </label>
                            @if($configuracion->logo_reportes)
                                <img src="{{ Storage::url($configuracion->logo_reportes) }}" alt="Logo Reportes" class="mb-2 h-20 object-contain">
                            @endif
                            <input type="file" name="logo_reportes" accept="image/png,image/jpeg,image/jpg" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, JPG (MAX. 2MB)</p>
                        </div>

                        <!-- Favicon -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Favicon
                            </label>
                            @if($configuracion->favicon)
                                <img src="{{ Storage::url($configuracion->favicon) }}" alt="Favicon" class="mb-2 h-8 object-contain">
                            @endif
                            <input type="file" name="favicon" accept="image/png,image/jpeg,image/jpg,image/x-icon" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, ICO (MAX. 1MB)</p>
                        </div>
                    </div>
                </div>

                <!-- Tab PDF -->
                <div class="hidden p-6 bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700" id="pdf" role="tabpanel" aria-labelledby="pdf-tab">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="pdf_orientacion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Orientación <span class="text-red-500">*</span>
                            </label>
                            <select name="pdf_orientacion" id="pdf_orientacion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                <option value="portrait" {{ old('pdf_orientacion', $configuracion->pdf_orientacion) == 'portrait' ? 'selected' : '' }}>Vertical (Portrait)</option>
                                <option value="landscape" {{ old('pdf_orientacion', $configuracion->pdf_orientacion) == 'landscape' ? 'selected' : '' }}>Horizontal (Landscape)</option>
                            </select>
                        </div>

                        <div>
                            <label for="pdf_tamano" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Tamaño de Papel <span class="text-red-500">*</span>
                            </label>
                            <select name="pdf_tamano" id="pdf_tamano" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                <option value="letter" {{ old('pdf_tamano', $configuracion->pdf_tamano) == 'letter' ? 'selected' : '' }}>Carta (Letter)</option>
                                <option value="legal" {{ old('pdf_tamano', $configuracion->pdf_tamano) == 'legal' ? 'selected' : '' }}>Oficio (Legal)</option>
                                <option value="a4" {{ old('pdf_tamano', $configuracion->pdf_tamano) == 'a4' ? 'selected' : '' }}>A4</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Elementos a Mostrar en PDF
                            </label>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input type="checkbox" name="pdf_mostrar_logo" id="pdf_mostrar_logo" {{ old('pdf_mostrar_logo', $configuracion->pdf_mostrar_logo) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="pdf_mostrar_logo" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Mostrar Logo</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="pdf_mostrar_fecha" id="pdf_mostrar_fecha" {{ old('pdf_mostrar_fecha', $configuracion->pdf_mostrar_fecha) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="pdf_mostrar_fecha" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Mostrar Fecha de Generación</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="pdf_mostrar_usuario" id="pdf_mostrar_usuario" {{ old('pdf_mostrar_usuario', $configuracion->pdf_mostrar_usuario) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="pdf_mostrar_usuario" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Mostrar Usuario que Generó</label>
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label for="pdf_footer" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Pie de Página
                            </label>
                            <input type="text" name="pdf_footer" id="pdf_footer" value="{{ old('pdf_footer', $configuracion->pdf_footer) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Ej: Página {PAGE_NUM} de {PAGE_COUNT}">
                        </div>

                        <div class="md:col-span-2">
                            <label for="pdf_terminos_condiciones" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Términos y Condiciones para Contratos
                            </label>
                            <textarea name="pdf_terminos_condiciones" id="pdf_terminos_condiciones" rows="5" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">{{ old('pdf_terminos_condiciones', $configuracion->pdf_terminos_condiciones) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Tab Tema -->
                <div class="hidden p-6 bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700" id="tema" role="tabpanel" aria-labelledby="tema-tab">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="color_primario" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Color Primario
                            </label>
                            <div class="flex gap-2">
                                <input type="color" name="color_primario" id="color_primario" value="{{ old('color_primario', $configuracion->color_primario) }}" class="h-10 w-14 bg-gray-50 border border-gray-300 rounded-lg cursor-pointer">
                                <input type="text" id="color_primario_text" value="{{ old('color_primario', $configuracion->color_primario) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" readonly>
                            </div>
                        </div>

                        <div>
                            <label for="color_secundario" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Color Secundario
                            </label>
                            <div class="flex gap-2">
                                <input type="color" name="color_secundario" id="color_secundario" value="{{ old('color_secundario', $configuracion->color_secundario) }}" class="h-10 w-14 bg-gray-50 border border-gray-300 rounded-lg cursor-pointer">
                                <input type="text" id="color_secundario_text" value="{{ old('color_secundario', $configuracion->color_secundario) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 p-4 bg-blue-50 dark:bg-gray-900 rounded-lg">
                        <p class="text-sm text-blue-800 dark:text-blue-400">
                            <strong>Nota:</strong> Los cambios de color requieren recompilar los assets de Tailwind CSS para aplicarse completamente.
                        </p>
                    </div>
                </div>

                <!-- Tab Negocios -->
                <div class="hidden p-6 bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700" id="negocios" role="tabpanel" aria-labelledby="negocios-tab">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="moneda" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Símbolo de Moneda <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="moneda" id="moneda" value="{{ old('moneda', $configuracion->moneda) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                        </div>

                        <div>
                            <label for="moneda_nombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Nombre de Moneda <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="moneda_nombre" id="moneda_nombre" value="{{ old('moneda_nombre', $configuracion->moneda_nombre) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                        </div>

                        <div>
                            <label for="tasa_interes_default" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Tasa de Interés por Defecto (%) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" step="0.01" name="tasa_interes_default" id="tasa_interes_default" value="{{ old('tasa_interes_default', $configuracion->tasa_interes_default) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                        </div>

                        <div>
                            <label for="plazo_default" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Plazo por Defecto (meses) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="plazo_default" id="plazo_default" value="{{ old('plazo_default', $configuracion->plazo_default) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                        </div>

                        <div>
                            <label for="dias_vencimiento_cotizacion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Días de Vencimiento de Cotizaciones <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="dias_vencimiento_cotizacion" id="dias_vencimiento_cotizacion" value="{{ old('dias_vencimiento_cotizacion', $configuracion->dias_vencimiento_cotizacion) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                        </div>
                    </div>
                </div>

                <!-- Tab Notificaciones -->
                <div class="hidden p-6 bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700" id="notificaciones" role="tabpanel" aria-labelledby="notificaciones-tab">
                    <div class="space-y-4">
                        <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-900 rounded-lg">
                            <input type="checkbox" name="notificar_stock_bajo" id="notificar_stock_bajo" {{ old('notificar_stock_bajo', $configuracion->notificar_stock_bajo) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <div class="ms-3">
                                <label for="notificar_stock_bajo" class="text-sm font-medium text-gray-900 dark:text-gray-300">Notificar Stock Bajo</label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Enviar alerta cuando un producto alcance su stock mínimo</p>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-900 rounded-lg">
                            <input type="checkbox" name="notificar_pagos_pendientes" id="notificar_pagos_pendientes" {{ old('notificar_pagos_pendientes', $configuracion->notificar_pagos_pendientes) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <div class="ms-3">
                                <label for="notificar_pagos_pendientes" class="text-sm font-medium text-gray-900 dark:text-gray-300">Notificar Pagos Pendientes</label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Enviar recordatorios de cuotas próximas a vencer</p>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-900 rounded-lg">
                            <input type="checkbox" name="notificar_cotizaciones_vencidas" id="notificar_cotizaciones_vencidas" {{ old('notificar_cotizaciones_vencidas', $configuracion->notificar_cotizaciones_vencidas) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <div class="ms-3">
                                <label for="notificar_cotizaciones_vencidas" class="text-sm font-medium text-gray-900 dark:text-gray-300">Notificar Cotizaciones Vencidas</label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Alerta cuando una cotización expire sin ser aprobada</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="flex justify-end gap-2 mt-6">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Guardar Configuración
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        // Sincronizar color picker con input de texto
        document.getElementById('color_primario').addEventListener('input', function() {
            document.getElementById('color_primario_text').value = this.value;
        });
        document.getElementById('color_secundario').addEventListener('input', function() {
            document.getElementById('color_secundario_text').value = this.value;
        });
    </script>
    @endpush
</x-flowbite-layout>
