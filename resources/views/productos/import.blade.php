<x-flowbite-layout>
    <div class="p-4">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Importar Productos</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Sube un archivo CSV para crear o actualizar productos masivamente
                    </p>
                </div>
                <a href="{{ route('productos.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                <span class="font-medium">¡Éxito!</span> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium">Error:</span> {{ session('error') }}
            </div>
        @endif

        @if(session('errors_detalle'))
            <div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
                <span class="font-medium">Errores en el archivo:</span>
                <ul class="mt-2 list-disc list-inside max-h-64 overflow-y-auto">
                    @foreach(session('errors_detalle') as $error)
                        <li class="text-xs">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium">Error de validación:</span>
                <ul class="mt-2 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Formulario de Importación -->
            <div class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Subir Archivo</h2>

                <form action="{{ route('productos.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Modo de Importación <span class="text-red-500">*</span>
                        </label>
                        <select name="accion" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="ambas" selected>Crear nuevos y actualizar existentes</option>
                            <option value="crear">Solo crear productos nuevos</option>
                            <option value="actualizar">Solo actualizar productos existentes</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Define cómo procesar los productos del archivo
                        </p>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Archivo CSV <span class="text-red-500">*</span>
                        </label>
                        <input type="file" name="archivo" accept=".csv,.txt" required class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Solo archivos CSV (MAX. 5MB)
                        </p>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Importar Productos
                        </button>
                        <a href="{{ route('productos.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>

            <!-- Instrucciones y Plantilla -->
            <div class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Instrucciones</h2>

                <div class="space-y-4">
                    <!-- Paso 1 -->
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <span class="flex items-center justify-center w-8 h-8 text-sm font-bold text-white bg-blue-600 rounded-full">1</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">Descarga la plantilla</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                Usa nuestra plantilla CSV con ejemplos de productos
                            </p>
                            <a href="{{ route('productos.download-template') }}" class="inline-flex items-center text-sm text-blue-600 hover:underline dark:text-blue-400">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Descargar plantilla_productos.csv
                            </a>
                        </div>
                    </div>

                    <!-- Paso 2 -->
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <span class="flex items-center justify-center w-8 h-8 text-sm font-bold text-white bg-blue-600 rounded-full">2</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">Completa los datos</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Abre el archivo con Excel, LibreOffice o cualquier editor de texto y llena los datos de tus productos
                            </p>
                        </div>
                    </div>

                    <!-- Paso 3 -->
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <span class="flex items-center justify-center w-8 h-8 text-sm font-bold text-white bg-blue-600 rounded-full">3</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">Guarda como CSV</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Asegúrate de guardar el archivo como <strong>CSV (separado por comas)</strong>
                            </p>
                        </div>
                    </div>

                    <!-- Paso 4 -->
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <span class="flex items-center justify-center w-8 h-8 text-sm font-bold text-white bg-blue-600 rounded-full">4</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">Importa el archivo</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Selecciona el modo de importación y sube tu archivo
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Columnas Requeridas -->
                <div class="mt-6 p-4 bg-blue-50 dark:bg-gray-900 rounded-lg">
                    <h4 class="text-sm font-bold text-blue-900 dark:text-blue-400 mb-2">Columnas Requeridas</h4>
                    <ul class="text-xs text-blue-800 dark:text-blue-300 space-y-1">
                        <li><strong>codigo:</strong> Código único del producto</li>
                        <li><strong>nombre:</strong> Nombre del producto</li>
                        <li><strong>categoria:</strong> Cemento, Hierro, Blocks, Agregados, etc.</li>
                        <li><strong>unidad_medida:</strong> Bolsa, Unidad, Metro Cúbico, etc.</li>
                        <li><strong>precio_unitario:</strong> Precio en quetzales (números decimales)</li>
                    </ul>
                </div>

                <!-- Columnas Opcionales -->
                <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-900 rounded-lg">
                    <h4 class="text-sm font-bold text-gray-900 dark:text-gray-400 mb-2">Columnas Opcionales</h4>
                    <ul class="text-xs text-gray-700 dark:text-gray-300 space-y-1">
                        <li><strong>stock_actual:</strong> Cantidad disponible (por defecto: 0)</li>
                        <li><strong>stock_minimo:</strong> Stock mínimo de alerta (por defecto: 0)</li>
                        <li><strong>marca:</strong> Marca del producto</li>
                        <li><strong>descripcion:</strong> Descripción detallada</li>
                        <li><strong>estado:</strong> Activo o Inactivo (por defecto: Activo)</li>
                    </ul>
                </div>

                <!-- Notas Importantes -->
                <div class="mt-4 p-4 bg-yellow-50 dark:bg-gray-900 rounded-lg">
                    <h4 class="text-sm font-bold text-yellow-900 dark:text-yellow-400 mb-2">⚠️ Notas Importantes</h4>
                    <ul class="text-xs text-yellow-800 dark:text-yellow-300 space-y-1 list-disc list-inside">
                        <li>El archivo debe estar codificado en <strong>UTF-8</strong></li>
                        <li>Los códigos de producto deben ser únicos</li>
                        <li>Los números decimales deben usar punto (.) no coma (,)</li>
                        <li>La primera fila debe contener los nombres de las columnas</li>
                        <li>No dejes celdas vacías en columnas requeridas</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-flowbite-layout>
