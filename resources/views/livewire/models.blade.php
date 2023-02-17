<?php
$array = Session::get('permissions');
//add
$add_capability_exists = false;
foreach ($array as $item) {
  if (isset($item['Modal']) && in_array('add', $item['Modal'])) {
    $add_capability_exists = true;
    break;
  }
} 
//list
$list_capability_exists = false;
foreach ($array as $item) {
  if (isset($item['Modal']) && in_array('list', $item['Modal'])) {
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
            @if($addModel)
            Add Modal ✨
            @else
            Modals ✨
            @endif
            </h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Delete button -->
                <x-actions.delete-button />
                @if(!$addModel && !$updateMode && $add_capability_exists)
                <button wire:click="add()" class="btn border-slate-200 hover:border-slate-300 bg-indigo-500 text-white">Add Model</button>
                @endif
            </div>

        </div>

        <!-- Table -->
    @if($addModel)
    <x-models.add-model />
    @elseif($updateMode)
    <x-models.add-model />
    @else
    @if($list_capability_exists)
    <x-models.models-table :modals="$modals" :count="$total_model" />
    @endif
   <!-- Pagination -->
   <div class="mt-8">
            {{$modals->links()}}
        </div>
    </div>
    @endif
