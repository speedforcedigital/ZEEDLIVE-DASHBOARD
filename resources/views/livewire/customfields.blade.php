<?php
$array = Session::get('permissions');
// Add capability
$add_capability_exists = false;
$permissionsArray = json_decode($array, true);
foreach ($permissionsArray as $item) {
    if (isset($item['Custom Field']) && in_array('add', $item['Custom Field'])) {
        $add_capability_exists = true;
        break;
    }
}
// List capability
$list_capability_exists = false;
$permissionsArray = json_decode($array, true);
foreach ($permissionsArray as $item) {
    if (isset($item['Custom Field']) && in_array('list', $item['Custom Field'])) {
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
                @if($addCustomField)
                Add Custom Field ✨
                @else
                Custom Fields ✨
                @endif
            </h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Delete button -->
            <x-actions.delete-button />

            <!-- Add custom field button -->
            @if(!$addCustomField && $add_capability_exists && !$updateMode)
            <button wire:click="add()" class="btn border-slate-200 hover:border-slate-300 bg-indigo-500 text-white">Add Custom Field</button>
            @endif
        </div>

    </div>

    <!-- Table -->
    @if($addCustomField || $updateMode)
    <x-customfields.add-customfields />
    @else
    @if($list_capability_exists)
    <x-customfields.customfields-table :customfields="$customfields" :count="$customfields_count" />
    @endif
    <!-- Pagination -->
    <div class="mt-8">
        {{$customfields->links()}}
    </div>
    @endif

</div>
