<x-tailadmin-layout>
    @section('page-title', 'Dashboard - CrediHome GT')

    <!-- Stats Cards - Métricas de Préstamos -->
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5">
        <!-- Card: Préstamos Activos -->
        <div class="rounded-2xl border border-gray-200 bg-white px-7.5 py-6 shadow-sm dark:border-gray-800 dark:bg-white/5">
            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-blue-50 dark:bg-gray-800">
                <svg class="fill-brand-500" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 1.56055C6.06445 1.56055 2.06055 5.59805 2.06055 10.5C2.06055 15.4355 6.06445 19.4395 11 19.4395C15.9355 19.4395 19.9395 15.4355 19.9395 10.5C19.9395 5.59805 15.9355 1.56055 11 1.56055Z"/>
                    <path d="M12.1094 6.42188H9.89062C9.48047 6.42188 9.10938 6.79297 9.10938 7.20312V13.7109H12.1094C12.5195 13.7109 12.8906 14.082 12.8906 14.4922C12.8906 14.9023 12.5195 15.2734 12.1094 15.2734H9.89062C9.48047 15.2734 9.10938 14.9023 9.10938 14.4922V7.20312C9.10938 6.79297 9.48047 6.42188 9.89062 6.42188H12.1094C12.5195 6.42188 12.8906 6.79297 12.8906 7.20312C12.8906 7.61328 12.5195 7.98438 12.1094 7.98438Z"/>
                </svg>
            </div>

            <div class="mt-4 flex items-end justify-between">
                <div>
                    <h4 class="text-title-md font-bold text-gray-900 dark:text-white">
                        156
                    </h4>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Préstamos Activos</span>
                </div>

                <span class="flex items-center gap-1 text-sm font-medium text-green-500">
                    8.5%
                    <svg class="fill-current" width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.35716 2.47737L0.908974 5.82987C0.745401 5.98987 0.745401 6.23987 0.908974 6.39987L1.29647 6.78237C1.46004 6.94237 1.71004 6.94237 1.87361 6.78237L4.99997 3.73237L8.12634 6.78737C8.28991 6.94737 8.53991 6.94737 8.70348 6.78737L9.09098 6.40487C9.25455 6.24487 9.25455 5.99487 9.09098 5.83487L5.64279 2.48237C5.47922 2.31737 5.22922 2.31737 5.06565 2.47737H4.35716Z"/>
                    </svg>
                </span>
            </div>
        </div>

        <!-- Card: Capital Prestado -->
        <div class="rounded-2xl border border-gray-200 bg-white px-7.5 py-6 shadow-sm dark:border-gray-800 dark:bg-white/5">
            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-green-50 dark:bg-gray-800">
                <svg class="fill-green-500" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.13636 10.2456C5.13636 9.56779 5.68687 9.01729 6.36475 9.01729H9.34784C9.75818 9.01729 10.0908 9.34989 10.0908 9.76023C10.0908 10.1706 9.75818 10.5032 9.34784 10.5032H6.36475C6.50583 10.5032 6.62143 10.6188 6.62143 10.7599V16.0882C6.62143 16.2293 6.50583 16.3449 6.36475 16.3449C6.22367 16.3449 6.10806 16.2293 6.10806 16.0882V10.7599C6.10806 10.4942 6.32258 10.2797 6.58831 10.2797H5.87926C5.46892 10.2797 5.13632 9.94707 5.13632 9.53673C5.13632 9.12639 5.46892 8.79379 5.87926 8.79379H9.34784C10.0257 8.79379 10.5762 9.34431 10.5762 10.0221V16.0882C10.5762 16.766 10.0257 17.3166 9.34784 17.3166H6.36475C5.68687 17.3166 5.13636 16.766 5.13636 16.0882V10.2456Z"/>
                    <path d="M12.1364 10.2456C12.1364 9.56779 12.6869 9.01729 13.3648 9.01729H16.3478C16.7582 9.01729 17.0908 9.34989 17.0908 9.76023C17.0908 10.1706 16.7582 10.5032 16.3478 10.5032H13.3648C13.5058 10.5032 13.6214 10.6188 13.6214 10.7599V16.0882C13.6214 16.2293 13.5058 16.3449 13.3648 16.3449C13.2237 16.3449 13.1081 16.2293 13.1081 16.0882V10.7599C13.1081 10.4942 13.3226 10.2797 13.5883 10.2797H12.8793C12.4689 10.2797 12.1363 9.94707 12.1363 9.53673C12.1363 9.12639 12.4689 8.79379 12.8793 8.79379H16.3478C17.0257 8.79379 17.5762 9.34431 17.5762 10.0221V16.0882C17.5762 16.766 17.0257 17.3166 16.3478 17.3166H13.3648C12.6869 17.3166 12.1364 16.766 12.1364 16.0882V10.2456Z"/>
                </svg>
            </div>

            <div class="mt-4 flex items-end justify-between">
                <div>
                    <h4 class="text-title-md font-bold text-gray-900 dark:text-white">
                        Q 2,450,500
                    </h4>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Capital Prestado</span>
                </div>

                <span class="flex items-center gap-1 text-sm font-medium text-green-500">
                    12.5%
                    <svg class="fill-current" width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.35716 2.47737L0.908974 5.82987C0.745401 5.98987 0.745401 6.23987 0.908974 6.39987L1.29647 6.78237C1.46004 6.94237 1.71004 6.94237 1.87361 6.78237L4.99997 3.73237L8.12634 6.78737C8.28991 6.94737 8.53991 6.94737 8.70348 6.78737L9.09098 6.40487C9.25455 6.24487 9.25455 5.99487 9.09098 5.83487L5.64279 2.48237C5.47922 2.31737 5.22922 2.31737 5.06565 2.47737H4.35716Z"/>
                    </svg>
                </span>
            </div>
        </div>

        <!-- Card: Tasa de Recuperación -->
        <div class="rounded-2xl border border-gray-200 bg-white px-7.5 py-6 shadow-sm dark:border-gray-800 dark:bg-white/5">
            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-purple-50 dark:bg-gray-800">
                <svg class="fill-purple-500" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 1C5.47715 1 1 5.47715 1 11C1 16.5228 5.47715 21 11 21C16.5228 21 21 16.5228 21 11C21 5.47715 16.5228 1 11 1ZM15.7071 9.70711L10.7071 14.7071C10.3166 15.0976 9.68342 15.0976 9.29289 14.7071L6.29289 11.7071C5.90237 11.3166 5.90237 10.6834 6.29289 10.2929C6.68342 9.90237 7.31658 9.90237 7.70711 10.2929L10 12.5858L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31658 15.7071 9.70711Z"/>
                </svg>
            </div>

            <div class="mt-4 flex items-end justify-between">
                <div>
                    <h4 class="text-title-md font-bold text-gray-900 dark:text-white">
                        94.2%
                    </h4>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Tasa de Recuperación</span>
                </div>

                <span class="flex items-center gap-1 text-sm font-medium text-green-500">
                    2.1%
                    <svg class="fill-current" width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.35716 2.47737L0.908974 5.82987C0.745401 5.98987 0.745401 6.23987 0.908974 6.39987L1.29647 6.78237C1.46004 6.94237 1.71004 6.94237 1.87361 6.78237L4.99997 3.73237L8.12634 6.78737C8.28991 6.94737 8.53991 6.94737 8.70348 6.78737L9.09098 6.40487C9.25455 6.24487 9.25455 5.99487 9.09098 5.83487L5.64279 2.48237C5.47922 2.31737 5.22922 2.31737 5.06565 2.47737H4.35716Z"/>
                    </svg>
                </span>
            </div>
        </div>

        <!-- Card: Préstamos Vencidos -->
        <div class="rounded-2xl border border-gray-200 bg-white px-7.5 py-6 shadow-sm dark:border-gray-800 dark:bg-white/5">
            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-red-50 dark:bg-gray-800">
                <svg class="fill-red-500" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 1.56055C6.06445 1.56055 2.06055 5.59805 2.06055 10.5C2.06055 15.4355 6.06445 19.4395 11 19.4395C15.9355 19.4395 19.9395 15.4355 19.9395 10.5C19.9395 5.59805 15.9355 1.56055 11 1.56055ZM11 17.9824C6.86133 17.9824 3.51758 14.6387 3.51758 10.5C3.51758 6.36133 6.86133 3.01758 11 3.01758C15.1387 3.01758 18.4824 6.36133 18.4824 10.5C18.4824 14.6387 15.1387 17.9824 11 17.9824Z"/>
                    <path d="M11 5.25C10.5895 5.25 10.25 5.58945 10.25 6V11.25C10.25 11.6605 10.5895 12 11 12C11.4105 12 11.75 11.6605 11.75 11.25V6C11.75 5.58945 11.4105 5.25 11 5.25Z"/>
                    <path d="M11.5781 13.8281C11.4219 13.6719 11.2109 13.5781 11 13.5781C10.7891 13.5781 10.5781 13.6719 10.4219 13.8281C10.2656 13.9844 10.1719 14.1953 10.1719 14.4062C10.1719 14.6172 10.2656 14.8281 10.4219 14.9844C10.5781 15.1406 10.7891 15.2344 11 15.2344C11.2109 15.2344 11.4219 15.1406 11.5781 14.9844C11.7344 14.8281 11.8281 14.6172 11.8281 14.4062C11.8281 14.1953 11.7344 13.9844 11.5781 13.8281Z"/>
                </svg>
            </div>

            <div class="mt-4 flex items-end justify-between">
                <div>
                    <h4 class="text-title-md font-bold text-gray-900 dark:text-white">
                        9
                    </h4>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Préstamos Vencidos</span>
                </div>

                <span class="flex items-center gap-1 text-sm font-medium text-red-500">
                    1.8%
                    <svg class="fill-current" width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.64284 7.69237L9.09102 4.33987C9.25459 4.17987 9.25459 3.92987 9.09102 3.76987L8.70352 3.38737C8.53996 3.22737 8.28996 3.22737 8.12639 3.38737L5.00002 6.43737L1.87365 3.38237C1.71008 3.22237 1.46008 3.22237 1.29652 3.38237L0.909016 3.76487C0.745443 3.92487 0.745443 4.17487 0.909016 4.33487L4.35719 7.68737C4.52076 7.84737 4.77076 7.84737 4.93433 7.68737H5.64284V7.69237Z"/>
                    </svg>
                </span>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="mt-4 grid grid-cols-12 gap-4 md:mt-6 md:gap-6 2xl:mt-7.5 2xl:gap-7.5">
        <!-- Chart One: Préstamos Desembolsados por Mes -->
        <div class="col-span-12 rounded-2xl border border-gray-200 bg-white px-5 pb-5 pt-7.5 shadow-sm dark:border-gray-800 dark:bg-white/5 sm:px-7.5 xl:col-span-8">
            <div class="flex flex-wrap items-start justify-between gap-3 sm:flex-nowrap">
                <div class="flex w-full flex-wrap gap-3 sm:gap-5">
                    <div class="flex min-w-47.5">
                        <span class="mr-2 mt-1 flex h-4 w-full max-w-4 items-center justify-center rounded-full border border-brand-500">
                            <span class="block h-2.5 w-full max-w-2.5 rounded-full bg-brand-500"></span>
                        </span>
                        <div class="w-full">
                            <p class="font-semibold text-brand-500">Préstamos Desembolsados (en Quetzales)</p>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Enero 2025 - Diciembre 2025</p>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div id="chartOne" class="-ml-5"></div>
            </div>
        </div>

        <!-- Chart Two: Estado de Préstamos -->
        <div class="col-span-12 rounded-2xl border border-gray-200 bg-white px-5 pb-5 pt-7.5 shadow-sm dark:border-gray-800 dark:bg-white/5 sm:px-7.5 xl:col-span-4">
            <div class="mb-3 justify-between gap-4 sm:flex">
                <div>
                    <h5 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Estado de Préstamos
                    </h5>
                </div>
            </div>

            <div class="mb-2">
                <div id="chartTwo" class="mx-auto flex justify-center"></div>
            </div>

            <div class="-mx-8 flex flex-wrap items-center justify-center gap-y-3">
                <div class="w-full px-8 sm:w-1/2">
                    <div class="flex w-full items-center">
                        <span class="mr-2 block h-3 w-full max-w-3 rounded-full bg-brand-500"></span>
                        <p class="flex w-full justify-between text-sm font-medium text-gray-900 dark:text-white">
                            <span> Activos </span>
                            <span> 65% </span>
                        </p>
                    </div>
                </div>
                <div class="w-full px-8 sm:w-1/2">
                    <div class="flex w-full items-center">
                        <span class="mr-2 block h-3 w-full max-w-3 rounded-full bg-green-500"></span>
                        <p class="flex w-full justify-between text-sm font-medium text-gray-900 dark:text-white">
                            <span> Pagados </span>
                            <span> 25% </span>
                        </p>
                    </div>
                </div>
                <div class="w-full px-8 sm:w-1/2">
                    <div class="flex w-full items-center">
                        <span class="mr-2 block h-3 w-full max-w-3 rounded-full bg-yellow-400"></span>
                        <p class="flex w-full justify-between text-sm font-medium text-gray-900 dark:text-white">
                            <span> En Mora </span>
                            <span> 8% </span>
                        </p>
                    </div>
                </div>
                <div class="w-full px-8 sm:w-1/2">
                    <div class="flex w-full items-center">
                        <span class="mr-2 block h-3 w-full max-w-3 rounded-full bg-red-500"></span>
                        <p class="flex w-full justify-between text-sm font-medium text-gray-900 dark:text-white">
                            <span> Vencidos </span>
                            <span> 2% </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Próximos Pagos -->
        <div class="col-span-12 rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-white/5">
            <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-800">
                <h4 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Próximos Pagos - Esta Semana
                </h4>
            </div>

            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-gray-50 text-left dark:bg-gray-800">
                                <th class="px-4 py-4 font-medium text-gray-900 dark:text-white">Cliente</th>
                                <th class="px-4 py-4 font-medium text-gray-900 dark:text-white">Monto</th>
                                <th class="px-4 py-4 font-medium text-gray-900 dark:text-white">Fecha</th>
                                <th class="px-4 py-4 font-medium text-gray-900 dark:text-white">Estado</th>
                                <th class="px-4 py-4 font-medium text-gray-900 dark:text-white">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-200 dark:border-gray-800">
                                <td class="px-4 py-4">
                                    <p class="text-gray-900 dark:text-white font-medium">José Ramírez</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">DPI: 2547 85412 0101</p>
                                </td>
                                <td class="px-4 py-4 text-gray-900 dark:text-white">Q 1,200.00</td>
                                <td class="px-4 py-4 text-gray-900 dark:text-white">05/01/2026</td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex rounded-full bg-yellow-50 px-3 py-1 text-sm font-medium text-yellow-600 dark:bg-yellow-900/20 dark:text-yellow-400">
                                        Pendiente
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <button class="text-brand-500 hover:underline">Registrar Pago</button>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 dark:border-gray-800">
                                <td class="px-4 py-4">
                                    <p class="text-gray-900 dark:text-white font-medium">María López</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">DPI: 2548 96325 0101</p>
                                </td>
                                <td class="px-4 py-4 text-gray-900 dark:text-white">Q 850.00</td>
                                <td class="px-4 py-4 text-gray-900 dark:text-white">06/01/2026</td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex rounded-full bg-yellow-50 px-3 py-1 text-sm font-medium text-yellow-600 dark:bg-yellow-900/20 dark:text-yellow-400">
                                        Pendiente
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <button class="text-brand-500 hover:underline">Registrar Pago</button>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 dark:border-gray-800">
                                <td class="px-4 py-4">
                                    <p class="text-gray-900 dark:text-white font-medium">Carlos Mendoza</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">DPI: 2549 74185 0101</p>
                                </td>
                                <td class="px-4 py-4 text-gray-900 dark:text-white">Q 2,500.00</td>
                                <td class="px-4 py-4 text-gray-900 dark:text-white">07/01/2026</td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-sm font-medium text-red-600 dark:bg-red-900/20 dark:text-red-400">
                                        Atrasado
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <button class="text-brand-500 hover:underline">Registrar Pago</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Chart One: Préstamos Desembolsados Mensuales
        const chartOneOptions = {
            series: [{
                name: 'Monto en Quetzales',
                data: [185000, 225000, 195000, 235000, 215000, 245000, 265000, 285000, 305000, 295000, 325000, 345000]
            }],
            chart: {
                height: 335,
                type: 'area',
                toolbar: {
                    show: false
                }
            },
            colors: ['#465FFF'],
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
                categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
            },
            yaxis: {
                labels: {
                    formatter: function(value) {
                        return 'Q ' + (value / 1000).toFixed(0) + 'k';
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function(value) {
                        return 'Q ' + value.toLocaleString('es-GT');
                    }
                }
            }
        };

        const chartOne = new ApexCharts(document.querySelector("#chartOne"), chartOneOptions);
        chartOne.render();

        // Chart Two: Estado de Préstamos
        const chartTwoOptions = {
            series: [65, 25, 8, 2],
            chart: {
                type: 'donut',
                width: 300,
            },
            colors: ['#465FFF', '#10b981', '#facc15', '#ef4444'],
            labels: ['Activos', 'Pagados', 'En Mora', 'Vencidos'],
            legend: {
                show: false
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        background: 'transparent'
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            tooltip: {
                y: {
                    formatter: function(value) {
                        return value + '%';
                    }
                }
            }
        };

        const chartTwo = new ApexCharts(document.querySelector("#chartTwo"), chartTwoOptions);
        chartTwo.render();
    </script>
    @endpush
</x-tailadmin-layout>
