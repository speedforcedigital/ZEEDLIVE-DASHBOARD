<?php
$array = Session::get('permissions');
//list
$list_capability_exists = false;
$permissionsArray = json_decode($array, true);
foreach ($permissionsArray as $item) {
  if (isset($item['App  User']) && in_array('list', $item['App  User'])) {
    $list_capability_exists = true;
    break;
  }
}

//filter
$filter_capability_exists = false;
$permissionsArray = json_decode($array, true);
foreach ($permissionsArray as $item) {
  if (isset($item['App  User']) && in_array('filter', $item['App  User'])) {
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
            @if($viewUser)
            User Profile ✨
            @elseif($updateMode)
            Edit Profile ✨
            @else
            App Users ✨
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
                @if(!$updateMode && !$viewUser && $filter_capability_exists)
                <!-- Add customer button -->
                <button wire:click="filterUser('all')" class="btn border-slate-200 hover:border-slate-300 <?=($filterType=='all' || $filterType=='') ? 'bg-indigo-500 text-white' : 'text-indigo-500' ?>">All Users</button>
                <button wire:click="filterUser('seller')" class="btn border-slate-200 hover:border-slate-300 <?=($filterType=='seller') ? 'bg-indigo-500 text-white' : 'text-indigo-500' ?>">All Sellers</button>
                <button wire:click="filterUser('buyer')" class="btn border-slate-200 hover:border-slate-300 <?=($filterType=='buyer') ? 'bg-indigo-500 text-white' : 'text-indigo-500' ?>">All Buyers</button>
                @endif
            </div>

        </div>

        <!-- Table -->
    @if($viewUser)
        <!-- Profile body -->
        <x-users.profile-body :userProfile="$userProfile" />
    @elseif($updateMode)
    <x-users.edit-user />
    @else
    @if($list_capability_exists)
    <x-users.users-table :users="$users" :count="$users_count" />
    @endif
    <!-- Pagination -->
    <div class="mt-8">
            {{$users->links()}}
        </div>
    @endif
    </div>
