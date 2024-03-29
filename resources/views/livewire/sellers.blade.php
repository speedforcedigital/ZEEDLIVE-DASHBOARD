<?php
$array = Session::get('permissions');
//list
$list_capability_exists = false;
$permissionsArray = json_decode($array, true);
foreach ($permissionsArray as $item) {
  if (isset($item['Seller Verification']) && in_array('list', $item['Seller Verification'])) {
    $list_capability_exists = true;
    break;
  }
}

//filter
$filter_capability_exists = false;
$permissionsArray = json_decode($array, true);
foreach ($permissionsArray as $item) {
  if (isset($item['Seller Verification']) && in_array('filter', $item['Seller Verification'])) {
    $filter_capability_exists = true;
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
            Seller Verification ✨
            </h1>
            </div>

            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2 mb-2 ">
                <input type="text" wire:model.lazy="search"
                       class="mt-2 w-full  rounded-md px-4 py-2 border border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none"
                       placeholder="Search">
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Delete button -->
                <x-actions.delete-button />
                <!-- Add customer button -->
                {{-- @if($filter_capability_exists) --}}
                <button wire:click="filterSeller('all')" class="btn border-slate-200 hover:border-slate-300 <?=($this->filterType=='all' || $this->filterType=='') ? 'bg-indigo-500 text-white' : 'text-indigo-500' ?>">All</button>
                <button wire:click="filterSeller('pending')" class="btn border-slate-200 hover:border-slate-300 <?=($this->filterType=='pending' || $this->filterType=='pending') ? 'bg-indigo-500 text-white' : 'text-indigo-500' ?>">Pending</button>
                <button wire:click="filterSeller('verified')" class="btn border-slate-200 hover:border-slate-300 <?=($this->filterType=='verified') ? 'bg-indigo-500 text-white' : 'text-indigo-500' ?>">Verified</button>
                <button wire:click="filterSeller('rejected')" class="btn border-slate-200 hover:border-slate-300 <?=($this->filterType=='rejected') ? 'bg-indigo-500 text-white' : 'text-indigo-500' ?>">Rejected</button>
                {{-- @endif --}}
            </div>

        </div>

        <!-- Table -->
    @if($list_capability_exists)
    <x-sellers.sellers-table :sellers="$sellers" :count="$total_sellers" />
    @endif
    <!-- Pagination -->
   <div class="mt-8">
            {{$sellers->links()}}
        </div>
    </div>


