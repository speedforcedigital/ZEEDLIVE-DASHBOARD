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
                            <button wire:click="accept({{ $offer['offer_id'] }})" class="btn border-slate-200 hover:border-slate-300">
                            <svg class="w-4 h-4 fill-current text-indigo-500 shrink-0" viewBox="0 0 16 16">
                                    <path d="M14.3 2.3L5 11.6 1.7 8.3c-.4-.4-1-.4-1.4 0-.4.4-.4 1 0 1.4l4 4c.2.2.4.3.7.3.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4-.4-.4-1-.4-1.4 0z"></path>
                                </svg>
                            </button>
                            @endif
                            @if($offer["is_accepted"] == true)
                            <button wire:click="reject({{ $offer['offer_id'] }})" class="btn border-slate-200 hover:border-slate-300">
                                <svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16">
                                    <line x1="4" y1="4" x2="12" y2="12" stroke="currentColor" stroke-width="2" />
                                    <line x1="4" y1="12" x2="12" y2="4" stroke="currentColor" stroke-width="2" />
                                </svg>
                            </button>
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
