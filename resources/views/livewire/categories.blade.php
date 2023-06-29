<?php
$array = Session::get('permissions');
//add
$add_capability_exists = false;
$permissionsArray = json_decode($array, true);
foreach ($permissionsArray as $item) {
  if (isset($item['Category']) && in_array('add', $item['Category'])) {
    $add_capability_exists = true;
    break;
  }
} 
//list
$list_capability_exists = false;
foreach ($permissionsArray as $item) {
  if (isset($item['Category']) && in_array('list', $item['Category'])) {
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
            @if($addCategory)
            Add Category ✨
            @else
            Categories ✨
            @endif
            </h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Delete button -->
                <x-actions.delete-button />
                @if(!$addCategory && !$updateMode && $add_capability_exists)
                <button wire:click="add()" class="btn border-slate-200 hover:border-slate-300 bg-indigo-500 text-white">Add Category</button>
                @endif
            </div>

        </div>

        <!-- Table -->
    @if($addCategory)
    <x-categories.add-category :categories="$categories" :selectedCategory="$selectedCategory" />
    @elseif($updateMode)
    <x-categories.add-category :categories="$categories" :selectedCategory="$selectedCategory" />
    @else
    @if($list_capability_exists)
    <x-categories.categories-table :categories="$categories" :count="$total_categories" />
    @endif
    @endif
   <!-- Pagination -->
   <div class="mt-8">
            {{$categories->links()}}
        </div>
    </div>
