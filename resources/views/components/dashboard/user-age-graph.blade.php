<div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
    <header class="px-5 py-4 border-b border-slate-100">
        <h2 class="font-semibold text-slate-800">Users By Age</h2>
    </header>
    <!-- Chart built with Chart.js 3 -->
    <!-- Check out src/js/components/analytics-card-08.js for config -->
    <div class="grow flex flex-col justify-center">
        <div>
            <!-- Change the height attribute to adjust the chart height -->
            <canvas id="analytics-card-9" width="389" height="260"></canvas>
        </div>
        <div id="analytics-card-9-legend" class="px-5 pt-2 pb-6">
            <ul class="flex flex-wrap justify-center -m-1"></ul>
        </div>
    </div>
</div>


<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>

    const analytics09 = () => {
        const ctx = document.getElementById('analytics-card-9');
        if (!ctx) return;


        const updateChart = (result) => {
            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: result.labels,
                    datasets: [
                        {
                            label: 'Users',
                            data: result.data,
                            backgroundColor: [
                                '#4F46E5',
                                '#4BC9FF',
                            ],
                            hoverBackgroundColor: [
                                '#4F46E5',
                                '#4BC9FF',
                            ],
                            // hoverBorderColor: tailwindConfig().theme.colors.white,
                        },
                    ],
                },
                options: {
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                display: true,
                            },
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true,
                            },
                        },
                    },
                    cutout: '80%',
                    layout: {
                        padding: 24,
                    },
                    plugins: {
                        legend: {
                            display: true,
                        },
                        htmlLegend: {
                            // ID of the container to put the legend in
                            containerID: 'analytics-card-9-legend',
                        },
                    },
                    interaction: {
                        intersect: false,
                        mode: 'nearest',
                    },
                    animation: {
                        duration: 200,
                    },
                    maintainAspectRatio: false,
                },
                plugins: [{
                    id: 'htmlLegend',
                }],
            });
        };

        $.ajax({
            url: '/get/users-by-age',
            method: 'GET',
            success: function (response) {
                updateChart(response);
            },
            error: function (error) {
                console.error('Error fetching  data:', error);
            }
        });
    };

    analytics09();

</script>
