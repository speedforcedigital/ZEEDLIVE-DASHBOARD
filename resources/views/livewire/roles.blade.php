<?php
$array = Session::get('permissions');
//add
$add_capability_exists = false;
$permissionsArray = json_decode($array, true);
foreach ($permissionsArray as $item) {
    if (isset($item['Admin User']) && in_array('add', $item['Admin User'])) {
        $add_capability_exists = true;
        break;
    }
}
//list
$list_capability_exists = false;
$permissionsArray = json_decode($array, true);
foreach ($permissionsArray as $item) {
    if (isset($item['Admin User']) && in_array('list', $item['Admin User'])) {
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
                @if($updateMode)
                    Edit Role ✨
                @else
                    Roles ✨
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
            @if(!$updateMode && !$addRoles && $add_capability_exists)
                <button wire:click="addRoles()" class="btn border-slate-200 hover:border-slate-300 bg-indigo-500 text-white">Add Roles</button>
            @endif
        </div>

    </div>

    <!-- Table -->

    @if($updateMode)
        <x-users.edit-role />
    @elseif($addRoles)
        <x-users.edit-role />
    @else
         @if($list_capability_exists)
        <x-users.role-table :roles="$roles" :count="$roles_count" />
         @endif
        <!-- Pagination -->
        <div class="mt-8">
            {{$roles->links()}}
        </div>
    @endif
</div>
