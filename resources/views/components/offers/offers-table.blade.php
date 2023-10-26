<?php
$permissionsArray = Session::get('permissions');
//verification
$permissions = json_decode($permissionsArray, true);
$verification_capability_exists = false;
foreach ($permissions as $item) {

  if (isset($item['Offers']) && in_array('verification', $item['Offers'])) {
    $verification_capability_exists = true;
    break;
  }
}
?>
<x-loading-indicater />
    @if (session()->has('message'))
    <div class="mb-4 px-4 py-2 bg-green-100 text-green-900 rounded-md">
        {{ session('message') }}
    </div>
    @endif

<div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2 mb-2 ">
    <input type="text" wire:model.lazy="search"
           class="mt-2 w-full  rounded-md px-4 py-2 border border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none"
           placeholder="Search Offers">
</div>

<div class="bg-white shadow-lg rounded-sm border border-slate-200">
    <header class="px-5 py-4">
        <h2 class="font-semibold text-slate-800">All Offers <span class="text-slate-400 font-medium">{{$count}}</span></h2>
    </header>

    <div x-data="handleSelect">

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <!-- Table header -->
                <thead class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                    <tr>
                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Sr No</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Offer Sender</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Collection</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Price</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Offer Receiver</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Time To End</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Moderator Status</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Action</div>
                        </th>
                    </tr>
                </thead>
                <!-- Table body -->
                <tbody class="text-sm divide-y divide-slate-200">
                    <!-- Row -->
                    <?php $i=0; ?>
                    @foreach($offers as $offer)
                    <?php $i++;?>
                        <tr>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left">{{$i}}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                    <div class="w-10 h-10 shrink-0 mr-2 sm:mr-3">
                                        <img class="rounded-full" src="https://api.zeedlive.com/image/user_profile/{{$offer['user']['accountDetail']['profile_image']}}" width="40" height="40" alt="Patricia Semklo">
                                    </div>
                                    <div class="font-medium text-slate-800"><a href="{{ route("user.show",$offer['user']['id'] ) }}">{{ $offer['user']['name'] }}</a></div>
                                </div>
                            </td>

                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                    <div class="w-10 h-10 shrink-0 mr-2 sm:mr-3">
                                        @if(isset($offer['collection']))
                                        <img class="rounded-full" src="https://api.zeedlive.com/image/collection/{{$offer['collection']['image']}}" width="40" height="40" alt="Patricia Semklo">
                                        @endif
                                    </div>
                                    @if(isset($offer['collection']))
                                    <div class="font-medium text-slate-800"><a href="{{ route("collection.show",$offer['collection']['id'] ) }}">{{ $offer['collection']['title'] }}</a></div>
                                    @endif
                                </div>
                            </td>
                               <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left">SAR {{ $offer['amount'] }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                    <div class="w-10 h-10 shrink-0 mr-2 sm:mr-3">
                                        <img class="rounded-full" src="https://api.zeedlive.com/image/user_profile/{{$offer['receiver']['profile_image']}}" width="40" height="40" alt="Patricia Semklo">
                                    </div>
                                    <div class="font-medium text-slate-800"><a href="{{ route("user.show",$offer['receiver']['id'] ) }}">{{ $offer['receiver']['name'] }}</a></div>
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left">{{ $offer['time_to_end_offer'] }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <button class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border border-transparent shadow-sm bg-indigo-500 text-white duration-150 ease-in-out">{{ $offer['modrator_status'] }}</button>
                            </td>

                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            @if($verification_capability_exists)
                            @if($offer["is_accepted"] == false)
                                        <div
                                            x-data="{ deleteModalOpen2: @entangle('deleteModalOpen2'), collectionsCount: @entangle('collectionsCount') }">
                                            <div class="flex items-center">
                                                <!-- Enable Button -->
                                                <button class="btn border-slate-200 hover:border-slate-300"
                                                        @click="deleteModalOpen2 = true">
                                                    <span class="sr-only">disable</span>
                                                    <svg class="w-4 h-4 fill-current text-indigo-500 shrink-0" viewBox="0 0 16 16">
                                                        <path d="M14.3 2.3L5 11.6 1.7 8.3c-.4-.4-1-.4-1.4 0-.4.4-.4 1 0 1.4l4 4c.2.2.4.3.7.3.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4-.4-.4-1-.4-1.4 0z"></path>
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
                                                                Accept Offer
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
                                                                Are you sure you want to Accept this offer?
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Modal footer -->
                                                    <div
                                                        class="px-5 py-4 border-t border-slate-200 dark:border-slate-700">
                                                        <div class="flex justify-end">
                                                            <button
                                                                class="btn-sm bg-rose-500 hover:bg-rose-600 text-white mr-2"
                                                                @click="deleteModalOpen2 = false">
                                                                Cancel
                                                            </button>
                                                            <button
                                                                class="btn-sm bg-red-500 hover:bg-red-600 text-white"
                                                                wire:click="accept({{ $offer['offer_id'] }})">
                                                                Accept
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
{{--                            <button wire:click="accept({{ $offer['offer_id'] }})" class="btn border-slate-200 hover:border-slate-300">--}}
{{--                            <svg class="w-4 h-4 fill-current text-indigo-500 shrink-0" viewBox="0 0 16 16">--}}
{{--                                    <path d="M14.3 2.3L5 11.6 1.7 8.3c-.4-.4-1-.4-1.4 0-.4.4-.4 1 0 1.4l4 4c.2.2.4.3.7.3.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4-.4-.4-1-.4-1.4 0z"></path>--}}
{{--                                </svg>--}}
{{--                            </button>--}}
                            @endif
                            @if($offer["is_accepted"] == true)
                                    <div
                                        x-data="{ deleteModalOpen2: @entangle('deleteModalOpen2'), collectionsCount: @entangle('collectionsCount') }">
                                        <div class="flex items-center">
                                            <!-- Enable Button -->
                                            <button class="btn border-slate-200 hover:border-slate-300"
                                                    @click="deleteModalOpen2 = true">
                                                <span class="sr-only">Reject</span>
                                                <svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16">
                                                    <line x1="4" y1="4" x2="12" y2="12" stroke="currentColor" stroke-width="2" />
                                                    <line x1="4" y1="12" x2="12" y2="4" stroke="currentColor" stroke-width="2" />
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
                                                            Reject Offer
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
                                                            Are you sure you want to Reject this offer?
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div
                                                    class="px-5 py-4 border-t border-slate-200 dark:border-slate-700">
                                                    <div class="flex justify-end">
                                                        <button
                                                            class="btn-sm bg-rose-500 hover:bg-rose-600 text-white mr-2"
                                                            @click="deleteModalOpen2 = false">
                                                            Cancel
                                                        </button>
                                                        <button
                                                            class="btn-sm bg-red-500 hover:bg-red-600 text-white"
                                                            wire:click="reject({{ $offer['offer_id'] }})">
                                                            Reject
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
{{--                            <button wire:click="reject({{ $offer['offer_id'] }})" class="btn border-slate-200 hover:border-slate-300">--}}
                                    {{--                                <svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16">--}}
                                    {{--                                    <line x1="4" y1="4" x2="12" y2="12" stroke="currentColor" stroke-width="2" />--}}
                                    {{--                                    <line x1="4" y1="12" x2="12" y2="4" stroke="currentColor" stroke-width="2" />--}}
                                    {{--                                </svg>--}}
                                    {{--                            </button>--}}
                            @endif
                            @endif

                     </td>
                        </tr>

                    @endforeach
                </tbody>
            </table>
                <!-- Pagination -->

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
