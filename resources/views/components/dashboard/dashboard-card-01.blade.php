@foreach($data as $key => $val)
<div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
    <div class="px-5 pt-5">
        <header class="flex justify-between items-start mb-2">
            <!-- Icon -->
            <a href="/auctions"><img src="{{ asset('images/icon-01.svg') }}" width="32" height="32" alt="Icon 01" /></a>
            <!-- Menu button -->
        </header>
        <h2 class="text-lg font-semibold text-slate-800 mb-2">
           
            {{ucfirst($key)}}
        </h2>
        <div class="text-xs font-semibold text-slate-400 uppercase mb-1">Total Pending Auctions</div>
        <div class="flex items-start">
            <div class="text-3xl font-bold text-slate-800 mr-2">{{$val}}</div>
        </div>
    </div>
    <!-- Chart built with Chart.js 3 -->
    <!-- Check out src/js/components/dashboard-card-01.js for config -->
    <div class="grow">
        <!-- Change the height attribute to adjust the chart height -->
        <canvas id="dashboard-card-01" width="389" height="50"></canvas>
    </div>
</div>
@endforeach
