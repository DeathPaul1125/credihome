<x-tailadmin-layout>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Breadcrumb -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-semibold text-black dark:text-white">
                Dashboard
            </h2>
            <nav>
                <ol class="flex items-center gap-2">
                    <li>
                        <a href="{{ route('dashboard') }}" class="font-medium">Sistema de Préstamos /</a>
                    </li>
                    <li class="font-medium text-primary">Dashboard</li>
                </ol>
            </nav>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5">
            <!-- Card Clientes -->
            <div class="rounded-sm border border-stroke bg-white px-7.5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
                    <svg class="fill-primary dark:fill-white" width="22" height="18" viewBox="0 0 22 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.18418 8.03751C9.31543 8.03751 11.0686 6.35313 11.0686 4.25626C11.0686 2.15938 9.31543 0.475006 7.18418 0.475006C5.05293 0.475006 3.2998 2.15938 3.2998 4.25626C3.2998 6.35313 5.05293 8.03751 7.18418 8.03751ZM7.18418 2.05626C8.45605 2.05626 9.52168 3.05313 9.52168 4.29063C9.52168 5.52813 8.49043 6.52501 7.18418 6.52501C5.87793 6.52501 4.84668 5.52813 4.84668 4.29063C4.84668 3.05313 5.9123 2.05626 7.18418 2.05626Z"/>
                        <path d="M15.8124 9.6875C17.6687 9.6875 19.1468 8.24375 19.1468 6.42188C19.1468 4.6 17.6343 3.15625 15.8124 3.15625C13.9905 3.15625 12.478 4.6 12.478 6.42188C12.478 8.24375 13.9905 9.6875 15.8124 9.6875ZM15.8124 4.7375C16.8093 4.7375 17.5999 5.49375 17.5999 6.45625C17.5999 7.41875 16.8093 8.175 15.8124 8.175C14.8155 8.175 14.0249 7.41875 14.0249 6.45625C14.0249 5.49375 14.8155 4.7375 15.8124 4.7375Z"/>
                        <path d="M15.9843 10.0313H15.6749C14.6437 10.0313 13.6468 10.3406 12.7874 10.8563C11.8593 9.61876 10.3812 8.79376 8.73115 8.79376H5.67178C2.85303 8.82814 0.618652 11.0625 0.618652 13.8469V16.3219C0.618652 16.975 1.13428 17.4906 1.7874 17.4906H20.2468C20.8999 17.4906 21.4499 16.9406 21.4499 16.2875V15.4625C21.4155 12.4719 18.9749 10.0313 15.9843 10.0313ZM2.16553 15.9438V13.8469C2.16553 11.9219 3.74678 10.3406 5.67178 10.3406H8.73115C10.6562 10.3406 12.2374 11.9219 12.2374 13.8469V15.9438H2.16553V15.9438ZM19.8687 15.9438H13.7499V13.8469C13.7499 13.2969 13.6468 12.7469 13.4749 12.2313C14.0937 11.7844 14.8499 11.5781 15.6405 11.5781H15.9499C18.0812 11.5781 19.8343 13.3313 19.8343 15.4625V15.9438H19.8687Z"/>
                    </svg>
                </div>

                <div class="mt-4 flex items-end justify-between">
                    <div>
                        <h4 class="text-title-md font-bold text-black dark:text-white">
                            {{ number_format($totalClientes) }}
                        </h4>
                        <span class="text-sm font-medium">Clientes Activos</span>
                    </div>
                </div>
            </div>

            <!-- Card Préstamos -->
            <div class="rounded-sm border border-stroke bg-white px-7.5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
                    <svg class="fill-primary dark:fill-white" width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.7531 16.4312C10.3781 16.4312 9.27808 17.5312 9.27808 18.9062C9.27808 20.2812 10.3781 21.3812 11.7531 21.3812C13.1281 21.3812 14.2281 20.2812 14.2281 18.9062C14.2281 17.5656 13.0937 16.4312 11.7531 16.4312ZM11.7531 19.8687C11.2375 19.8687 10.825 19.4562 10.825 18.9406C10.825 18.425 11.2375 18.0125 11.7531 18.0125C12.2687 18.0125 12.6812 18.425 12.6812 18.9406C12.6812 19.4219 12.2343 19.8687 11.7531 19.8687Z"/>
                        <path d="M5.22183 16.4312C3.84683 16.4312 2.74683 17.5312 2.74683 18.9062C2.74683 20.2812 3.84683 21.3812 5.22183 21.3812C6.59683 21.3812 7.69683 20.2812 7.69683 18.9062C7.69683 17.5656 6.56245 16.4312 5.22183 16.4312ZM5.22183 19.8687C4.7062 19.8687 4.2937 19.4562 4.2937 18.9406C4.2937 18.425 4.7062 18.0125 5.22183 18.0125C5.73745 18.0125 6.14995 18.425 6.14995 18.9406C6.14995 19.4219 5.73745 19.8687 5.22183 19.8687Z"/>
                        <path d="M19.0062 0.618744H17.15C16.325 0.618744 15.6031 1.23749 15.5 2.06249L14.95 6.01562H1.37185C1.0281 6.01562 0.684353 6.18749 0.443728 6.46249C0.237478 6.73749 0.134353 7.11562 0.237478 7.45937C0.237478 7.49374 0.237478 7.49374 0.237478 7.52812L2.36873 13.9562C2.50623 14.4375 2.9531 14.7812 3.46873 14.7812H12.9562C14.2281 14.7812 15.3281 13.8187 15.5 12.5469L16.9437 2.26874C16.9437 2.19999 17.0125 2.16562 17.0812 2.16562H18.9375C19.35 2.16562 19.7281 1.82187 19.7281 1.37499C19.7281 0.928119 19.4187 0.618744 19.0062 0.618744ZM14.0219 12.3062C13.9531 12.8219 13.5062 13.2 12.9906 13.2H3.7781L1.92185 7.56249H14.7094L14.0219 12.3062Z"/>
                    </svg>
                </div>

                <div class="mt-4 flex items-end justify-between">
                    <div>
                        <h4 class="text-title-md font-bold text-black dark:text-white">
                            {{ number_format($prestamosActivos) }}
                        </h4>
                        <span class="text-sm font-medium">Préstamos Activos</span>
                    </div>
                </div>
            </div>

            <!-- Card Cartera -->
            <div class="rounded-sm border border-stroke bg-white px-7.5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
                    <svg class="fill-primary dark:fill-white" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.1063 18.0469L19.3875 3.23126C19.2157 1.71876 17.9438 0.584381 16.3969 0.584381H5.56878C4.05628 0.584381 2.78441 1.71876 2.57816 3.23126L0.859406 18.0469C0.756281 18.9063 1.03128 19.7313 1.61566 20.3844C2.20003 21.0375 3.02816 21.3813 3.96878 21.3813H18.0969C19.0719 21.3813 19.8657 21.0031 20.4157 20.3844C21.0313 19.7656 21.3063 18.9063 21.1063 18.0469ZM19.2157 19.3531C18.9407 19.6625 18.5625 19.8344 18.0969 19.8344H3.96878C3.50316 19.8344 3.12503 19.6625 2.84378 19.3531C2.56253 19.0438 2.41566 18.6313 2.49066 18.1875L4.20628 3.43751C4.30316 2.71876 4.91566 2.16563 5.66566 2.16563H16.4313C17.1813 2.16563 17.7938 2.71876 17.8563 3.43751L19.5719 18.2219C19.6125 18.6656 19.4969 19.0438 19.2157 19.3531Z"/>
                        <path d="M14.3345 5.29375C13.922 5.39688 13.647 5.80938 13.7501 6.22188C13.7845 6.42813 13.8189 6.63438 13.8189 6.80625C13.8189 8.35313 12.547 9.625 11.0001 9.625C9.45327 9.625 8.18139 8.35313 8.18139 6.80625C8.18139 6.6 8.21577 6.42813 8.25014 6.22188C8.35327 5.80938 8.07827 5.39688 7.66577 5.29375C7.25327 5.19063 6.84077 5.46563 6.73764 5.87813C6.66577 6.1875 6.63139 6.49688 6.63139 6.80625C6.63139 9.2125 8.5939 11.175 11.0001 11.175C13.4064 11.175 15.3689 9.2125 15.3689 6.80625C15.3689 6.49688 15.3345 6.1875 15.2626 5.87813C15.1595 5.46563 14.747 5.225 14.3345 5.29375Z"/>
                    </svg>
                </div>

                <div class="mt-4 flex items-end justify-between">
                    <div>
                        <h4 class="text-title-md font-bold text-black dark:text-white">
                            Q {{ number_format($carteraTotal, 2) }}
                        </h4>
                        <span class="text-sm font-medium">Cartera Total</span>
                    </div>
                </div>
            </div>

            <!-- Card Pagos -->
            <div class="rounded-sm border border-stroke bg-white px-7.5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
                    <svg class="fill-primary dark:fill-white" width="22" height="16" viewBox="0 0 22 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 15.1156C4.19376 15.1156 0.825012 8.61876 0.687512 8.34376C0.584387 8.13751 0.584387 7.86251 0.687512 7.65626C0.825012 7.38126 4.19376 0.918762 11 0.918762C17.8063 0.918762 21.175 7.38126 21.3125 7.65626C21.4156 7.86251 21.4156 8.13751 21.3125 8.34376C21.175 8.61876 17.8063 15.1156 11 15.1156ZM2.26876 8.00001C3.02501 9.27189 5.98126 13.5688 11 13.5688C16.0188 13.5688 18.975 9.27189 19.7313 8.00001C18.975 6.72814 16.0188 2.43126 11 2.43126C5.98126 2.43126 3.02501 6.72814 2.26876 8.00001Z"/>
                        <path d="M11 10.9219C9.38438 10.9219 8.07812 9.61562 8.07812 8C8.07812 6.38438 9.38438 5.07812 11 5.07812C12.6156 5.07812 13.9219 6.38438 13.9219 8C13.9219 9.61562 12.6156 10.9219 11 10.9219ZM11 6.625C10.2437 6.625 9.625 7.24375 9.625 8C9.625 8.75625 10.2437 9.375 11 9.375C11.7563 9.375 12.375 8.75625 12.375 8C12.375 7.24375 11.7563 6.625 11 6.625Z"/>
                    </svg>
                </div>

                <div class="mt-4 flex items-end justify-between">
                    <div>
                        <h4 class="text-title-md font-bold text-black dark:text-white">
                            Q {{ number_format($pagosHoy, 2) }}
                        </h4>
                        <span class="text-sm font-medium">Cobrado Hoy</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Tables -->
        <div class="mt-4 grid grid-cols-12 gap-4 md:mt-6 md:gap-6 2xl:mt-7.5 2xl:gap-7.5">
            <!-- Chart Pagos 7 días -->
            <div class="col-span-12 rounded-sm border border-stroke bg-white px-5 pb-5 pt-7.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:col-span-8">
                <div class="mb-3 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h5 class="text-xl font-semibold text-black dark:text-white">
                            Pagos de los Últimos 7 Días
                        </h5>
                    </div>
                </div>

                <div class="mb-2">
                    <div id="chartOne" class="-ml-5"></div>
                </div>
            </div>

            <!-- Cartera por Estado -->
            <div class="col-span-12 rounded-sm border border-stroke bg-white p-7.5 shadow-default dark:border-strokedark dark:bg-boxdark xl:col-span-4">
                <div class="mb-4 justify-between gap-4 sm:flex">
                    <div>
                        <h5 class="text-xl font-semibold text-black dark:text-white">
                            Cartera por Estado
                        </h5>
                    </div>
                </div>

                <div class="mb-2">
                    <div id="chartTwo" class="mx-auto flex justify-center"></div>
                </div>

                <div class="-mx-8 flex flex-wrap items-center justify-center gap-y-3">
                    @foreach($prestamosPorEstado as $estado)
                        <div class="w-full px-8 sm:w-1/2">
                            <div class="flex w-full items-center">
                                <span class="mr-2 block h-3 w-full max-w-3 rounded-full
                                    @if($estado->estado === 'activo') bg-success
                                    @elseif($estado->estado === 'pagado') bg-primary
                                    @elseif($estado->estado === 'en_mora') bg-danger
                                    @elseif($estado->estado === 'vencido') bg-warning
                                    @else bg-meta-3
                                    @endif"></span>
                                <p class="flex w-full justify-between text-sm font-medium text-black dark:text-white">
                                    <span>{{ ucfirst(str_replace('_', ' ', $estado->estado)) }}</span>
                                    <span>{{ $estado->total }}</span>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Tabla Préstamos Recientes -->
            <div class="col-span-12 rounded-sm border border-stroke bg-white px-5 pb-5 pt-7.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:col-span-7">
                <div class="mb-5 flex items-center justify-between">
                    <h4 class="text-xl font-semibold text-black dark:text-white">
                        Préstamos Recientes
                    </h4>
                    <a href="{{ route('prestamos.create') }}" class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2 text-center font-medium text-white hover:bg-opacity-90 lg:px-5">
                        Nuevo
                    </a>
                </div>

                <div class="flex flex-col">
                    <div class="grid grid-cols-3 rounded-sm bg-gray-2 dark:bg-meta-4 sm:grid-cols-5">
                        <div class="p-2.5 xl:p-5">
                            <h5 class="text-sm font-medium uppercase xsm:text-base">Cliente</h5>
                        </div>
                        <div class="p-2.5 text-center xl:p-5">
                            <h5 class="text-sm font-medium uppercase xsm:text-base">Número</h5>
                        </div>
                        <div class="p-2.5 text-center xl:p-5">
                            <h5 class="text-sm font-medium uppercase xsm:text-base">Monto</h5>
                        </div>
                        <div class="hidden p-2.5 text-center sm:block xl:p-5">
                            <h5 class="text-sm font-medium uppercase xsm:text-base">Estado</h5>
                        </div>
                        <div class="hidden p-2.5 text-center sm:block xl:p-5">
                            <h5 class="text-sm font-medium uppercase xsm:text-base">Fecha</h5>
                        </div>
                    </div>

                    @forelse($prestamosRecientes as $prestamo)
                        <div class="grid grid-cols-3 border-b border-stroke dark:border-strokedark sm:grid-cols-5">
                            <div class="flex items-center gap-3 p-2.5 xl:p-5">
                                <p class="text-black dark:text-white sm:block">
                                    <a href="{{ route('prestamos.show', $prestamo) }}" class="hover:text-primary">
                                        {{ $prestamo->cliente->nombre_completo }}
                                    </a>
                                </p>
                            </div>

                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <p class="text-black dark:text-white">{{ $prestamo->numero_prestamo }}</p>
                            </div>

                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <p class="text-meta-3">Q {{ number_format($prestamo->monto_prestado, 0) }}</p>
                            </div>

                            <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                                <p class="inline-flex rounded-full bg-opacity-10 px-3 py-1 text-sm font-medium
                                    @if($prestamo->estado === 'activo') bg-success text-success
                                    @elseif($prestamo->estado === 'pagado') bg-primary text-primary
                                    @elseif($prestamo->estado === 'en_mora') bg-danger text-danger
                                    @else bg-warning text-warning
                                    @endif">
                                    {{ ucfirst($prestamo->estado) }}
                                </p>
                            </div>

                            <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                                <p class="text-black dark:text-white">{{ $prestamo->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-10">
                            <svg class="mb-3 h-16 w-16 text-meta-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-black dark:text-white">No hay préstamos recientes</p>
                            <a href="{{ route('prestamos.create') }}" class="mt-4 inline-flex items-center justify-center rounded-md bg-primary px-6 py-2.5 text-center font-medium text-white hover:bg-opacity-90">
                                Crear primer préstamo
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Tabla Pagos Recientes -->
            <div class="col-span-12 rounded-sm border border-stroke bg-white px-5 pb-5 pt-7.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:col-span-5">
                <div class="mb-5 flex items-center justify-between">
                    <h4 class="text-xl font-semibold text-black dark:text-white">
                        Pagos Recientes
                    </h4>
                    <a href="{{ route('pagos.create') }}" class="inline-flex items-center justify-center rounded-md bg-success px-4 py-2 text-center font-medium text-white hover:bg-opacity-90 lg:px-5">
                        Registrar
                    </a>
                </div>

                <div class="flex flex-col">
                    @forelse($pagosRecientes as $pago)
                        <div class="flex items-center justify-between border-b border-stroke py-4 dark:border-strokedark">
                            <div class="flex-1">
                                <h5 class="font-medium text-black dark:text-white">
                                    <a href="{{ route('pagos.show', $pago) }}" class="hover:text-primary">
                                        {{ $pago->cliente->nombre_completo }}
                                    </a>
                                </h5>
                                <p class="text-sm">{{ $pago->numero_recibo }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium text-meta-3">Q {{ number_format($pago->monto_pagado, 2) }}</p>
                                <p class="text-sm">{{ $pago->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-10">
                            <svg class="mb-3 h-16 w-16 text-meta-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <p class="text-black dark:text-white">No hay pagos recientes</p>
                            <a href="{{ route('pagos.create') }}" class="mt-4 inline-flex items-center justify-center rounded-md bg-success px-6 py-2.5 text-center font-medium text-white hover:bg-opacity-90">
                                Registrar primer pago
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Chart Pagos 7 días
        const chartOneOptions = {
            series: [{
                name: 'Pagos',
                data: @json($diasCompletos->pluck('total'))
            }],
            chart: {
                height: 335,
                type: 'area',
                fontFamily: 'Satoshi, sans-serif',
                toolbar: {
                    show: false
                }
            },
            colors: ['#3C50E0'],
            stroke: {
                curve: 'smooth',
                width: 2
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [20, 100, 100, 100]
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: @json($diasCompletos->map(fn($d) => \Carbon\Carbon::parse($d['fecha'])->format('d M'))),
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                }
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return 'Q' + value.toFixed(0);
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function (value) {
                        return 'Q' + value.toFixed(2);
                    }
                }
            },
            grid: {
                xaxis: {
                    lines: {
                        show: true
                    }
                },
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            }
        };

        const chartOne = new ApexCharts(document.querySelector("#chartOne"), chartOneOptions);
        chartOne.render();

        // Chart Cartera por Estado
        const chartTwoOptions = {
            series: @json($prestamosPorEstado->pluck('total')),
            chart: {
                type: 'donut',
                width: 300,
                fontFamily: 'Satoshi, sans-serif',
            },
            colors: ['#10B981', '#3C50E0', '#DC2626', '#F59E0B', '#64748B'],
            labels: @json($prestamosPorEstado->map(fn($e) => ucfirst(str_replace('_', ' ', $e->estado)))),
            legend: {
                show: false
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        background: 'transparent',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                showAlways: true,
                                label: 'Total',
                                fontSize: '16px',
                                fontWeight: '400',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                }
                            },
                            value: {
                                show: true,
                                fontSize: '28px',
                                fontWeight: 'bold'
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            responsive: [{
                breakpoint: 640,
                options: {
                    chart: {
                        width: 200
                    }
                }
            }]
        };

        const chartTwo = new ApexCharts(document.querySelector("#chartTwo"), chartTwoOptions);
        chartTwo.render();
    </script>
    @endpush
</x-tailadmin-layout>
