<!-- Pie chart (Portfolio Value) -->
<div
    class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
    <header class="px-5 py-4 border-b border-slate-100 flex items-center">
        <h2 class="font-semibold text-slate-800">Sales</h2>
    </header>
    <div class="px-5 py-3">
        <div class="text-sm italic mb-2">Total Sales</div>
        {{--        <div class="text-3xl font-bold text-slate-800">{{$data['totalSalesAmount']}} SAR</div>--}}
        <div class="text-3xl font-bold text-slate-800" id="totalSalesAmount">Loading...</div>
    </div>
    <!-- Chart built with Chart.js 3 -->
    <!-- Check out src/js/components/fintech-card-09.js for config -->
    <div class="grow flex flex-col justify-center">
        <div>
            <!-- Change the height attribute to adjust the chart height -->
            <canvas id="fintech-card-09" width="389" height="220"></canvas>
        </div>
        <div id="fintech-card-09-legend" class="px-5 py-4">
            <ul class="flex flex-wrap justify-center -m-1"></ul>
        </div>
    </div>
</div>


<!-- modal -->

<div id="myModal" class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 hidden transition-opacity">
    <!-- Modal Dialog -->
    <div class="fixed inset-0 z-50 overflow-hidden flex items-center justify-center px-4 sm:px-6">
        <!-- Modal Content -->
        <div class="bg-white rounded shadow-lg overflow-auto max-w-2xl w-full max-h-[600px]">
            <!-- Modal Header -->
            <div class="px-5 py-3 bg-white border-b border-slate-200">
                <div class="flex justify-between items-center">
                    <div class="font-semibold text-slate-800">Details</div>
                    <button class="text-slate-400 hover:text-slate-500" onclick="closeModal()">
                        <div class="sr-only">Close</div>
                        <svg class="w-4 h-4 fill-current">
                            <path
                                d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Modal Content -->
            <div class="px-5 py-4">
                <div class="text-sm">

                </div>
            </div>
            <!-- Modal Footer -->
            <div class="px-5 py-4 bg-white border-t border-slate-200">
                <div class="flex flex-wrap justify-end space-x-2">
                    <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                            onclick="closeModal()">Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


<script>
    function displayModal(data) {
        var modal = document.getElementById('myModal');
        modal.classList.remove('hidden');

        var modalContent = document.querySelector('#myModal .text-sm');

        modalContent.innerHTML = '';

        var table = document.createElement('table');
        table.classList.add('border-collapse', 'w-full');

        var headerRow = table.insertRow(0);

        // Customize column names
        var columnNames = {
            'lot_title': 'Title',
           'buyer_name': 'Buyer Name',
            'seller_name': 'Seller Name',
            'order_id' : 'Order ID',
            'total_amount' : 'Total Amount',
        };

        Object.keys(data[0]).forEach(function (key) {
            var th = document.createElement('th');
            th.textContent = columnNames[key] || key; // Use custom name if available, otherwise use the original key
            th.classList.add('border', 'px-4', 'py-2');
            headerRow.appendChild(th);
        });

        data.forEach(function (item) {
            var row = table.insertRow(-1);

            Object.values(item).forEach(function (value) {
                var cell = row.insertCell(-1);
                cell.textContent = value;
                cell.classList.add('border', 'px-4', 'py-2');
            });
        });

        modalContent.appendChild(table);
    }



    function closeModal() {
        document.getElementById('myModal').classList.add('hidden');

    }


    const fintechCard09 = () => {
        const ctx = document.getElementById('fintech-card-09');
        if (!ctx) return;

        const openModal = (sectionName) => {
            // Send AJAX request to Laravel backend
            // alert(sectionName);
            $.ajax({
                url: '/get-sales-chart-details/' + sectionName,
                method: 'GET',
                success: function (response) {
                    console.log('data', response);
                    displayModal(response.data);
                },
                error: function (error) {
                    console.error('Error fetching data:', error);
                }
            });
        };


        const updateChart = (dynamicData) => {
            const chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Buy Now', 'Auctions', 'Live Streams'],
                    datasets: [
                        {
                            label: 'Sale Amount',
                            data: dynamicData,
                            backgroundColor: [
                                '#34d399',
                                '#fbbf24',
                                '#6366f1',
                            ],
                            hoverBackgroundColor: [
                                '#10b981',
                                '#f59e0b',
                                '#4f46e5',
                            ],
                            borderWidth: 0,
                        },
                    ],
                },
                options: {
                    layout: {
                        padding: {
                            top: 4,
                            bottom: 4,
                            left: 24,
                            right: 24,
                        },
                    },
                    plugins: {
                        legend: {
                            display: true,
                        },
                        htmlLegend: {
                            // ID of the container to put the legend in
                            containerID: 'fintech-card-09-legend',
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
                    onClick: function (event, elements) {
                        if (elements.length > 0) {
                            const clickedSection = elements[0].index;
                            const sectionName = chart.data.labels[clickedSection];
                            // const sectionName = elements[0].dataset.section;
                            openModal(sectionName);
                        }
                    },
                },
                plugins: [{
                    id: 'htmlLegend',
                    // ... (unchanged)
                }],

            });
        };

        // Fetch dynamic data using AJAX
        $.ajax({
            url: '/get-chart-data',
            method: 'GET',
            success: function (response) {
                // console.log('dynamic data', response);
                const totalSalesAmountElement = document.getElementById('totalSalesAmount');
                if (totalSalesAmountElement) {
                    totalSalesAmountElement.textContent = response.totalSalesAmount + ' SAR';
                }
                updateChart(response.data);
            },
            error: function (error) {
                console.error('Error fetching dynamic data:', error);
            }
        });
    };

    fintechCard09();
