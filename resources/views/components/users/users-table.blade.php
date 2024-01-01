<?php
$array = Session::get('permissions');
//view$array = Session::get('permissions');
//list
$permissionsArray = json_decode($array, true);

$view_capability_exists = false;
foreach ($permissionsArray as $item) {
    if (isset($item['App  User']) && in_array('view', $item['App  User'])) {
        $view_capability_exists = true;
        break;
    }
}
//edit
$edit_capability_exists = false;
foreach ($permissionsArray as $item) {
    if (isset($item['App  User']) && in_array('edit', $item['App  User'])) {
        $edit_capability_exists = true;
        break;
    }
}
//delete
$delete_capability_exists = false;
foreach ($permissionsArray as $item) {
    if (isset($item['App  User']) && in_array('delete', $item['App  User'])) {
        $delete_capability_exists = true;
        break;
    }
}
?>
<x-loading-indicater/>
<div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2 mb-2 ">
    <input type="text" wire:model.lazy="search"
           class="mt-2 w-full  rounded-md px-4 py-2 border border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none"
           placeholder="Search Users">
</div>
<div class="bg-white shadow-lg rounded-sm border border-slate-200">
    <header class="px-5 py-4">
        <h2 class="font-semibold text-slate-800">All Users <span
                class="text-slate-400 font-medium">{{ $totalUsers }}</span></h2>

    </header>

    <div x-data="handleSelect">

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <!-- Table header -->
                <thead
                    class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                <tr>
                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="font-semibold text-left">Sr No</div>
                    </th>
                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="font-semibold text-left">Name</div>
                    </th>
                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="font-semibold text-left">Email</div>
                    </th>
                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="font-semibold text-left">Mobile</div>
                    </th>
                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="font-semibold text-left">Role</div>
                    </th>
                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="font-semibold text-left">Status</div>
                    </th>
                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="font-semibold text-left">Action</div>
                    </th>
                </tr>
                </thead>
                <!-- Table body -->
                <tbody class="text-sm divide-y divide-slate-200">
                {{--                    {{$search}}--}}
                <?php $i = 0; ?>
                @foreach($users as $user)
                        <?php $i++; ?>
                    <tr>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="text-left">{{$i}}</div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 shrink-0 mr-2 sm:mr-3">
                                    <img class="rounded-full"
                                         src="https://zeed-live.nyc3.cdn.digitaloceanspaces.com/user/profile/{{$user['accountDetail']['profile_image']}}"
                                         alt="Patricia Semklo" style="width: 40px; height: 40px" ;>
                                </div>
                                <div class="font-medium text-slate-800"><a
                                        href="{{ route('user.show',$user['id'] ) }}">{{ $user['name'] }}</a></div>
                            </div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="text-left">{{ $user['email'] }}</div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="text-left">{{ $user['mobile'] }}</div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <button
                                class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border border-transparent shadow-sm bg-indigo-500 text-white duration-150 ease-in-out">{{ $user['rank'] }}</button>
                        </td>
                        <!-- Status -->
                        @if($user['is_banned'] == 0)
                            <td>
                                 <span
                                     class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                            </td>
                        @else
                            <td>
                                 <span
                                     class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Banned
                                    </span>
                            </td>
                        @endif

                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="flex space-x-1 items-center">
                                @if($edit_capability_exists)
                                    <button wire:click="edit({{$user['id']}})"
                                            class="btn border-slate-200 hover:border-slate-300">
                                        <svg class="w-4 h-4 fill-current text-slate-500 shrink-0" viewBox="0 0 16 16">
                                            <path
                                                d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z"></path>
                                        </svg>
                                    </button>
                                @endif

                                @if($delete_capability_exists)
                                    {{--                                <button wire:click="delete({{$user['id']}})"--}}
                                    {{--                                        class="btn border-slate-200 hover:border-slate-300">--}}
                                    {{--                                    <svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16">--}}
                                    {{--                                        <path--}}
                                    {{--                                            d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z"></path>--}}
                                    {{--                                    </svg>--}}
                                    {{--                                </button>--}}


                                    <!-- delete button -->
                                    {{--                                    <div--}}
                                    {{--                                        x-data="{ deleteModalOpen2: @entangle('deleteModalOpen2'), collectionsCount: @entangle('collectionsCount') }">--}}
                                    {{--                                        <div class="flex items-center">--}}
                                    {{--                                            <!-- Enable Button -->--}}
                                    {{--                                            <button class="btn border-slate-200 hover:border-slate-300"--}}
                                    {{--                                                    @click="deleteModalOpen2 = true">--}}
                                    {{--                                                <span class="sr-only">Enable</span>--}}
                                    {{--                                                <svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16">--}}
                                    {{--                                                    <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z"></path>--}}
                                    {{--                                                </svg>--}}
                                    {{--                                            </button>--}}

                                    {{--                                            <!-- Eye Button -->--}}
                                    {{--                                            <button class="text-slate-400 hover:text-slate-500 rounded-full ml-2"--}}
                                    {{--                                                    @click="/* Add your logic here */">--}}
                                    {{--                                                <span class="sr-only">View</span>--}}
                                    {{--                                                <!-- Your eye icon here -->--}}
                                    {{--                                            </button>--}}
                                    {{--                                        </div>--}}

                                    {{--                                        <!-- Modal overlay -->--}}
                                    {{--                                        <div--}}
                                    {{--                                            class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"--}}
                                    {{--                                            x-show="deleteModalOpen2"--}}
                                    {{--                                            x-transition:enter="transition ease-out duration-200"--}}
                                    {{--                                            x-transition:enter-start="opacity-0"--}}
                                    {{--                                            x-transition:enter-end="opacity-100"--}}
                                    {{--                                            x-transition:leave="transition ease-out duration-100"--}}
                                    {{--                                            x-transition:leave-start="opacity-100"--}}
                                    {{--                                            x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak></div>--}}

                                    {{--                                        <!-- Delete Category Modal Dialog -->--}}
                                    {{--                                        <div--}}
                                    {{--                                            class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6"--}}
                                    {{--                                            role="dialog"--}}
                                    {{--                                            aria-modal="true" x-show="deleteModalOpen2"--}}
                                    {{--                                            x-transition:enter="transition ease-in-out duration-200"--}}
                                    {{--                                            x-transition:enter-start="opacity-0 translate-y-4"--}}
                                    {{--                                            x-transition:enter-end="opacity-100 translate-y-0"--}}
                                    {{--                                            x-transition:leave="transition ease-in-out duration-200"--}}
                                    {{--                                            x-transition:leave-start="opacity-100 translate-y-0"--}}
                                    {{--                                            x-transition:leave-end="opacity-0 translate-y-4" aria-hidden="true"--}}
                                    {{--                                            x-cloak>--}}
                                    {{--                                            <!-- Modal content -->--}}
                                    {{--                                            <div--}}
                                    {{--                                                class="bg-white dark:bg-slate-800 rounded shadow-lg overflow-auto max-w-lg w-full max-h-full"--}}
                                    {{--                                                @click.outside="deleteModalOpen2 = false"--}}
                                    {{--                                                @keydown.escape.window="deleteModalOpen2 = false"--}}
                                    {{--                                                style="max-width: 640px;">--}}
                                    {{--                                                <!-- Modal header -->--}}
                                    {{--                                                <div--}}
                                    {{--                                                    class="px-5 py-3 border-b border-slate-200 dark:border-slate-700">--}}
                                    {{--                                                    <div class="flex justify-between items-center">--}}
                                    {{--                                                        <div--}}
                                    {{--                                                            class="font-semibold text-slate-800 dark:text-slate-100">--}}
                                    {{--                                                            Delete User--}}
                                    {{--                                                        </div>--}}
                                    {{--                                                        <button--}}
                                    {{--                                                            class="text-slate-400 dark:text-slate-500 hover:text-slate-500 dark:hover:text-slate-400"--}}
                                    {{--                                                            @click="deleteModalOpen2 = false">--}}
                                    {{--                                                            <div class="sr-only">Close</div>--}}
                                    {{--                                                            <svg class="w-4 h-4 fill-current">--}}
                                    {{--                                                                <path--}}
                                    {{--                                                                    d="M7.95 6.536L12.192 2.293a1 1 0 111.414 1.414L9.364 7.95l4.243 4.243a1 1 0 11-1.414 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z"/>--}}
                                    {{--                                                            </svg>--}}
                                    {{--                                                        </button>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                </div>--}}
                                    {{--                                                <!-- Modal content -->--}}
                                    {{--                                                <div class="px-5 py-4">--}}
                                    {{--                                                    <div class="text-sm">--}}
                                    {{--                                                        <div--}}
                                    {{--                                                            class="font-medium text-slate-800 dark:text-slate-100 mb-3">--}}
                                    {{--                                                            Are you sure you want to delete this user?--}}
                                    {{--                                                        </div>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                </div>--}}
                                    {{--                                                <!-- Modal footer -->--}}
                                    {{--                                                <div--}}
                                    {{--                                                    class="px-5 py-4 border-t border-slate-200 dark:border-slate-700">--}}
                                    {{--                                                    <div class="flex justify-end">--}}
                                    {{--                                                        <button--}}
                                    {{--                                                            class="btn-sm bg-gray-500 hover:bg-gray-700 text-white mr-2"--}}
                                    {{--                                                            @click="deleteModalOpen2 = false">--}}
                                    {{--                                                            Cancel--}}
                                    {{--                                                        </button>--}}
                                    {{--                                                        <button--}}
                                    {{--                                                            class="btn-sm bg-indigo-600 hover:bg-indigo-700 text-white"--}}
                                    {{--                                                            wire:click="delete({{$user['id']}})">--}}
                                    {{--                                                            Delete--}}
                                    {{--                                                        </button>--}}
                                    {{--                                                        <template x-if="collectionsCount > 0">--}}
                                    {{--                                                            <button--}}
                                    {{--                                                                class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white"--}}
                                    {{--                                                                @click="deleteModalOpen2 = false">OK--}}
                                    {{--                                                            </button>--}}
                                    {{--                                                        </template>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                </div>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}

                                    @if($user['is_banned'] == 0)
                                        <div
                                            x-data="{ deleteModalOpen2: @entangle('deleteModalOpen2'), collectionsCount: @entangle('collectionsCount') }">
                                            <div class="flex items-center">
                                                <!-- Enable Button -->
                                                <button class="btn border-slate-200 hover:border-slate-300"
                                                        @click="deleteModalOpen2 = true">
                                                    <span class="sr-only">Enable</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="icon icon-tabler icon-tabler-ban w-4 h-4"
                                                         viewBox="0 0 24 24" stroke-width="1.5"
                                                         stroke="#2c3e50" fill="none" stroke-linecap="round"
                                                         stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/>
                                                        <path d="M5.7 5.7l12.6 12.6"/>
                                                    </svg>
                                                </button>

                                                <!-- Eye Button -->
                                                <button class="text-slate-400 hover:text-slate-500 rounded-full ml-2"
                                                        @click="/* Add your logic here */">
                                                    <span class="sr-only">View</span>
                                                    <!-- Your eye icon here -->
                                                </button>
                                            </div>

                                            <!-- Modal overlay -->
                                            <div
                                                class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                                                x-show="deleteModalOpen2"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0"
                                                x-transition:enter-end="opacity-100"
                                                x-transition:leave="transition ease-out duration-100"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak></div>

                                            <!-- Delete Category Modal Dialog -->
                                            <div
                                                class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6"
                                                role="dialog"
                                                aria-modal="true" x-show="deleteModalOpen2"
                                                x-transition:enter="transition ease-in-out duration-200"
                                                x-transition:enter-start="opacity-0 translate-y-4"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition ease-in-out duration-200"
                                                x-transition:leave-start="opacity-100 translate-y-0"
                                                x-transition:leave-end="opacity-0 translate-y-4" aria-hidden="true"
                                                x-cloak>
                                                <!-- Modal content -->
                                                <div
                                                    class="bg-white dark:bg-slate-800 rounded shadow-lg overflow-auto max-w-lg w-full max-h-full"
                                                    @click.outside="deleteModalOpen2 = false"
                                                    @keydown.escape.window="deleteModalOpen2 = false"
                                                    style="max-width: 640px;">
                                                    <!-- Modal header -->
                                                    <div
                                                        class="px-5 py-3 border-b border-slate-200 dark:border-slate-700">
                                                        <div class="flex justify-between items-center">
                                                            <div
                                                                class="font-semibold text-slate-800 dark:text-slate-100">
                                                                Ban User
                                                            </div>
                                                            <button
                                                                class="text-slate-400 dark:text-slate-500 hover:text-slate-500 dark:hover:text-slate-400"
                                                                @click="deleteModalOpen2 = false">
                                                                <div class="sr-only">Close</div>
                                                                <svg class="w-4 h-4 fill-current">
                                                                    <path
                                                                        d="M7.95 6.536L12.192 2.293a1 1 0 111.414 1.414L9.364 7.95l4.243 4.243a1 1 0 11-1.414 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <!-- Modal content -->
                                                    <div class="px-5 py-4">
                                                        <div class="text-sm">
                                                            <div
                                                                class="font-medium text-slate-800 dark:text-slate-100 mb-3">
                                                                Are you sure you want to Ban this user?
                                                            </div>
                                                        </div>
                                                        <label class="block">
                                                            <span class="text-gray-700">Reason <b
                                                                    class="text-red-500">*</b></span>
                                                            <textarea
                                                                class="form-textarea mt-1 block w-full"
                                                                rows="3" wire:model.defer="reason" required></textarea>
                                                        </label>
                                                        <div class="text-red-500 text-xs italic">
                                                            @error('reason') <span
                                                                class="reason">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <!-- Modal footer -->
                                                    <div
                                                        class="px-5 py-4 border-t border-slate-200 dark:border-slate-700">
                                                        <div class="flex justify-end">
                                                            <button
                                                                class="btn-sm bg-gray-500 hover:bg-gray-700 text-white mr-2"
                                                                @click="deleteModalOpen2 = false">
                                                                Cancel
                                                            </button>
                                                            <button
                                                                class="btn-sm bg-indigo-600 hover:bg-indigo-700 text-white"
                                                                wire:click="banUser({{$user['id']}})">
                                                                Ban
                                                            </button>
                                                            <template x-if="collectionsCount > 0">
                                                                <button
                                                                    class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white"
                                                                    @click="deleteModalOpen2 = false">OK
                                                                </button>
                                                            </template>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($user['is_banned'] == 1)

                                        <div
                                            x-data="{ deleteModalOpen2: @entangle('deleteModalOpen2'), collectionsCount: @entangle('collectionsCount') }">
                                            <div class="flex items-center">
                                                <!-- Enable Button -->
                                                <button class="btn border-slate-200 hover:border-slate-300"
                                                        @click="deleteModalOpen2 = true">
                                                    <span class="sr-only">Enable</span>
                                                    <!-- active user icon here -->
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="icon icon-tabler icon-tabler-check w-4 h-4"
                                                         viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50"
                                                         fill="none"
                                                         stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M5 12l5 5l10 -10"/>
                                                    </svg>

                                                </button>

                                                <!-- Eye Button -->
                                                <button class="text-slate-400 hover:text-slate-500 rounded-full ml-2"
                                                        @click="/* Add your logic here */">
                                                    <span class="sr-only">View</span>
                                                    <!-- Your eye icon here -->
                                                </button>
                                            </div>

                                            <!-- Modal overlay -->
                                            <div
                                                class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                                                x-show="deleteModalOpen2"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0"
                                                x-transition:enter-end="opacity-100"
                                                x-transition:leave="transition ease-out duration-100"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak></div>

                                            <!-- Delete Category Modal Dialog -->
                                            <div
                                                class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6"
                                                role="dialog"
                                                aria-modal="true" x-show="deleteModalOpen2"
                                                x-transition:enter="transition ease-in-out duration-200"
                                                x-transition:enter-start="opacity-0 translate-y-4"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition ease-in-out duration-200"
                                                x-transition:leave-start="opacity-100 translate-y-0"
                                                x-transition:leave-end="opacity-0 translate-y-4" aria-hidden="true"
                                                x-cloak>
                                                <!-- Modal content -->
                                                <div
                                                    class="bg-white dark:bg-slate-800 rounded shadow-lg overflow-auto max-w-lg w-full max-h-full"
                                                    @click.outside="deleteModalOpen2 = false"
                                                    @keydown.escape.window="deleteModalOpen2 = false"
                                                    style="max-width: 640px;">
                                                    <!-- Modal header -->
                                                    <div
                                                        class="px-5 py-3 border-b border-slate-200 dark:border-slate-700">
                                                        <div class="flex justify-between items-center">
                                                            <div
                                                                class="font-semibold text-slate-800 dark:text-slate-100">
                                                                Activate User
                                                            </div>
                                                            <button
                                                                class="text-slate-400 dark:text-slate-500 hover:text-slate-500 dark:hover:text-slate-400"
                                                                @click="deleteModalOpen2 = false">
                                                                <div class="sr-only">Close</div>
                                                                <svg class="w-4 h-4 fill-current">
                                                                    <path
                                                                        d="M7.95 6.536L12.192 2.293a1 1 0 111.414 1.414L9.364 7.95l4.243 4.243a1 1 0 11-1.414 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <!-- Modal content -->
                                                    <div class="px-5 py-4">
                                                        <div class="text-sm">
                                                            <div
                                                                class="font-medium text-slate-800 dark:text-slate-100 mb-3">
                                                                Are you sure you want to Activate this user?
                                                            </div>
                                                        </div>
                                                        <label class="block">
                                                            <span class="text-gray-700">Reason <b
                                                                    class="text-red-500">*</b></span>
                                                            <textarea
                                                                class="form-textarea mt-1 block w-full"
                                                                rows="3" wire:model.defer="reason" required></textarea>
                                                        </label>
                                                        <div class="text-red-500 text-xs italic">
                                                            @error('reason') <span
                                                                class="reason">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <!-- Modal footer -->
                                                    <div
                                                        class="px-5 py-4 border-t border-slate-200 dark:border-slate-700">
                                                        <div class="flex justify-end">
                                                            <button
                                                                class="btn-sm bg-gray-500 hover:bg-gray-700 text-white mr-2"
                                                                @click="deleteModalOpen2 = false">
                                                                Cancel
                                                            </button>
                                                            <button
                                                                class="btn-sm bg-indigo-600 hover:bg-indigo-700 text-white"
                                                                wire:click="unBan({{$user['id']}})">
                                                                Activate
                                                            </button>
                                                            <template x-if="collectionsCount > 0">
                                                                <button
                                                                    class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white"
                                                                    @click="deleteModalOpen2 = false">OK
                                                                </button>
                                                            </template>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                @endif

                                @if($view_capability_exists)
                                    <button wire:click="view({{$user['id']}})"
                                            class="btn border-slate-200 hover:border-slate-300">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="icon icon-tabler icon-tabler-user-circle" width="16" height="16"
                                             viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <circle cx="12" cy="12" r="9"/>
                                            <circle cx="12" cy="10" r="3"/>
                                            <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855"/>
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
<script>
    // A basic demo function to handle "select all" functionality
    document.addEventListener('alpine:init', () => {
        Alpine.data('handleSelect', () => ({
            selectall: false,
            selectAction() {
                countEl = document.querySelector('.table-items-action');
                if (!countEl) return;
                checkboxes = document.querySelectorAll('input.table-item:checked');
                document.querySelector('.table-items-count').innerHTML = checkboxes.length;
                if (checkboxes.length > 0) {
                    countEl.classList.remove('hidden');
                } else {
                    countEl.classList.add('hidden');
                }
            },
            toggleAll() {
                this.selectall = !this.selectall;
                checkboxes = document.querySelectorAll('input.table-item');
                [...checkboxes].map((el) => {
                    el.checked = this.selectall;
                });
                this.selectAction();
            },
            uncheckParent() {
                this.selectall = false;
                document.getElementById('parent-checkbox').checked = false;
                this.selectAction();
            }
        }))
    })
</script>
