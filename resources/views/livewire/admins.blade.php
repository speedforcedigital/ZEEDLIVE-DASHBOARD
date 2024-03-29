<?php
$array = Session::get('permissions');
//echo $array;
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
    @if (session()->has('message'))
        <div class="mb-4 px-4 py-2 bg-green-100 text-green-900 rounded-md">
            {{ session('message') }}
        </div>
    @endif
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
            @if($updateMode)
            Edit Admin User ✨
            @else
            Admin Users ✨
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
                @if(!$updateMode && !$addUser && $add_capability_exists)
                <button wire:click="add()" class="btn border-slate-200 hover:border-slate-300 bg-indigo-500 text-white">Add Admin User</button>
                @endif
            </div>

        </div>

        <!-- Table -->

    @if($updateMode)
    <x-users.edit-admin :roles="$roles" />
    @elseif($addUser)
    <x-users.edit-admin :roles="$roles" />
    @else
    {{-- @if($list_capability_exists) --}}
    <x-users.admin-table :admins="$admins" :count="$admins_count" />
    {{-- @endif --}}
    <!-- Pagination -->
    <div class="mt-8">
            {{$admins->links()}}
        </div>
    @endif
    </div>
