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
@if (session()->has('message'))
    <div class="mb-4 px-4 py-2 mt-4 bg-green-100 text-green-900 rounded-md message alert-success">
        {{ session('message') }}
    </div>
@endif
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
                    <div class="mb-4 sm:mb-0">
                        <ul class="flex flex-wrap -m-1">
                            <li class="m-1">
                                <button wire:click="filter('all')"
                                        class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border {{ $selected === 'all' ? 'border-indigo-500' : 'border-transparent' }} shadow-sm {{ $selected === 'all' ? 'bg-indigo-500 text-white' : 'bg-white text-slate-500' }} duration-150 ease-in-out">
                                    All <span
                                        class="ml-1 {{ $selected === 'all' ? 'text-indigo-200' : 'text-slate-400' }}">{{ $totalUsersCount }}</span>
                                </button>
                            </li>
                            <li class="m-1">
                                <button wire:click="filter('sellers')"
                                        class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border {{ $selected === 'sellers' ? 'border-indigo-500' : 'border-transparent' }} shadow-sm {{ $selected === 'sellers' ? 'bg-indigo-500 text-white' : 'bg-white text-slate-500' }} duration-150 ease-in-out">
                                    Selers <span
                                        class="ml-1 {{ $selected === 'sellers' ? 'text-indigo-200' : 'text-slate-400' }}">{{ $totalSellers }}</span>
                                </button>
                            </li>
                            <li class="m-1">
                                <button wire:click="filter('buyers')"
                                        class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border {{ $selected === 'buyers' ? 'border-indigo-500' : 'border-transparent' }} shadow-sm {{ $selected === 'buyers' ? 'bg-indigo-500 text-white' : 'bg-white text-slate-500' }} duration-150 ease-in-out">
                                    Buyers <span
                                        class="ml-1 {{ $selected === 'buyers' ? 'text-indigo-200' : 'text-slate-400' }}">{{ $totalBuyers }}</span>
                                </button>
                            </li>
                        </ul>



                    </div>

                @endif
            </h1>
        </div>


        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Delete button -->
            <x-actions.delete-button/>

            <!-- Dropdown -->
            <!-- <x-date-select /> -->

            <!-- Filter button -->
            <!-- <x-dropdown-filter align="right" /> -->
            @if(!$updateMode && !$viewUser && $filter_capability_exists)
                <!-- Add customer button -->

            @endif
        </div>

    </div>

    <!-- Table -->
    @if($viewUser)
        <!-- Profile body -->
        <x-users.profile-body :userProfile="$userProfile"/>
    @elseif($updateMode)
        <x-users.edit-user/>
    @else
        @if($list_capability_exists)
{{--            {{dd($users)}}--}}
            <x-users.users-table :users="$users" :totalUsers="$totalUsers" :totalBuyers="$totalBuyers"
                                 :totalSellers="$totalSellers" :selected="$selected"/>
        @endif
        <!-- Pagination -->
        <div class="mt-8">
            {{$users->links()}}
        </div>
    @endif
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        window.livewire.on('alert_remove',()=>{
            setTimeout(function(){ $(".alert-success").fadeOut('fast');
            }, 2000);
            //reload page
            location.reload();
        });
    });
</script>
