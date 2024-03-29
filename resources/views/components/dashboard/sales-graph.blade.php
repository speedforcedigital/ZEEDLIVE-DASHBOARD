
<!-- Company Commission card -->
<div
    class="flex flex-col col-span-full sm:col-span-4 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
    <header class="px-5 py-4 border-b border-slate-100 flex items-center">
        <h2 class="font-semibold text-slate-800">Company Commission</h2>
    </header>
    <div class="px-5 py-3">
        <div class="text-sm italic mb-2">Total Commission</div>
        <div class="text-3xl font-bold text-slate-800" id="totalCommissionAmount">Loading...</div>
    </div>
    <div class="grow flex flex-col justify-center" >
        <div>
            <canvas id="fintech-card-commission" width="389" height="220"></canvas>
        </div>
        <div id="fintech-card-commission-legend" class="px-5 py-4">
            <ul class="flex flex-wrap justify-center -m-1"></ul>
        </div>
    </div>
</div>

<!-- Total Amount card -->

<div
    class="flex flex-col col-span-full sm:col-span-4 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
    <header class="px-5 py-4 border-b border-slate-100 flex items-center">
        <h2 class="font-semibold text-slate-800">Total Amount</h2>
    </header>
    <div class="px-5 py-3" >
        <div class="text-sm italic mb-2">Total Sales</div>
        <div class="text-3xl font-bold text-slate-800" id="totalSalesAmount">Loading...</div>
    </div>
    <div class="grow flex flex-col justify-center" >
        <div>
            <canvas id="fintech-card-09" width="389" height="220"></canvas>
        </div>
        <div id="fintech-card-09-legend" class="px-5 py-4">
            <ul class="flex flex-wrap justify-center -m-1"></ul>
        </div>
    </div>
</div>

<div
     class="flex flex-col col-span-full xl:col-span-8 bg-white shadow-lg rounded-sm border border-slate-200">
    <header class="px-5 py-4 border-b border-slate-100 flex items-center">
        <h2 class="font-semibold text-slate-800">Sales Report</h2>

        <div id="scale-buttons" class="ml-4 flex space-x-2">
            <button data-scale="year" class="scale-button">Yearly</button>
            <button data-scale="month" class="scale-button">Monthly</button>
            <button data-scale="day" class="scale-button">Daily</button>
        </div>
    </header>
    <div class="px-5 py-3" >
        <div class="flex flex-wrap justify-between items-end">
            <div class="flex items-center">
                <div class="text-3xl font-bold text-slate-800 mr-2" id="totalSales">SAR {{ $totalSales }}</div>
            </div>
            <div id="fintech-card-01-legend" class="grow ml-2 mb-1">
                <ul class="flex flex-wrap justify-end"></ul>
            </div>
        </div>
    </div>
    <div class="max-h-[300px] overflow-auto grow" >
        <canvas id="fintech-card-01" width="800" height="300"></canvas>
    </div>
</div>

{{--<div x-data="{ isOpen: false }"--}}
{{--     class="flex flex-col col-span-full xl:col-span-8 bg-white shadow-lg rounded-sm border border-slate-200">--}}
{{--    <header class="px-5 py-4 border-b border-slate-100 flex items-center">--}}
{{--        <h2 class="font-semibold text-slate-800">Sales Report</h2>--}}
{{--        <button @click="isOpen = !isOpen" class="ml-4 focus:outline-none">--}}
{{--            <i class="fas fa-eye" x-show="!isOpen"></i>--}}
{{--            <i class="fas fa-eye-slash" x-show="isOpen"></i>--}}
{{--        </button>--}}
{{--        <div id="scale-buttons" class="ml-4 flex space-x-2">--}}
{{--            <button data-scale="year" class="scale-button">Yearly</button>--}}
{{--            <button data-scale="month" class="scale-button">Monthly</button>--}}
{{--            <button data-scale="day" class="scale-button">Daily</button>--}}
{{--        </div>--}}
{{--    </header>--}}
{{--    <div class="px-5 py-3" x-show="isOpen">--}}
{{--        <div class="flex flex-wrap justify-between items-end">--}}
{{--            <div class="flex items-center">--}}
{{--                <div class="text-3xl font-bold text-slate-800 mr-2" id="totalSales">SAR {{ $totalSales }}</div>--}}
{{--            </div>--}}
{{--            <div id="fintech-card-01-legend" class="grow ml-2 mb-1">--}}
{{--                <ul class="flex flex-wrap justify-end"></ul>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="max-h-[300px] overflow-auto grow" x-show="isOpen">--}}
{{--        <canvas id="fintech-card-01" width="800" height="300"></canvas>--}}
{{--    </div>--}}
{{--</div>--}}






