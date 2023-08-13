<div class="bg-white shadow-lg rounded-sm border border-slate-200">
    <x-loading-indicater />
    <header class="px-5 py-4">
        <h2 class="font-semibold text-slate-800">All Auctions <span class="text-slate-400 font-medium">{{$total_auctions}}</span></h2>
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
                            <div class="font-semibold text-left">Title</div>
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
                    <?php $perPage = 10; $startingPoint = (($auctions->currentPage() - 1) * $perPage) + 1; ?>
                    @foreach($auctions as $auction)
                        <tr>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="text-left">{{$startingPoint++}}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                    <div class="font-medium text-slate-800">{{$auction->collection_title}}</div>
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                    <div class="font-medium text-slate-800">{{$auction->admin_status}}</div>
                                </div>
                            </td>

                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                @if (in_array($auction->admin_status ,["Pending", "Rejected"]) )
                                <button wire:click="approved({{$auction->id}})" class="btn border-slate-200 hover:border-slate-300">Approve</button>
                                @endif
                                @if (in_array($auction->admin_status ,["Pending", "Approved"]) )
                                <button wire:click="rejected({{$auction->id}})" class="btn border-slate-200 hover:border-slate-300">Reject</button>
                                @endif
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                @if (in_array($auction->admin_status ,["Pending", "Rejected"]) )
                                    <button wire:click="openModal('reject', {{$auction->id}})" class="btn border-rose-500 hover:border-rose-600">Reject</button>
                                @endif
                                @if (in_array($auction->admin_status ,["Pending", "Approved"]) )
                                    <button wire:click="openModal('approve', {{$auction->id}})" class="btn border-green-500 hover:border-green-600">Accept</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="px-5 py-3">
                {{ $auctions->links() }}
            </div>

            <div x-data="{ showModal: false, auctionId: null, actionType: '' }">
                <!-- Modal backdrop -->
                <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="showModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak></div>

                <!-- Accept/Reject Auction Modal Dialog -->
                <div class="fixed inset-0 z-50 overflow-hidden flex items-center justify-center px-4 sm:px-6" role="dialog" aria-modal="true" x-show="showModal" x-transition:enter="transition ease-in-out duration-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in-out duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" aria-hidden="true" x-cloak>
                    <!-- Modal content -->
                    <div class="bg-white dark:bg-slate-800 rounded shadow-lg overflow-auto max-w-lg w-full max-h-full" @click.outside="showModal = false" @keydown.escape.window="showModal = false" style="max-width: 640px;">
                        <!-- Modal header -->
                        <div class="px-5 py-3 border-b border-slate-200 dark:border-slate-700">
                            <div class="flex justify-between items-center">
                                <div class="font-semibold text-slate-800 dark:text-slate-100">Confirm Action</div>
                                <button class="text-slate-400 dark:text-slate-500 hover:text-slate-500 dark:hover:text-slate-400" @click="showModal = false">
                                    <div class="sr-only">Close</div>
                                    <svg class="w-4 h-4 fill-current">
                                        <path d="M7.95 6.536L12.192 2.293a1 1 0 111.414 1.414L9.364 7.95l4.243 4.243a1 1 0 11-1.414 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <!-- Modal content -->
                        <div class="px-5 py-4">
                            <div class="text-sm">
                                <div class="font-medium text-slate-800 dark:text-slate-100 mb-3">
                                    Are you sure you want to {{ $actionType }} this auction?
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="px-5 py-4 border-t border-slate-200 dark:border-slate-700">
                            <div class="flex justify-end">
                                <button class="btn-sm bg-rose-500 hover:bg-rose-600 text-white mr-2" @click="showModal = false">Cancel</button>
                                <button class="btn-sm bg-green-500 hover:bg-green-600 text-white" @click="performAction">Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>
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
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('auctionModal', () => ({
            showModal: false,
            auctionId: null,
            actionType: '',
            openModal(type, auctionId) {
                this.actionType = type === 'approve' ? 'accept' : 'reject';
                this.auctionId = auctionId;
                this.showModal = true;
            },
            performAction() {
                // Perform the accept/reject action using Livewire
                if (this.actionType === 'accept') {
                    Livewire.emit('acceptAuction', this.auctionId);
                } else {
                    Livewire.emit('rejectAuction', this.auctionId);
                }
                this.showModal = false;
            }
        }));
    });
</script>