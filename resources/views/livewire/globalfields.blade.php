<?php
$array = Session::get('permissions');
//add
$add_capability_exists = false;
$permissionsArray = json_decode($array, true);
foreach ($permissionsArray as $item) {
  if (isset($item['Global Field']) && in_array('add', $item['Global Field'])) {
    $add_capability_exists = true;
    break;
  }
} 
//list
$list_capability_exists = false;
$permissionsArray = json_decode($array, true);
foreach ($permissionsArray as $item) {
  if (isset($item['Global Field']) && in_array('list', $item['Global Field'])) {
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
            @if($addGlobalField)
            Add Global Field ✨
            @else
            Global Fields ✨
            @endif   
            </h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Delete button -->
                <x-actions.delete-button />

                <!-- Dropdown -->
                <!-- <x-date-select /> -->

                <!-- Filter button -->
                <!-- <x-dropdown-filter align="right" /> -->
                <!-- Add customer button -->
                @if(!$this->addGlobalField && $add_capability_exists && !$this->updateMode)
                <button wire:click="add()" class="btn border-slate-200 hover:border-slate-300 bg-indigo-500 text-white">Add Global Field</button>
                @endif
            </div>

        </div>

        <!-- Table -->
        @if($this->addGlobalField)
       <x-globalfields.add-globalfields />
       @elseif($this->updateMode)
       <x-globalfields.add-globalfields />
       @else
        @if($list_capability_exists)
       <x-globalfields.globalfields-table :globalfields="$globalfields" :count="$globalfields_count" />
       @endif
        <!-- Pagination -->
        <div class="mt-8">
                {{$globalfields->links()}}
            </div>
        </div>
        @endif