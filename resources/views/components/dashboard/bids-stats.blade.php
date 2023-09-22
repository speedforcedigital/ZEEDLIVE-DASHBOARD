<div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-2 bg-white shadow-lg rounded-sm border border-slate-200">
    <div class="px-5 pt-5">
        <header class="flex justify-center mb-2">
            <a href="/auctions"><img src="{{ asset('images/icon-01.svg') }}" width="32" height="32" alt="Icon 01" /></a>
        </header>
        <h2 class="text-lg font-semibold text-slate-800 text-center mb-2">
            Live Bids
        </h2>
        <div class="text-xs font-semibold text-slate-400 uppercase mb-1 text-center">Total Live Bids</div>
        <div class="flex justify-center items-center">
            <div class="text-3xl font-bold text-slate-800">{{$data["totalLiveBids"]}}</div>
        </div>
    </div>
</div>
<div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-2 bg-white shadow-lg rounded-sm border border-slate-200">
    <div class="px-5 pt-5">
        <header class="flex justify-center mb-2">
            <a href="/auctions"><img src="{{ asset('images/icon-01.svg') }}" width="32" height="32" alt="Icon 01" /></a>
        </header>
        <h2 class="text-lg font-semibold text-slate-800 text-center mb-2">
            Regular Bids
        </h2>
        <div class="text-xs font-semibold text-slate-400 uppercase mb-1 text-center">Total Regular Bids</div>
        <div class="flex justify-center items-center">
            <div class="text-3xl font-bold text-slate-800">{{$data["totalBids"]}}</div>
        </div>
    </div>
</div>

<div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-2 bg-white shadow-lg rounded-sm border border-slate-200">
    <div class="px-5 pt-5">
        <header class="flex justify-center mb-2">
            <a href="/auctions"><img src="{{ asset('images/icon-01.svg') }}" width="32" height="32" alt="Icon 01" /></a>
        </header>
        <h2 class="text-lg font-semibold text-slate-800 text-center mb-2">
             Closed Bids
        </h2>
        <div class="text-xs font-semibold text-slate-400 uppercase mb-1 text-center">Total Closed Bids</div>
        <div class="flex justify-center items-center">
            <div class="text-3xl font-bold text-slate-800">{{$data["closedBids"]}}</div>
        </div>
    </div>
</div>
