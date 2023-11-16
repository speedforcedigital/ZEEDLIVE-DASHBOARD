<div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-2 bg-gradient-to-br from-gray-600 to-gray-800 shadow-lg rounded-md border border-gray-300">
    <div class="px-5 pt-5">
        <header class="flex justify-center mb-2">
            <a href="/auctions"><img src="{{ asset('images/icon-01.svg') }}" width="32" height="32" alt="Icon 01" /></a>
        </header>
        <h2 class="text-lg font-semibold text-white text-center mb-2">
            Live Auctions
        </h2>
        <div class="text-xs font-semibold text-gray-400 uppercase mb-1 text-center">Total Live Auctions</div>
        <div class="flex justify-center items-center">
            <div class="text-3xl font-bold text-white">{{$data["totalLiveAuctions"]}}</div>
        </div>
    </div>
</div>

<div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-2 bg-gradient-to-br from-blue-600 to-blue-900 shadow-lg rounded-md border border-gray-300">
    <div class="px-5 pt-5">
        <header class="flex justify-center mb-2">
            <a href="/auctions"><img src="{{ asset('images/icon-01.svg') }}" width="32" height="32" alt="Icon 01" /></a>
        </header>
        <h2 class="text-lg font-semibold text-white text-center mb-2">
            Live Streams
        </h2>
        <div class="text-xs font-semibold text-gray-400 uppercase mb-1 text-center">Total Live Streams</div>
        <div class="flex justify-center items-center">
            <div class="text-3xl font-bold text-white">{{$data["totalLiveStreams"]}}</div>
        </div>
    </div>
</div>
<div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-2 bg-gradient-to-br from-stone-600 to-indigo-900 shadow-lg rounded-md border border-gray-300">
    <div class="px-5 pt-5">
        <header class="flex justify-center mb-2">
            <a href="/auctions"><img src="{{ asset('images/icon-01.svg') }}" width="32" height="32" alt="Icon 01" /></a>
        </header>
        <h2 class="text-lg font-semibold text-white text-center mb-2">
            Buy Now Products
        </h2>
        <div class="text-xs font-semibold text-gray-400 uppercase mb-1 text-center">Total Buy Now Products</div>
        <div class="flex justify-center items-center">
            <div class="text-3xl font-bold text-white">{{$data["totalBuyNowProducts"]}}</div>
        </div>
    </div>
</div>
