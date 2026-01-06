<x-tailadmin-layout>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Breadcrumb -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Detalle del Cliente
            </h2>
            <nav>
                <ol class="flex items-center gap-2">
                    <li>
                        <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
                    </li>
                    <li>
                        <a class="font-medium" href="{{ route('clientes.index') }}">Clientes /</a>
                    </li>
                    <li class="font-medium text-primary">{{ $cliente->nombre_completo }}</li>
                </ol>
            </nav>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Información del Cliente -->
            <div class="lg:col-span-1">
                <div class="rounded-lg border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                        <h3 class="font-semibold text-black dark:text-white">Información Personal</h3>
                    </div>
                    <div class="p-7">
                        <div class="mb-5.5 flex items-center gap-4">
                            <div class="h-20 w-20 rounded-full bg-primary/10 flex items-center justify-center">
                                <svg class="fill-primary" width="40" height="40" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.0002 7.79065C11.0814 7.79065 12.7689 6.1594 12.7689 4.1344C12.7689 2.1094 11.0814 0.478149 9.0002 0.478149C6.91895 0.478149 5.23145 2.1094 5.23145 4.1344C5.23145 6.1594 6.91895 7.79065 9.0002 7.79065Z"/>
                                    <path d="M10.8283 9.05627H7.17207C4.16269 9.05627 1.71582 11.5313 1.71582 14.5406V16.875C1.71582 17.2125 1.99707 17.5219 2.3627 17.5219C2.72832 17.5219 3.00957 17.2407 3.00957 16.875V14.5406C3.00957 12.2344 4.89394 10.3219 7.22832 10.3219H10.8564C13.1627 10.3219 15.0752 12.2063 15.0752 14.5406V16.875C15.0752 17.2125 15.3564 17.5219 15.7221 17.5219C16.0877 17.5219 16.3689 17.2407 16.3689 16.875V14.5406C16.2846 11.5313 13.8377 9.05627 10.8283 9.05627Z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-black dark:text-white">{{ $cliente->nombre_completo }}</h4>
                                <span class="text-sm">
                                    @if($cliente->estado === 'activo')
                                        <span class="inline-flex rounded-full bg-success bg-opacity-10 px-3 py-1 text-sm font-medium text-success">Activo</span>
                                    @elseif($cliente->estado === 'inactivo')
                                        <span class="inline-flex rounded-full bg-warning bg-opacity-10 px-3 py-1 text-sm font-medium text-warning">Inactivo</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-danger bg-opacity-10 px-3 py-1 text-sm font-medium text-danger">Bloqueado</span>
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">DPI</label>
                                <p class="text-body">{{ $cliente->dpi_formateado }}</p>
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Fecha de Nacimiento</label>
                                <p class="text-body">{{ \Carbon\Carbon::parse($cliente->fecha_nacimiento)->format('d/m/Y') }}</p>
                                <p class="text-xs text-body-secondary">{{ \Carbon\Carbon::parse($cliente->fecha_nacimiento)->age }} años</p>
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Género</label>
                                <p class="text-body">{{ ucfirst($cliente->genero) }}</p>
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Estado Civil</label>
                                <p class="text-body">{{ ucfirst($cliente->estado_civil) }}</p>
                            </div>
                        </div>

                        <div class="mt-6 space-y-3 border-t border-stroke pt-6 dark:border-strokedark">
                            <h4 class="font-semibold text-black dark:text-white mb-3">Contacto</h4>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Teléfono</label>
                                <p class="text-body">{{ $cliente->telefono_formateado }}</p>
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Email</label>
                                <p class="text-body">{{ $cliente->email ?? 'No proporcionado' }}</p>
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Dirección</label>
                                <p class="text-body">{{ $cliente->direccion }}</p>
                                <p class="text-xs text-body-secondary">{{ $cliente->municipio }}, {{ $cliente->departamento }}</p>
                            </div>
                        </div>

                        <div class="mt-6 space-y-3 border-t border-stroke pt-6 dark:border-strokedark">
                            <h4 class="font-semibold text-black dark:text-white mb-3">Información Laboral</h4>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Profesión</label>
                                <p class="text-body">{{ $cliente->profesion }}</p>
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black dark:text-white">Ingreso Mensual</label>
                                <p class="text-body font-semibold text-success">Q {{ number_format($cliente->ingreso_mensual, 2) }}</p>
                            </div>
                        </div>

                        <div class="mt-6 flex gap-3">
                            <a href="{{ route('clientes.edit', $cliente) }}" class="flex-1 inline-flex justify-center items-center gap-2 rounded-md bg-primary px-4 py-2 text-center font-medium text-white hover:bg-opacity-90">
                                Editar
                            </a>
                            <a href="{{ route('clientes.index') }}" class="flex-1 inline-flex justify-center items-center gap-2 rounded-md border border-stroke px-4 py-2 text-center font-medium hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4">
                                Volver
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Préstamos y Actividad -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Resumen de Préstamos -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-title-md font-bold text-black dark:text-white">
                                    {{ $cliente->prestamos->count() }}
                                </h4>
                                <span class="text-sm font-medium">Total Préstamos</span>
                            </div>
                            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
                                <svg class="fill-primary dark:fill-white" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                    <path d="M11 0C4.9 0 0 4.9 0 11s4.9 11 11 11 11-4.9 11-11S17.1 0 11 0zm0 20c-5 0-9-4-9-9s4-9 9-9 9 4 9 9-4 9-9 9z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-title-md font-bold text-success dark:text-white">
                                    {{ $cliente->prestamos->whereIn('estado', ['activo', 'en_mora'])->count() }}
                                </h4>
                                <span class="text-sm font-medium">Préstamos Activos</span>
                            </div>
                            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-success bg-opacity-10">
                                <svg class="fill-success" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                    <path d="M11 0C4.9 0 0 4.9 0 11s4.9 11 11 11 11-4.9 11-11S17.1 0 11 0zm0 20c-5 0-9-4-9-9s4-9 9-9 9 4 9 9-4 9-9 9z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-title-md font-bold text-danger dark:text-white">
                                    Q {{ number_format($cliente->prestamos->whereIn('estado', ['activo', 'en_mora'])->sum('saldo_pendiente'), 2) }}
                                </h4>
                                <span class="text-sm font-medium">Saldo Pendiente</span>
                            </div>
                            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-danger bg-opacity-10">
                                <svg class="fill-danger" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                    <path d="M11 0C4.9 0 0 4.9 0 11s4.9 11 11 11 11-4.9 11-11S17.1 0 11 0zm0 20c-5 0-9-4-9-9s4-9 9-9 9 4 9 9-4 9-9 9z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lista de Préstamos -->
                <div class="rounded-lg border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                        <h3 class="font-semibold text-black dark:text-white">Historial de Préstamos</h3>
                    </div>
                    <div class="p-7">
                        @if($cliente->prestamos->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full table-auto">
                                    <thead>
                                        <tr class="bg-gray-2 text-left dark:bg-meta-4">
                                            <th class="px-4 py-3 font-medium text-black dark:text-white">Número</th>
                                            <th class="px-4 py-3 font-medium text-black dark:text-white">Monto</th>
                                            <th class="px-4 py-3 font-medium text-black dark:text-white">Saldo</th>
                                            <th class="px-4 py-3 font-medium text-black dark:text-white">Cuota</th>
                                            <th class="px-4 py-3 font-medium text-black dark:text-white">Estado</th>
                                            <th class="px-4 py-3 font-medium text-black dark:text-white">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cliente->prestamos as $prestamo)
                                            <tr class="border-b border-stroke dark:border-strokedark">
                                                <td class="px-4 py-3">{{ $prestamo->numero_prestamo }}</td>
                                                <td class="px-4 py-3">Q {{ number_format($prestamo->monto_prestado, 2) }}</td>
                                                <td class="px-4 py-3">Q {{ number_format($prestamo->saldo_pendiente, 2) }}</td>
                                                <td class="px-4 py-3">Q {{ number_format($prestamo->monto_cuota, 2) }}</td>
                                                <td class="px-4 py-3">
                                                    @if($prestamo->estado === 'activo')
                                                        <span class="inline-flex rounded-full bg-success bg-opacity-10 px-3 py-1 text-xs font-medium text-success">Activo</span>
                                                    @elseif($prestamo->estado === 'pagado')
                                                        <span class="inline-flex rounded-full bg-primary bg-opacity-10 px-3 py-1 text-xs font-medium text-primary">Pagado</span>
                                                    @elseif($prestamo->estado === 'en_mora')
                                                        <span class="inline-flex rounded-full bg-danger bg-opacity-10 px-3 py-1 text-xs font-medium text-danger">En Mora</span>
                                                    @elseif($prestamo->estado === 'vencido')
                                                        <span class="inline-flex rounded-full bg-warning bg-opacity-10 px-3 py-1 text-xs font-medium text-warning">Vencido</span>
                                                    @else
                                                        <span class="inline-flex rounded-full bg-secondary bg-opacity-10 px-3 py-1 text-xs font-medium text-secondary">{{ ucfirst($prestamo->estado) }}</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3">
                                                    <a href="{{ route('prestamos.show', $prestamo) }}" class="text-primary hover:underline">Ver</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-center text-body py-8">No tiene préstamos registrados</p>
                        @endif
                    </div>
                </div>

                <!-- Referencias Personales -->
                <div class="rounded-lg border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                        <h3 class="font-semibold text-black dark:text-white">Referencias Personales</h3>
                    </div>
                    <div class="p-7">
                        @php
                            $referencias = json_decode($cliente->referencias, true);
                        @endphp
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($referencias as $index => $ref)
                                <div class="rounded-lg border border-stroke p-4 dark:border-strokedark">
                                    <h4 class="font-semibold text-black dark:text-white mb-3">Referencia {{ $index + 1 }}</h4>
                                    <div class="space-y-2">
                                        <div>
                                            <label class="text-xs text-body-secondary">Nombre</label>
                                            <p class="text-body">{{ $ref['nombre'] }}</p>
                                        </div>
                                        <div>
                                            <label class="text-xs text-body-secondary">Parentesco</label>
                                            <p class="text-body">{{ ucfirst($ref['parentesco']) }}</p>
                                        </div>
                                        <div>
                                            <label class="text-xs text-body-secondary">Teléfono</label>
                                            <p class="text-body">{{ $ref['telefono'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tailadmin-layout>
