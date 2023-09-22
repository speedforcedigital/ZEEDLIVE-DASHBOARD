<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Welcome banner -->
        <x-dashboard.welcome-banner />

        {{-- Auction Metrics --}}
        <h1 class="text-xl md:text-2xl text-slate-800 font-bold col-span-8">Auction Metrics</h1>
        <div class="grid grid-cols-8 gap-6 mt-2">
            <x-dashboard.dashboard-card-01 :data="$data" />
        </div>
    {{-- Sales Statistics --}}
    <div class="grid grid-cols-8 gap-6 mt-4 col-span-4 ">
        <h1 class="text-xl md:text-2xl text-slate-800 font-bold col-span-8">Sales Analytics</h1>
        <x-dashboard.sales-graph :totalSales="$totalSales"  />
    </div>
    {{-- User Analytics --}}
    <div class="grid grid-cols-8 gap-6 mt-2">
            <h1 class="text-xl md:text-2xl text-slate-800 font-bold col-span-8">User Analytics</h1>
            <x-dashboard.user-age-graph />
            <x-dashboard.user-gender-graph />
        </div>

              {{-- Auction Metrics --}}
              <br>
        <h1 class="text-xl md:text-2xl text-slate-800 font-bold col-span-8">Bids Metrics</h1>
        <div class="grid grid-cols-8 gap-6 mt-2">
            <x-dashboard.bids-stats :data="$data" />
        </div>
    </div>
</x-app-layout>
