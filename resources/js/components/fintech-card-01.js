    // Import Chart.js
    import {
        Chart,
        LineController,
        LineElement,
        Filler,
        PointElement,
        LinearScale,
        TimeScale,
        Tooltip,
    } from 'chart.js';

    // Import utilities
    import {
        tailwindConfig,
        hexToRGB
    } from '../utils';

    Chart.register(LineController, LineElement, Filler, PointElement, LinearScale, TimeScale, Tooltip);

    // A chart built with Chart.js 3
    const fintechCard01 = () => {
        const ctx = document.getElementById('fintech-card-01');
        if (!ctx) return;
        fetch('/get-sales-data')
            .then(a => {
                return a.json();
            })
            .then(result => {
                const dailyData = result.daily.data;
                const yearlyData = result.yearly.data;
                const monthlyData = result.monthly.data;

                const chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [], // Labels will be set dynamically based on the selected scale.
                        datasets: [{
                                label: 'Yearly Sales',
                                data: [],
                                borderColor: tailwindConfig().theme.colors.indigo[500],
                                fill: false,
                                borderWidth: 2,
                                tension: 0,
                                pointRadius: 0,
                                pointHoverRadius: 3,
                                pointBackgroundColor: tailwindConfig().theme.colors.indigo[500],
                                clip: 20,
                            },
                            {
                                label: 'Monthly Sales',
                                data: [],
                                borderColor: tailwindConfig().theme.colors.amber[400],
                                borderDash: [4, 4],
                                fill: false,
                                borderWidth: 2,
                                tension: 0,
                                pointRadius: 0,
                                pointHoverRadius: 3,
                                pointBackgroundColor: tailwindConfig().theme.colors.amber[400],
                                clip: 20,
                            },
                            {
                                label: 'Daily Sales',
                                data: [],
                                borderColor: tailwindConfig().theme.colors.slate[300],
                                fill: false,
                                borderWidth: 2,
                                tension: 0,
                                pointRadius: 0,
                                pointHoverRadius: 3,
                                pointBackgroundColor: tailwindConfig().theme.colors.slate[300],
                                clip: 20,
                            },
                        ],
                    },
                    options: {
                        layout: {
                            padding: 20,
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    drawBorder: false,
                                },
                                ticks: {
                                    maxTicksLimit: 7,
                                },
                            },
                            x: {
                                type: 'time',

                                grid: {
                                    display: false,
                                    drawBorder: false,
                                },
                            },
                        },
                        plugins: {
                            legend: {
                                display: true,
                                onClick: () => {}, // Prevent clicking on the legend to hide/show datasets
                            },
                            htmlLegend: {
                                containerID: 'fintech-card-01-legend',
                            },
                            tooltip: {
                                callbacks: {
                                    title: () => false,
                                    label: (context) => context.parsed.y,
                                },
                            },
                        },
                        interaction: {
                            intersect: false,
                            mode: 'nearest',
                        },
                        maintainAspectRatio: false,
                    },
                    plugins: [{
                        id: 'htmlLegend',
                        afterUpdate(c, args, options) {
                            // Your legend creation code remains the same.
                            // ...
                        },
                    }, ],
                });

                // Function to generate labels based on the selected scale
                function generateLabels(scaleType,result) {
                    console.log(result);
                    if (scaleType === 'year') {
                        return result.yearly.labels;
                    } else if (scaleType === 'month') {
                        // Generate labels for the last 12 months
                        return result.monthly.labels;

                    } else if (scaleType === 'day') {
                        return result.daily.labels;

                    }
                    return [];
                }

                // Function to update the chart based on the selected scale
                function updateChart(scaleType, data,result) {
                    chart.data.labels = generateLabels(scaleType,result);
                    chart.data.datasets[0].data = scaleType === 'year' ? data.yearlyData : [];
                    chart.data.datasets[1].data = scaleType === 'month' ? data.monthlyData : [];
                    chart.data.datasets[2].data = scaleType === 'day' ? data.dailyData : [];
                    chart.options.scales.x.time.unit = scaleType;
                    chart.update();
                }



                // Sample data for different scales (Yearly, Monthly, Daily)
                const data = {
                    yearlyData,
                    monthlyData,
                    dailyData,
                };

                // Initial chart rendering with yearly scale
                updateChart('year', data, result);

                // Event listener to switch between scales (Yearly, Monthly, Daily)
                const scaleButtons = document.querySelectorAll('#scale-buttons button');
                scaleButtons.forEach((button) => {
                    button.addEventListener('click', (event) => {
                        const scaleType = event.target.dataset.scale;
                        if(scaleType == "day")
                        {
                            document.getElementById("totalSales").innerHTML =   "SAR "+ result.daily.totalSales;
                        }else if(scaleType == "month")
                        {
                            document.getElementById("totalSales").innerHTML =   "SAR "+result.monthly.totalSales;
                        }else {

                            document.getElementById("totalSales").innerHTML =   "SAR "+result.yearly.totalSales;
                        }
                        console.log(result);
                        updateChart(scaleType, data,result);
                    });
                });
            });
    };

    export default fintechCard01;
