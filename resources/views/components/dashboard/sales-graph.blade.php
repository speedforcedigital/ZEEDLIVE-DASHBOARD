<div x-data="{ isOpen: false }"  class="flex flex-col col-span-full xl:col-span-8 bg-white shadow-lg rounded-sm border border-slate-200">
    <header class="px-5 py-4 border-b border-slate-100 flex items-center">
        <h2 class="font-semibold text-slate-800">Sales Report</h2>
         <button @click="isOpen = !isOpen" class="ml-4 focus:outline-none">
            <i class="fas fa-eye" x-show="!isOpen"></i>
            <i class="fas fa-eye-slash" x-show="isOpen"></i>
        </button>
        <div id="scale-buttons" class="ml-4 flex space-x-2">
            <button data-scale="year" class="scale-button">Yearly</button>
            <button data-scale="month" class="scale-button">Monthly</button>
            <button data-scale="day" class="scale-button">Daily</button>
        </div>
    </header>
    <div class="px-5 py-3" x-show="isOpen">
        <div class="flex flex-wrap justify-between items-end">
            <div class="flex items-center">
                <div class="text-3xl font-bold text-slate-800 mr-2" id = "totalSales">${{ $totalSales }}</div>
            </div>
            <div id="fintech-card-01-legend" class="grow ml-2 mb-1">
                <ul class="flex flex-wrap justify-end"></ul>
            </div>
        </div>
    </div>
    <div class="max-h-[300px] overflow-auto grow"  x-show="isOpen">
        <canvas id="fintech-card-01" width="800" height="300"></canvas>
    </div>
</div>