</script>


{{--<div id="myModal" class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 hidden transition-opacity">--}}
{{--    <!-- Modal Dialog -->--}}
{{--    <div class="fixed inset-0 z-50 overflow-hidden flex items-center justify-center px-4 sm:px-6">--}}
{{--        <!-- Modal Content -->--}}
{{--        <div class="bg-white rounded shadow-lg overflow-auto max-w-lg w-full max-h-[400px]">--}}
{{--            <!-- Modal Header -->--}}
{{--            <div class="px-5 py-3 bg-white border-b border-slate-200">--}}
{{--                <div class="flex justify-between items-center">--}}
{{--                    <div class="font-semibold text-slate-800">Details</div>--}}
{{--                    <button class="text-slate-400 hover:text-slate-500" onclick="closeModal()">--}}
{{--                        <div class="sr-only">Close</div>--}}
{{--                        <svg class="w-4 h-4 fill-current">--}}
{{--                            <path--}}
{{--                                d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z"/>--}}
{{--                        </svg>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <!-- Modal Content -->--}}
{{--            <div class="px-5 py-4">--}}
{{--                <div class="text-sm">--}}

{{--                </div>--}}
{{--            </div>--}}
{{--            <!-- Modal Footer -->--}}
{{--            <div class="px-5 py-4 bg-white border-t border-slate-200">--}}
{{--                <div class="flex flex-wrap justify-end space-x-2">--}}
{{--                    <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"--}}
{{--                            onclick="closeModal()">Close--}}
{{--                    </button>--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}


{{--<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>--}}

{{--<script>--}}

{{--    function openModal(id) {--}}
{{--        $.ajax({--}}
{{--            url: '/get-sales-data-ajax/' + id,--}}
{{--            method: 'GET',--}}
{{--            success: function (response) {--}}
{{--                console.log('data',response);--}}
{{--                displayModal(response);--}}
{{--            },--}}
{{--            error: function (error) {--}}
{{--                console.error('Error fetching data:', error);--}}
{{--            }--}}
{{--        });--}}
{{--    }--}}

{{--    // function displayModal(data) {--}}
{{--    //     document.getElementById('myModal').classList.remove('hidden');--}}
{{--    //     document.querySelector('#myModal .text-sm').innerHTML = data;--}}
{{--    // }--}}

{{--    function displayModal(data) {--}}
{{--        document.getElementById('myModal').classList.remove('hidden');--}}

{{--        var modalContent = document.querySelector('#myModal .text-sm');--}}

{{--        var table = document.createElement('table');--}}

{{--        var headerRow = table.insertRow(0);--}}

{{--        Object.keys(data[0]).forEach(function(key) {--}}
{{--            var th = document.createElement('th');--}}
{{--            th.textContent = key;--}}
{{--            headerRow.appendChild(th);--}}
{{--        });--}}

{{--        data.forEach(function(item) {--}}
{{--            var row = table.insertRow(-1);--}}
{{--            Object.values(item).forEach(function(value) {--}}
{{--                var cell = row.insertCell(-1);--}}
{{--                cell.textContent = value;--}}
{{--            });--}}
{{--        });--}}

{{--        modalContent.appendChild(table);--}}
{{--    }--}}


{{--    function closeModal() {--}}
{{--        document.getElementById('myModal').classList.add('hidden');--}}
{{--    }--}}
{{--</script>--}}


