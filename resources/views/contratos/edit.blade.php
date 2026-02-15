<x-flowbite-layout>
    <!-- Quill.js CSS -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    <style>
        #contenido-editor { height: 550px; font-family: Arial, sans-serif; font-size: 12pt; }
        .ql-toolbar.ql-snow { border-radius: 0.5rem 0.5rem 0 0; background: #f9fafb; }
        .ql-container.ql-snow { border-radius: 0 0 0.5rem 0.5rem; background: #ffffff; }
        .ql-editor { min-height: 500px; color: #111827; }
    </style>

    <div class="mb-6">
        <div class="flex items-center gap-2 mb-2">
            <a href="{{ route('contratos.show', $contrato) }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Editar Contrato: {{ $contrato->numero_contrato }}</h1>
        </div>
        <p class="text-sm text-gray-600 dark:text-gray-400">Modifique la información del contrato</p>
    </div>

    @if($errors->any())
        <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('contratos.update', $contrato) }}" method="POST" id="contrato-form">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Panel Izquierdo - Datos del Contrato -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Datos del Contrato</h2>

                    <!-- Número de Contrato -->
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Número</label>
                        <input type="text" value="{{ $contrato->numero_contrato }}" disabled class="bg-gray-100 border border-gray-300 text-gray-500 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-400">
                    </div>

                    <!-- Cliente -->
                    <div class="mb-4">
                        <label for="cliente_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Cliente <span class="text-red-500">*</span>
                        </label>
                        <select name="cliente_id" id="cliente_id" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Seleccionar cliente...</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ old('cliente_id', $contrato->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->nombre_completo }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Venta/Préstamo -->
                    <div class="mb-4">
                        <label for="prestamo_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Venta Asociada <span class="text-red-500">*</span>
                        </label>
                        <select name="prestamo_id" id="prestamo_id" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @foreach($prestamos as $prestamo)
                                <option value="{{ $prestamo->id }}" {{ old('prestamo_id', $contrato->prestamo_id) == $prestamo->id ? 'selected' : '' }}
                                    data-monto="{{ $prestamo->monto_prestado }}" data-saldo="{{ $prestamo->saldo_pendiente }}">
                                    {{ $prestamo->numero_prestamo }} - Q{{ number_format($prestamo->monto_prestado, 2) }}
                                </option>
                            @endforeach
                        </select>
                        <div id="prestamo-info" class="mt-2 text-xs text-gray-500 dark:text-gray-400 {{ $contrato->prestamo ? '' : 'hidden' }}">
                            <p>Monto: <span id="prestamo-monto" class="font-semibold">{{ $contrato->prestamo ? 'Q' . number_format($contrato->prestamo->monto_prestado, 2) : '' }}</span></p>
                            <p>Saldo: <span id="prestamo-saldo" class="font-semibold">{{ $contrato->prestamo ? 'Q' . number_format($contrato->prestamo->saldo_pendiente, 2) : '' }}</span></p>
                        </div>
                    </div>

                    <!-- Contratista -->
                    <div class="mb-4">
                        <label for="contratista_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Contratista <span class="text-red-500">*</span>
                        </label>
                        <select name="contratista_id" id="contratista_id" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Seleccionar contratista...</option>
                            @foreach($contratistas as $contratista)
                                <option value="{{ $contratista->id }}" {{ old('contratista_id', $contrato->contratista_id) == $contratista->id ? 'selected' : '' }}>
                                    {{ $contratista->nombre_completo }} {{ $contratista->nombre_empresa ? '(' . $contratista->nombre_empresa . ')' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Título -->
                    <div class="mb-4">
                        <label for="titulo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Título del Contrato <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $contrato->titulo) }}" required placeholder="Ej: Contrato de construcción de vivienda" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <!-- Fecha del Contrato -->
                    <div class="mb-4">
                        <label for="fecha_contrato" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Fecha del Contrato <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="fecha_contrato" id="fecha_contrato" value="{{ old('fecha_contrato', $contrato->fecha_contrato->format('Y-m-d')) }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <!-- Fechas Inicio/Fin -->
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div>
                            <label for="fecha_inicio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Inicio</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio', $contrato->fecha_inicio ? $contrato->fecha_inicio->format('Y-m-d') : '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label for="fecha_fin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fin</label>
                            <input type="date" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin', $contrato->fecha_fin ? $contrato->fecha_fin->format('Y-m-d') : '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>

                    <!-- Monto del Contrato -->
                    <div class="mb-4">
                        <label for="monto_contrato" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Monto del Contrato</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400 text-sm">Q</span>
                            </div>
                            <input type="number" name="monto_contrato" id="monto_contrato" value="{{ old('monto_contrato', $contrato->monto_contrato) }}" step="0.01" min="0" placeholder="0.00" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-8 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>

                    <!-- Estado -->
                    <div class="mb-4">
                        <label for="estado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                        <select name="estado" id="estado" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="borrador" {{ old('estado', $contrato->estado) == 'borrador' ? 'selected' : '' }}>Borrador</option>
                            <option value="activo" {{ old('estado', $contrato->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="finalizado" {{ old('estado', $contrato->estado) == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                            <option value="cancelado" {{ old('estado', $contrato->estado) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                    </div>

                    <!-- Notas -->
                    <div>
                        <label for="notas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notas Internas</label>
                        <textarea name="notas" id="notas" rows="3" placeholder="Notas internas (no aparecen en el contrato)" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('notas', $contrato->notas) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Panel Derecho - Editor del Contrato -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Contenido del Contrato</h2>
                    </div>

                    <input type="hidden" name="contenido" id="contenido-hidden">
                    <div id="contenido-editor">{!! old('contenido', $contrato->contenido) !!}</div>
                </div>

                <!-- Botones -->
                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('contratos.show', $contrato) }}" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">
                        Cancelar
                    </a>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- Quill.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script>
        // Inicializar Quill
        const quill = new Quill('#contenido-editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    [{ 'font': [] }, { 'size': ['small', false, 'large', 'huge'] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'align': [] }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    ['link', 'image'],
                    ['blockquote'],
                    ['clean']
                ]
            },
            placeholder: 'Escriba el contenido del contrato aquí...'
        });

        // Cargar préstamos del cliente seleccionado
        document.getElementById('cliente_id').addEventListener('change', function() {
            const clienteId = this.value;
            const prestamoSelect = document.getElementById('prestamo_id');
            const prestamoInfo = document.getElementById('prestamo-info');

            prestamoSelect.innerHTML = '<option value="">Cargando...</option>';
            prestamoInfo.classList.add('hidden');

            if (!clienteId) {
                prestamoSelect.innerHTML = '<option value="">Primero seleccione un cliente...</option>';
                return;
            }

            fetch(`/contratos/prestamos-cliente/${clienteId}`)
                .then(response => response.json())
                .then(data => {
                    prestamoSelect.innerHTML = '<option value="">Seleccionar venta...</option>';
                    data.forEach(p => {
                        const option = document.createElement('option');
                        option.value = p.id;
                        option.textContent = `${p.numero_prestamo} - Q${parseFloat(p.monto_prestado).toLocaleString('es-GT', {minimumFractionDigits: 2})}`;
                        option.dataset.monto = p.monto_prestado;
                        option.dataset.saldo = p.saldo_pendiente;
                        prestamoSelect.appendChild(option);
                    });
                })
                .catch(() => {
                    prestamoSelect.innerHTML = '<option value="">Error al cargar ventas</option>';
                });
        });

        // Mostrar info del préstamo seleccionado
        document.getElementById('prestamo_id').addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            const prestamoInfo = document.getElementById('prestamo-info');

            if (selected.value && selected.dataset.monto) {
                document.getElementById('prestamo-monto').textContent = 'Q' + parseFloat(selected.dataset.monto).toLocaleString('es-GT', {minimumFractionDigits: 2});
                document.getElementById('prestamo-saldo').textContent = 'Q' + parseFloat(selected.dataset.saldo).toLocaleString('es-GT', {minimumFractionDigits: 2});
                prestamoInfo.classList.remove('hidden');
            } else {
                prestamoInfo.classList.add('hidden');
            }
        });

        // Sincronizar Quill antes de enviar
        document.getElementById('contrato-form').addEventListener('submit', function(e) {
            document.getElementById('contenido-hidden').value = quill.root.innerHTML;
        });
    </script>
</x-flowbite-layout>
