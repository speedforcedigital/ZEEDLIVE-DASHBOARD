<?php
$array = Session::get('permissions');
//verification
$verification_capability_exists = false;
foreach ($array as $item) {
  if (isset($item['Offers']) && in_array('verification', $item['Offers'])) {
    $verification_capability_exists = true;
    break;
  }
} 

?>
<x-loading-indicater />
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
                            <div class="font-semibold text-left">Status</div>
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
                                        <img class="rounded-full" src="https://api.staging.zeedlive.com/image/user_profile/{{$offer['offer_sender'][0]['profile_image']}}" width="40" height="40" alt="Patricia Semklo">
                                    </div>
                                    <div class="font-medium text-slate-800"><a href="#">{{ $offer['offer_sender'][0]['name'] }}</a></div>
                                </div>
                            </td>

                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                    <div class="w-10 h-10 shrink-0 mr-2 sm:mr-3">
                                        <img class="rounded-full" src="https://api.staging.zeedlive.com/image/collection/{{$offer['offer_collection'][0]['image']}}" width="40" height="40" alt="Patricia Semklo">
                                    </div>
                                    <div class="font-medium text-slate-800"><a href="#">{{ $offer['offer_collection'][0]['title'] }}</a></div>
                                </div>
                            </td>

                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                    <div class="w-10 h-10 shrink-0 mr-2 sm:mr-3">
                                        <img class="rounded-full" src="https://api.staging.zeedlive.com/image/user_profile/{{$offer['offer_receiver'][0]['profile_image']}}" width="40" height="40" alt="Patricia Semklo">
                                    </div>
                                    <div class="font-medium text-slate-800"><a href="#">{{ $offer['offer_receiver'][0]['name'] }}</a></div>
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
                            <button wire:click="accept({{ $offer['offer_id'] }})" class="btn border-slate-200 hover:border-slate-300">
                            <svg class="w-4 h-4 fill-current text-indigo-500 shrink-0" viewBox="0 0 16 16">
                                    <path d="M14.3 2.3L5 11.6 1.7 8.3c-.4-.4-1-.4-1.4 0-.4.4-.4 1 0 1.4l4 4c.2.2.4.3.7.3.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4-.4-.4-1-.4-1.4 0z"></path>
                                </svg>
                            </button>
                            @endif
   
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
