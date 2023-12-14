
<?php
$array = Session::get('permissions');
$keys = array();
$permissionsArray = json_decode($array, true);
if (is_array($permissionsArray)) {
    foreach ($permissionsArray as $element) {
        $keys = array_merge($keys, array_keys($element));
    }
    $keys = array_unique($keys);
//    dd($keys);
} else {
    $permissionsArray = array(); // Assign an empty array if $permissionsArray is null or not an array
}
?>


<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Welcome banner -->
        <x-dashboard.welcome-banner/>
        @if(in_array('Dashboard', $keys))

            {{-- Sales Report --}}

            {{--        <h1 class="text-xl md:text-2xl text-slate-800 font-bold col-span-8">Sales Report</h1>--}}
            {{--        <div class="grid grid-cols-8 gap-6 mt-2">--}}
            {{--            <x-dashboard.dashboard-card-sales :data="$data" />--}}
            {{--        </div>--}}

            {{-- Auction Metrics --}}
            <h1 class="text-xl md:text-2xl text-slate-800 font-bold col-span-8">Auction Metrics</h1>

            <div class="grid grid-cols-6 gap-6 mt-4">
                <x-dashboard.dashboard-card-01 :data="$data"/>
            </div>

            <br>
            <h1 class="text-xl md:text-2xl text-slate-800 font-bold col-span-8">Bids Metrics</h1>
            <div class="grid grid-cols-6 gap-6 mt-2">
                <x-dashboard.bids-stats :data="$data"/>
            </div>

            {{-- User Analytics --}}
            <div class="grid grid-cols-8 gap-6 mt-2">
                <h1 class="text-xl md:text-2xl text-slate-800 font-bold col-span-8">User Analytics</h1>
                <x-dashboard.user-age-graph/>
                <x-dashboard.user-gender-graph/>
            </div>

            {{-- Sales Statistics --}}
            <div class="grid grid-cols-8 gap-6 mt-4">
                <h1 class="text-xl md:text-2xl text-slate-800 font-bold col-span-8">Sales Analytics</h1>
                <x-dashboard.sales-graph :totalSales="$totalSales" :data="$data"/>
            </div>

        @endif

    </div>
</x-app-layout>




