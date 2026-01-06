<x-tailadmin-layout>
    @section('page-title', 'Editar Préstamo')

    <div class="mb-6">
        <h2 class="text-title-md2 font-semibold text-gray-900 dark:text-white">
            Editar Préstamo #{{ $prestamo->numero_prestamo }}
        </h2>
        <p class="text-gray-500 dark:text-gray-400">Actualice la información del préstamo</p>
    </div>

    <form action="{{ route('prestamos.update', $prestamo) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Información del Cliente -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/5">
                <h3 class="mb-6 text-lg font-semibold text-gray-900 dark:text-white">Cliente</h3>

                <div class="space-y-4">
                    <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-800">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Cliente</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $prestamo->cliente->nombre_completo }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $prestamo->cliente->dpi_formateado }}</p>
                    </div>
                </div>
            </div>

            <!-- Detalles del Préstamo -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/5">
                <h3 class="mb-6 text-lg font-semibold text-gray-900 dark:text-white">Detalles del Préstamo</h3>

                <div class="space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Tasa de Interés (%) *</label>
                        <input type="number" name="tasa_interes" value="{{ old('tasa_interes', $prestamo->tasa_interes) }}" step="0.01" min="0" max="100" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('tasa_interes') border-red-500 @enderror">
                        @error('tasa_interes')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Fecha de Desembolso *</label>
                        <input type="date" name="fecha_desembolso" value="{{ old('fecha_desembolso', $prestamo->fecha_desembolso) }}" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('fecha_desembolso') border-red-500 @enderror">
                        @error('fecha_desembolso')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Observaciones</label>
                        <textarea name="observaciones" rows="4" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('observaciones') border-red-500 @enderror">{{ old('observaciones', $prestamo->observaciones) }}</textarea>
                        @error('observaciones')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div class="rounded-lg bg-yellow-50 p-4 dark:bg-yellow-900/20">
                        <p class="text-sm text-yellow-800 dark:text-yellow-300">
                            <strong>Nota:</strong> Solo se pueden editar campos limitados después de la creación. El monto, plazo y frecuencia no se pueden modificar después de aprobar el préstamo.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 flex gap-4">
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-600 px-6 py-3 text-center text-base font-semibold text-white hover:bg-brand-700 focus:outline-none focus:ring-4 focus:ring-brand-300 dark:bg-brand-600 dark:hover:bg-brand-700 dark:focus:ring-brand-800">
                Actualizar Préstamo
            </button>
            <a href="{{ route('prestamos.show', $prestamo) }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-3 text-center text-base font-medium text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                Cancelar
            </a>
        </div>
    </form>
</x-tailadmin-layout>