{{--<div x-data="{ isOpenCommission: false }"--}}
{{--     class="flex flex-col col-span-full sm:col-span-4 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">--}}
{{--    <header class="px-5 py-4 border-b border-slate-100 flex items-center">--}}
{{--        <h2 class="font-semibold text-slate-800">Company Commission</h2>--}}
{{--        <button @click="isOpenCommission = !isOpenCommission" class="ml-4 focus:outline-none">--}}
{{--            <i class="fas fa-eye" x-show="!isOpenCommission"></i>--}}
{{--            <i class="fas fa-eye-slash" x-show="isOpenCommission"></i>--}}
{{--        </button>--}}
{{--    </header>--}}
{{--    <div class="px-5 py-3" x-show="isOpenCommission">--}}
{{--        <div class="text-sm italic mb-2">Total Commission</div>--}}
{{--        <div class="text-3xl font-bold text-slate-800" id="totalCommissionAmount">Loading...</div>--}}
{{--    </div>--}}
{{--    <div class="grow flex flex-col justify-center" x-show="isOpenCommission">--}}
{{--        <div>--}}
{{--            <canvas id="fintech-card-commission" width="389" height="220"></canvas>--}}
{{--        </div>--}}
{{--        <div id="fintech-card-commission-legend" class="px-5 py-4">--}}
{{--            <ul class="flex flex-wrap justify-center -m-1"></ul>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}



{{--<div x-data="{ isOpenTotalAmount: false }"--}}
{{--     class="flex flex-col col-span-full sm:col-span-4 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">--}}
{{--    <header class="px-5 py-4 border-b border-slate-100 flex items-center">--}}
{{--        <h2 class="font-semibold text-slate-800">Total Amount</h2>--}}
{{--        <button @click="isOpenTotalAmount = !isOpenTotalAmount" class="ml-4 focus:outline-none">--}}
{{--            <i class="fas fa-eye" x-show="!isOpenTotalAmount"></i>--}}
{{--            <i class="fas fa-eye-slash" x-show="isOpenTotalAmount"></i>--}}
{{--        </button>--}}
{{--    </header>--}}
{{--    <div class="px-5 py-3" x-show="isOpenTotalAmount">--}}
{{--        <div class="text-sm italic mb-2">Total Sales</div>--}}
{{--        <div class="text-3xl font-bold text-slate-800" id="totalSalesAmount">Loading...</div>--}}
{{--    </div>--}}
{{--    <div class="grow flex flex-col justify-center" x-show="isOpenTotalAmount">--}}
{{--        <div>--}}
{{--            <canvas id="fintech-card-09" width="389" height="220"></canvas>--}}
{{--        </div>--}}
{{--        <div id="fintech-card-09-legend" class="px-5 py-4">--}}
{{--            <ul class="flex flex-wrap justify-center -m-1"></ul>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}





<!-- sales modal -->

<div id="myModal" class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 hidden transition-opacity">
    <!-- Modal Dialog -->
    <div class="fixed inset-0 z-50 overflow-hidden flex items-center justify-center px-4 sm:px-6 m-3">
        <!-- Modal Content -->
        <div class="bg-white rounded shadow-lg overflow-auto max-w-2xl w-full max-h-full">
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

<!-- commission modal -->
<div id="commModal" class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 hidden transition-opacity">
    <!-- Modal Dialog -->
    <div class="fixed inset-0 z-50 overflow-hidden flex items-center justify-center px-4 sm:px-6 m-3">
        <!-- Modal Content -->
        <div class="bg-white rounded shadow-lg overflow-auto max-w-2xl w-full max-h-full">
            <!-- Modal Header -->
            <div class="px-5 py-3 bg-white border-b border-slate-200">
                <div class="flex justify-between items-center">
                    <div class="font-semibold text-slate-800">Details</div>
                    <button class="text-slate-400 hover:text-slate-500" onclick="closeCommModal()">
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
                            onclick="closeCommModal()">Close
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

        var columnNames = {
            'lot_title': 'Title',
            'buyer_name': 'Buyer Name',
            'seller_name': 'Seller Name',
            'order_id': 'Order ID',
            'total_amount': 'Total Amount',
        };

        var visibleColumns = Object.keys(columnNames);

        visibleColumns.forEach(function (key) {
            var th = document.createElement('th');
            th.textContent = columnNames[key] || key;
            th.classList.add('border', 'px-4', 'py-2');
            headerRow.appendChild(th);
        });

        data.forEach(function (item) {
            var row = table.insertRow(-1);

            visibleColumns.forEach(function (key) {
                var cell = row.insertCell(-1);
                cell.textContent = item[key];
                cell.classList.add('border', 'px-4', 'py-2');

                if (key === 'lot_title') {
                    cell.classList.add('hoverable');
                    cell.addEventListener('click', function () {
                        var productId = item.id;
                        window.location.href = 'product/' + productId;
                    });
                }

                if (key === 'buyer_name') {
                    cell.classList.add('hoverable');
                    cell.addEventListener('click', function () {
                        var buyerId = item.buyer_id;
                        window.location.href = 'user/' + buyerId;
                    });
                }
                if (key === 'seller_name') {
                    cell.classList.add('hoverable');
                    cell.addEventListener('click', function () {
                        var sellerId = item.seller_id;
                        window.location.href = 'user/' + sellerId;
                    });
                }
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
            // alert(sectionName);
            $.ajax({
                url: '/get-sales-chart-details/' + sectionName,
                method: 'GET',
                success: function (response) {
                    // console.log('data', response);
                    displayModal(response.data);
                },
                error: function (error) {
                    console.error('Error fetching data:', error);
                }
            });
        };


        const updateChart = (dynamicData) => {
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Buy Now', 'Auctions', 'Live Streams'],
                    datasets: [
                        {
                            label: 'Sale Amount',
                            data: dynamicData,
                            backgroundColor: [
                                '#4F46E5',
                                '#4BC9FF',
                                '#C7D2FE',
                            ],
                            hoverBackgroundColor: [
                                '#4F46E5',
                                '#4BC9FF',
                                '#C7D2FE',
                            ],
                            borderWidth: 0,
                            barThickness: 40, // Adjust the value as needed
                        },
                    ],
                },
                options: {
                    layout: {
                        padding: {
                            top: 12,
                            bottom: 16,
                            left: 20,
                            right: 20,
                        },
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                display: false, // Hide x-axis grid lines
                            },
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: false, // Hide y-axis grid lines
                            },
                        },
                    },
                    plugins: {
                        legend: {
                            display: false,
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

    // commission chart
    const fintechCardCommission = () => {
        const ctx = document.getElementById('fintech-card-commission');
        if (!ctx) return;

        const openCommModal = (sectionName) => {
            // alert(sectionName);
            $.ajax({
                url: '/get-commission-chart-details/' + sectionName,
                method: 'GET',
                success: function (response) {
                    // console.log('data', response);
                    displayModalCommission(response.data);
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
                                '#4F46E5',
                                '#4BC9FF',
                                '#C7D2FE',
                            ],
                            hoverBackgroundColor: [
                                '#4F46E5',
                                '#4BC9FF',
                                '#C7D2FE',
                            ],
                            borderWidth: 0,
                            // barThickness: 40, // Adjust the value as needed
                        },
                    ],
                },
                options: {
                    layout: {
                        padding: {
                            top: 12,
                            bottom: 16,
                            left: 20,
                            right: 20,
                        },
                    },

                    plugins: {
                        legend: {
                            display: true,
                        },
                        htmlLegend: {
                            // ID of the container to put the legend in
                            containerID: 'fintech-card-commission-legend',
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
                            openCommModal(sectionName);
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
            url: '/get-commission-chart-data',
            method: 'GET',
            success: function (response) {
                console.log('commision', response);
                const totalCommissionAmountElement = document.getElementById('totalCommissionAmount');
                if (totalCommissionAmountElement) {
                    totalCommissionAmountElement.textContent = response.totalCommisionAmount + ' SAR';
                }
                updateChart(response.data);
            },
            error: function (error) {
                console.error('Error fetching dynamic data:', error);
            }
        });
    };

    fintechCardCommission();



    function displayModalCommission(data) {
        var modal = document.getElementById('commModal');
        modal.classList.remove('hidden');

        var modalContent = document.querySelector('#commModal .text-sm');

        modalContent.innerHTML = '';

        var table = document.createElement('table');
        table.classList.add('border-collapse', 'w-full');

        var headerRow = table.insertRow(0);

        var columnNames = {
            'lot_title': 'Title',
            'buyer_name': 'Buyer Name',
            'seller_name': 'Seller Name',
            'order_id': 'Order ID',
            // 'total_amount': 'Total Amount',
            'company_commission': 'Company Commission'
        };

        var visibleColumns = Object.keys(columnNames);

        visibleColumns.forEach(function (key) {
            var th = document.createElement('th');
            th.textContent = columnNames[key] || key;
            th.classList.add('border', 'px-4', 'py-2');
            headerRow.appendChild(th);
        });

        data.forEach(function (item) {
            var row = table.insertRow(-1);

            visibleColumns.forEach(function (key) {
                var cell = row.insertCell(-1);
                cell.textContent = item[key];
                cell.classList.add('border', 'px-4', 'py-2');

                if (key === 'lot_title') {
                    cell.classList.add('hoverable');
                    cell.addEventListener('click', function () {
                        var productId = item.id;
                        window.location.href = 'product/' + productId;
                    });
                }

                if (key === 'buyer_name') {
                    cell.classList.add('hoverable');
                    cell.addEventListener('click', function () {
                        var buyerId = item.buyer_id;
                        window.location.href = 'user/' + buyerId;
                    });
                }
                if (key === 'seller_name') {
                    cell.classList.add('hoverable');
                    cell.addEventListener('click', function () {
                        var sellerId = item.seller_id;
                        window.location.href = 'user/' + sellerId;
                    });
                }
            });
        });

        modalContent.appendChild(table);
    }

    function closeCommModal() {
        document.getElementById('commModal').classList.add('hidden');

    }


</script>

<style>
    .hoverable:hover {
        cursor: pointer;
        background-color: #f0f0f0;
    }
</style>




