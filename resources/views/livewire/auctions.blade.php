<div class="bg-white shadow-lg rounded-sm border border-slate-200">

<div x-data="{ showModal: false, auctionId: null, actionType: '', openModal(type, auctionId) { this.actionType = type === 'approve' ? 'accept' : 'reject'; this.auctionId = auctionId; this.showModal = true; }, performAction() { if (this.actionType === 'accept') { @this.approved(this.auctionId); } else { @this.rejected(this.auctionId); } this.showModal = false; } }">
        <!-- Modal backdrop -->
        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="showModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak></div>

        <div x-data="auctionModal">

            <!-- Existing table code ... -->

            <div x-data="{ showModal: false, auctionId: null, actionType: '' }">
                <!-- Modal backdrop -->
                <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="showModal" x-cloak></div>

                <!-- Accept/Reject Auction Modal Dialog -->
                <div class="fixed inset-0 z-50 overflow-hidden flex items-center justify-center px-4 sm:px-6" role="dialog" aria-modal="true" x-show="showModal" x-cloak>
                    <!-- Modal content -->
                    <div class="bg-white dark:bg-slate-800 rounded shadow-lg overflow-auto max-w-lg w-full max-h-full" @click.outside="showModal = false" @keydown.escape.window="showModal = false" style="max-width: 640px;">
                        <!-- Modal header -->
                        <div class="px-5 py-3 border-b border-slate-200 dark:border-slate-700">
                            <!-- Existing header code ... -->
                        </div>
                        <!-- Modal content -->
                        <div class="px-5 py-4">
                            <div class="text-sm">
                                <div class="font-medium text-slate-800 dark:text-slate-100 mb-3">
                                    Are you sure you want to <span x-text="actionType"></span> this auction?
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
                            @if (in_array($auction->admin_status ,["Pending", "Rejected"]))
                                <button wire:click="openModal('reject', {{$auction->id}})" class="btn border-rose-500 hover:border-rose-600">Reject</button>
                            @endif
                            @if (in_array($auction->admin_status ,["Pending", "Approved"]))
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
                    Livewire.emit('approved', this.auctionId);
                } else {
                    Livewire.emit('rejected', this.auctionId);
                }
                this.showModal = false;
            }
        }));
    });

</script>