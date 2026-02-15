<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Avance de Mi Proyecto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Navegación del Portal --}}
            <div class="mb-6 bg-white shadow-sm sm:rounded-lg">
                <div class="flex space-x-4 px-6 py-3 overflow-x-auto">
                    <a href="{{ route('portal.dashboard') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('portal.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Inicio
                    </a>
                    <a href="{{ route('portal.mis-comprobantes') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('portal.mis-comprobantes') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Mis Comprobantes
                    </a>
                    <a href="{{ route('portal.mis-avances') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('portal.mis-avances') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Avance del Proyecto
                    </a>
                </div>
            </div>

            {{-- Mensajes --}}
            @if(session('success'))
                <div class="mb-6 rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-gray-800 dark:text-green-400" role="alert">
                    <span class="font-medium">¡Éxito!</span> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">Error:</span> {{ session('error') }}
                </div>
            @endif

            {{-- Tarjeta de Subir Nueva Foto --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Subir Nueva Foto de Avance
                    </h3>

                    <form action="{{ route('portal.guardar-avance') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Préstamo Asociado --}}
                            <div>
                                <label for="prestamo_id" class="block mb-2 text-sm font-medium text-gray-900">
                                    Venta Asociada (Opcional)
                                </label>
                                <select name="prestamo_id" id="prestamo_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="">Sin asociar a venta específica</option>
                                    @foreach($prestamos as $prestamo)
                                        <option value="{{ $prestamo->id }}" {{ old('prestamo_id') == $prestamo->id ? 'selected' : '' }}>
                                            {{ $prestamo->numero_prestamo }} - Q{{ number_format($prestamo->saldo_pendiente, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('prestamo_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Fecha del Avance --}}
                            <div>
                                <label for="fecha_avance" class="block mb-2 text-sm font-medium text-gray-900">
                                    Fecha del Avance <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="fecha_avance" id="fecha_avance" value="{{ old('fecha_avance', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @error('fecha_avance')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Título --}}
                            <div>
                                <label for="titulo" class="block mb-2 text-sm font-medium text-gray-900">
                                    Título <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" required placeholder="Ej: Construcción de paredes" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @error('titulo')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Porcentaje de Avance --}}
                            <div>
                                <label for="porcentaje_avance" class="block mb-2 text-sm font-medium text-gray-900">
                                    Porcentaje de Avance (Opcional)
                                </label>
                                <div class="flex items-center">
                                    <input type="number" name="porcentaje_avance" id="porcentaje_avance" value="{{ old('porcentaje_avance') }}" min="0" max="100" step="0.01" placeholder="50" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <span class="ml-2 text-gray-600">%</span>
                                </div>
                                @error('porcentaje_avance')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Descripción --}}
                        <div>
                            <label for="descripcion" class="block mb-2 text-sm font-medium text-gray-900">
                                Descripción
                            </label>
                            <textarea name="descripcion" id="descripcion" rows="3" placeholder="Describe el avance realizado..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Imagen --}}
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">
                                Imagen <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center justify-center w-full">
                                <label for="imagen" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click para subir</span> o arrastra la imagen</p>
                                        <p class="text-xs text-gray-500">PNG, JPG o JPEG (MAX. 10MB)</p>
                                    </div>
                                    <input id="imagen" name="imagen" type="file" accept="image/*" required class="hidden" onchange="previewImage(event)" />
                                </label>
                            </div>
                            <div id="preview" class="mt-4 hidden">
                                <img id="preview-img" class="max-h-64 rounded-lg mx-auto" alt="Preview">
                            </div>
                            @error('imagen')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Subir Foto
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Galería de Fotos --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Galería de Avances del Proyecto
                    </h3>

                    @if($fotos->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($fotos as $foto)
                                <div class="border border-gray-200 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                                    <div class="aspect-w-16 aspect-h-12 bg-gray-200">
                                        <img src="{{ asset('storage/' . $foto->ruta_imagen) }}" alt="{{ $foto->titulo }}" class="w-full h-64 object-cover">
                                    </div>
                                    <div class="p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="font-semibold text-gray-900">{{ $foto->titulo }}</h4>
                                            @if($foto->estado === 'aprobado')
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Aprobado
                                                </span>
                                            @elseif($foto->estado === 'rechazado')
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Rechazado</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Pendiente</span>
                                            @endif
                                        </div>
                                        
                                        @if($foto->descripcion)
                                            <p class="text-sm text-gray-600 mb-2">{{ Str::limit($foto->descripcion, 80) }}</p>
                                        @endif

                                        <div class="text-xs text-gray-500 space-y-1">
                                            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($foto->fecha_avance)->format('d/m/Y') }}</p>
                                            @if($foto->porcentaje_avance)
                                                <p><strong>Avance:</strong> {{ number_format($foto->porcentaje_avance, 0) }}%</p>
                                            @endif
                                            @if($foto->prestamo)
                                                <p><strong>Venta:</strong> {{ $foto->prestamo->numero_prestamo }}</p>
                                            @endif
                                        </div>

                                        @if($foto->comentario_admin)
                                            <div class="mt-2 p-2 bg-blue-50 rounded text-xs">
                                                <p class="text-blue-800"><strong>Comentario:</strong> {{ $foto->comentario_admin }}</p>
                                            </div>
                                        @endif

                                        @if($foto->estado === 'pendiente')
                                            <div class="mt-3 flex justify-end">
                                                <form action="{{ route('portal.eliminar-avance', $foto->id) }}" method="POST" onsubmit="return confirm('¿Está seguro de eliminar esta foto?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm">
                                                        <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Paginación --}}
                        <div class="mt-6">
                            {{ $fotos->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="mt-2 text-gray-500">No has subido fotos de avance todavía.</p>
                            <p class="text-sm text-gray-400">Sube tu primera foto usando el formulario de arriba.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('preview');
                const previewImg = document.getElementById('preview-img');
                previewImg.src = reader.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-app-layout>
