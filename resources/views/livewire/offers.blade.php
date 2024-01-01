<?php
$array = Session::get('permissions');
//list
$list_capability_exists = false;
$permissionsArray = json_decode($array, true);
foreach ($permissionsArray as $item) {
  if (isset($item['Offers']) && in_array('list', $item['Offers'])) {
    $list_capability_exists = true;
    break;
  }
}
?>
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
            Offers ✨
            </h1>
            </div>



            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Delete button -->
                <x-actions.delete-button />
            </div>

            <!-- back button on right side -->
{{--            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">--}}
{{--                <a href="{{ route('dashboard') }}"--}}
{{--                   class="btn-sm text-white hover:text-white bg-indigo-600 hover:bg-indigo-800">--}}
{{--                    <!-- back button icon -->--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left"--}}
{{--                         width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"--}}
{{--                         stroke-linecap="round" stroke-linejoin="round">--}}
{{--                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>--}}
{{--                        <line x1="5" y1="12" x2="15" y2="12"/>--}}
{{--                        <line x1="5" y1="12" x2="9" y2="16"/>--}}
{{--                        <line x1="5" y1="12" x2="9" y2="8"/>--}}
{{--                    </svg>--}}
{{--                    <span>Back</span>--}}
{{--                </a>--}}
{{--            </div>--}}

        </div>

        <!-- Table -->
    @if($list_capability_exists)
    <x-offers.offers-table :offers="$offers" :count="$total_offers" />
    @endif
   <!-- Pagination -->
   <div class="mt-8">
            {{$offers->links()}}
        </div>
    </div>
