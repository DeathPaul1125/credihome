<x-flowbite-layout>
    <div class="mb-6">
        <div class="flex items-center gap-2 mb-2">
            <a href="{{ route('contratos.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Nuevo Contrato</h1>
        </div>
        <p class="text-sm text-gray-600 dark:text-gray-400">Complete la información para crear un nuevo contrato</p>
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

    <form action="{{ route('contratos.store') }}" method="POST" id="contrato-form">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Panel Izquierdo - Datos del Contrato -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Datos del Contrato</h2>

                    <!-- Cliente -->
                    <div class="mb-4">
                        <label for="cliente_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Cliente <span class="text-red-500">*</span>
                        </label>
                        <select name="cliente_id" id="cliente_id" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Seleccionar cliente...</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
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
                            <option value="">Primero seleccione un cliente...</option>
                        </select>
                        <div id="prestamo-info" class="mt-2 text-xs text-gray-500 dark:text-gray-400 hidden">
                            <p>Monto: <span id="prestamo-monto" class="font-semibold"></span></p>
                            <p>Saldo: <span id="prestamo-saldo" class="font-semibold"></span></p>
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
                                <option value="{{ $contratista->id }}" {{ old('contratista_id') == $contratista->id ? 'selected' : '' }}>
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
                        <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" required placeholder="Ej: Contrato de construcción de vivienda" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <!-- Fecha del Contrato -->
                    <div class="mb-4">
                        <label for="fecha_contrato" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Fecha del Contrato <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="fecha_contrato" id="fecha_contrato" value="{{ old('fecha_contrato', date('Y-m-d')) }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <!-- Fechas Inicio/Fin -->
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div>
                            <label for="fecha_inicio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Inicio</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label for="fecha_fin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fin</label>
                            <input type="date" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>

                    <!-- Monto del Contrato -->
                    <div class="mb-4">
                        <label for="monto_contrato" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Monto del Contrato</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400 text-sm">Q</span>
                            </div>
                            <input type="number" name="monto_contrato" id="monto_contrato" value="{{ old('monto_contrato') }}" step="0.01" min="0" placeholder="0.00" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-8 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>

                    <!-- Estado -->
                    <div class="mb-4">
                        <label for="estado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                        <select name="estado" id="estado" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="borrador" {{ old('estado', 'borrador') == 'borrador' ? 'selected' : '' }}>Borrador</option>
                            <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="finalizado" {{ old('estado') == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                            <option value="cancelado" {{ old('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                    </div>

                    <!-- Notas -->
                    <div>
                        <label for="notas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notas Internas</label>
                        <textarea name="notas" id="notas" rows="3" placeholder="Notas internas (no aparecen en el contrato)" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('notas') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Panel Derecho - Editor del Contrato -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Contenido del Contrato</h2>
                        <button type="button" onclick="generarPlantilla()" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-2">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Generar Plantilla
                        </button>
                    </div>

                    <textarea name="contenido" id="contenido-editor">{!! old('contenido') !!}</textarea>
                </div>

                <!-- Botones -->
                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('contratos.index') }}" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">
                        Cancelar
                    </a>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Crear Contrato
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- TinyMCE CDN -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        // Inicializar TinyMCE
        tinymce.init({
            selector: '#contenido-editor',
            height: 600,
            language: 'es',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount pagebreak',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | pagebreak',
            content_style: 'body { font-family: Arial, sans-serif; font-size: 12pt; margin: 2cm; }',
            menubar: 'file edit view insert format tools table',
            branding: false,
            promotion: false,
            setup: function(editor) {
                editor.on('change', function() {
                    editor.save();
                });
            }
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
                        option.dataset.total = p.monto_total;
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

        // Generar plantilla de contrato
        function generarPlantilla() {
            const clienteSelect = document.getElementById('cliente_id');
            const contratistaSelect = document.getElementById('contratista_id');
            const prestamoSelect = document.getElementById('prestamo_id');
            const fechaContrato = document.getElementById('fecha_contrato').value;
            const montoContrato = document.getElementById('monto_contrato').value;

            const clienteNombre = clienteSelect.options[clienteSelect.selectedIndex]?.text || '[NOMBRE DEL CLIENTE]';
            const contratistaNombre = contratistaSelect.options[contratistaSelect.selectedIndex]?.text || '[NOMBRE DEL CONTRATISTA]';
            const prestamoNum = prestamoSelect.options[prestamoSelect.selectedIndex]?.text || '[NÚMERO DE VENTA]';
            const monto = montoContrato ? 'Q' + parseFloat(montoContrato).toLocaleString('es-GT', {minimumFractionDigits: 2}) : '[MONTO]';

            const fecha = fechaContrato ? new Date(fechaContrato + 'T12:00:00').toLocaleDateString('es-GT', { year: 'numeric', month: 'long', day: 'numeric' }) : '[FECHA]';

            const plantilla = `
<h1 style="text-align: center;"><strong>CONTRATO DE SERVICIOS DE CONSTRUCCIÓN</strong></h1>
<p style="text-align: center;">No. ${prestamoNum}</p>
<hr>
<p>En la ciudad de Guatemala, el día <strong>${fecha}</strong>, comparecen por una parte:</p>

<p><strong>PRIMERA PARTE (EL CLIENTE):</strong></p>
<p>${clienteNombre !== 'Seleccionar cliente...' ? clienteNombre : '[NOMBRE DEL CLIENTE]'}, mayor de edad, guatemalteco(a), de este domicilio, quien en adelante se denominará <strong>"EL CLIENTE"</strong>.</p>

<p><strong>SEGUNDA PARTE (EL CONTRATISTA):</strong></p>
<p>${contratistaNombre !== 'Seleccionar contratista...' ? contratistaNombre : '[NOMBRE DEL CONTRATISTA]'}, mayor de edad, guatemalteco(a), de este domicilio, quien en adelante se denominará <strong>"EL CONTRATISTA"</strong>.</p>

<hr>

<h2>CLÁUSULA PRIMERA: OBJETO DEL CONTRATO</h2>
<p>El CONTRATISTA se compromete a ejecutar los trabajos de construcción/remodelación descritos en este contrato, de acuerdo con las especificaciones técnicas y planos aprobados por ambas partes.</p>

<h2>CLÁUSULA SEGUNDA: MONTO DEL CONTRATO</h2>
<p>El valor total del presente contrato es de <strong>${monto}</strong> (en letras: ______________________________ quetzales exactos), que incluye materiales, mano de obra y todos los gastos necesarios para la ejecución completa de la obra.</p>

<h2>CLÁUSULA TERCERA: FORMA DE PAGO</h2>
<p>El pago se realizará de la siguiente manera:</p>
<ul>
<li>Anticipo del ____% al momento de la firma del contrato.</li>
<li>____% al completar el ____% del avance de obra.</li>
<li>____% al completar el ____% del avance de obra.</li>
<li>Saldo final contra entrega total de la obra a satisfacción del CLIENTE.</li>
</ul>

<h2>CLÁUSULA CUARTA: PLAZO DE EJECUCIÓN</h2>
<p>El plazo de ejecución de la obra será de _______ días calendario, contados a partir de la fecha de inicio de los trabajos.</p>

<h2>CLÁUSULA QUINTA: OBLIGACIONES DEL CONTRATISTA</h2>
<ul>
<li>Ejecutar la obra conforme a los planos y especificaciones aprobados.</li>
<li>Proporcionar los materiales de calidad requeridos.</li>
<li>Contar con personal calificado para la ejecución de los trabajos.</li>
<li>Cumplir con las normas de seguridad y medio ambiente vigentes.</li>
<li>Mantener informado al CLIENTE sobre el avance de la obra.</li>
</ul>

<h2>CLÁUSULA SEXTA: OBLIGACIONES DEL CLIENTE</h2>
<ul>
<li>Realizar los pagos en los plazos establecidos.</li>
<li>Proporcionar acceso al sitio de la obra.</li>
<li>Aprobar los cambios o modificaciones solicitados por el CONTRATISTA.</li>
</ul>

<h2>CLÁUSULA SÉPTIMA: GARANTÍAS</h2>
<p>El CONTRATISTA otorga una garantía de ______ meses sobre la obra ejecutada, contados a partir de la fecha de entrega final.</p>

<h2>CLÁUSULA OCTAVA: PENALIDADES</h2>
<p>En caso de incumplimiento del plazo de ejecución, el CONTRATISTA pagará una penalidad del ____% del monto total del contrato por cada día de atraso.</p>

<h2>CLÁUSULA NOVENA: RESOLUCIÓN DE CONTROVERSIAS</h2>
<p>Cualquier controversia derivada del presente contrato será resuelta mediante negociación directa entre las partes. De no llegar a acuerdo, las partes se someterán a los tribunales competentes de la República de Guatemala.</p>

<br>
<br>
<table style="width: 100%;">
<tr>
<td style="width: 50%; text-align: center; padding-top: 60px;">
<p>_______________________________</p>
<p><strong>EL CLIENTE</strong></p>
<p>${clienteNombre !== 'Seleccionar cliente...' ? clienteNombre : '[NOMBRE DEL CLIENTE]'}</p>
</td>
<td style="width: 50%; text-align: center; padding-top: 60px;">
<p>_______________________________</p>
<p><strong>EL CONTRATISTA</strong></p>
<p>${contratistaNombre !== 'Seleccionar contratista...' ? contratistaNombre : '[NOMBRE DEL CONTRATISTA]'}</p>
</td>
</tr>
</table>
`;

            tinymce.get('contenido-editor').setContent(plantilla);
        }

        // Sincronizar TinyMCE antes de enviar
        document.getElementById('contrato-form').addEventListener('submit', function() {
            tinymce.triggerSave();
        });
    </script>
</x-flowbite-layout>
