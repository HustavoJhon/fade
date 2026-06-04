import './bootstrap';

const fullCalendarPromise = import('fullcalendar').then((mod) => {
    window.FullCalendar = mod;
    return mod;
});

document.addEventListener('DOMContentLoaded', function () {
    initDarkMode();
    initFullCalendar();
    initCharts();
});

function initDarkMode() {
    if (localStorage.getItem('darkMode') === 'true') {
        document.documentElement.classList.add('dark');
    } else if (localStorage.getItem('darkMode') === 'false') {
        document.documentElement.classList.remove('dark');
    } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
        document.documentElement.classList.add('dark');
    }

    document.querySelectorAll('[data-toggle-dark]').forEach(btn => {
        btn.addEventListener('click', () => {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', isDark);
        });
    });
}

function initFullCalendar() {
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;
}

function initCharts() {
    const revenueChartEl = document.getElementById('revenueChart');
    const servicesChartEl = document.getElementById('servicesChart');

    if (!revenueChartEl && !servicesChartEl) return;

    import('chart.js').then(({ Chart, CategoryScale, LinearScale, PointElement, LineElement, BarElement, ArcElement, Title, Tooltip, Legend, Filler, LineController, DoughnutController }) => {
        Chart.register(CategoryScale, LinearScale, PointElement, LineElement, BarElement, ArcElement, Title, Tooltip, Legend, Filler, LineController, DoughnutController);

        if (revenueChartEl) {
            const ctx = revenueChartEl.getContext('2d');
            const data = JSON.parse(revenueChartEl.dataset.chart || '{}');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels || [],
                    datasets: [{
                        label: 'Ingresos',
                        data: data.values || [],
                        borderColor: '#B8860B',
                        backgroundColor: 'rgba(184, 134, 11, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#B8860B',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1a1a2e',
                            titleColor: '#FFFBF5',
                            bodyColor: '#FFFBF5',
                            padding: 12,
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#9CA3AF' }
                        },
                        y: {
                            grid: { color: 'rgba(156, 163, 175, 0.1)' },
                            ticks: {
                                color: '#9CA3AF',
                                callback: function (value) { return '$' + value.toLocaleString(); }
                            }
                        }
                    }
                }
            });
        }

        if (servicesChartEl) {
            const ctx = servicesChartEl.getContext('2d');
            const data = JSON.parse(servicesChartEl.dataset.chart || '{}');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data.labels || [],
                    datasets: [{
                        data: data.values || [],
                        backgroundColor: ['#B8860B', '#C8A951', '#D4A843', '#8B6508', '#1a1a2e', '#2D2D2D'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#9CA3AF',
                                padding: 16,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        }
    });
}
