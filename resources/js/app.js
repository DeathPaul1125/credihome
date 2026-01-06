import './bootstrap';

// Flowbite
import 'flowbite';

// Alpine.js y plugins
import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';

// Gráficos y mapas
import ApexCharts from 'apexcharts';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';

// Configurar Alpine
Alpine.plugin(persist);
window.Alpine = Alpine;
window.ApexCharts = ApexCharts;
Alpine.start();

// Init flatpickr
document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('.datepicker')) {
        flatpickr('.datepicker', {
            mode: 'range',
            dateFormat: 'M j, Y',
            defaultDate: [new Date().setDate(new Date().getDate() - 6), new Date()],
        });
    }
});
