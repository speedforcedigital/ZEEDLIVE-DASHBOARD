@php
    $permissionsArray = json_decode(Session::get('permissions'), true);
    $verification_capability_exists = false;
    $delete_capability_exists = false;

    foreach ($permissionsArray as $item) {
        if (isset($item['Auction'])) {
            if (in_array('verification', $item['Auction'])) {
                $verification_capability_exists = true;
            }
            if (in_array('delete', $item['Auction'])) {
                $delete_capability_exists = true;
            }
        }
    }
@endphp

<x-loading-indicater />

<div class="bg-white shadow-lg rounded-sm border border-slate-200">
    <header class="px-5 py-4">
        <h2 class="font-semibold text-slate-800">Sellers <span class="text-slate-400 font-medium">{{ $count }}</span></h2>
    </header>

    <div x-data="handleSelect">
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full" id="dataTable">
                <!-- Table header -->
                <thead class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                    <tr>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Sr No</div>
                        </th>
                        <!-- Add other table headers here -->
                        <!-- ... -->
                        @if($this->filterType=='all' || $this->filterType=='')
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Action</div>
                        </th>
                        @endif
                    </tr>
                </thead>
                <!-- Table body -->
                <tbody class="text-sm divide-y divide-slate-200">
                    <!-- Row -->
                    @foreach($auctions as $index => $auction)
                        <tr>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left">{{ $index + 1 }}</div>
                            </td>
                            <!-- Add other table data here -->
                            <!-- ... -->
                            @if($this->filterType=='all' || $this->filterType=='pending' || $this->filterType=='')       
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    @if($verification_capability_exists)
                                        <button wire:click="approved({{ $auction['auction']['id'] }}, {{$auction['auction']['collection_id']}})" class="btn border-slate-200 hover:border-slate-300">
                                            <svg class="w-4 h-4 fill-current text-indigo-500 shrink-0" viewBox="0 0 16 16">
                                                <path d="M14.3 2.3L5 11.6 1.7 8.3c-.4-.4-1-.4-1.4 0-.4.4-.4 1 0 1.4l4 4c.2.2.4.3.7.3.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4-.4-.4-1-.4-1.4 0z"></path>
                                            </svg>
                                        </button>
                                    @endif
                                    @if($delete_capability_exists)
                                        <button wire:click="rejected({{ $auction['auction']['id'] }})" class="btn border-slate-200 hover:border-slate-300">
                                            <svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16">
                                                <line x1="4" y1="4" x2="12" y2="12" stroke="currentColor" stroke-width="2" />
                                                <line x1="4" y1="12" x2="12" y2="4" stroke="currentColor" stroke-width="2" />
                                            </svg>
                                        </button>
                                    @endif
                                </td>
                            @endif
                        </tr>                      
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
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