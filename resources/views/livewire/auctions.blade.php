<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold"> All Auctions</h1>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white shadow-lg rounded-sm border border-slate-200">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800">All Auctions <span
                    class="text-slate-400 font-medium">{{$total_auctions}}</span></h2>
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
                                    <div class="font-medium text-slate-800">
                                        <a href="{{ route("collection.show", $auction->collection_id ) }}"> {{$auction->collection_title}} </a></div>
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="font-medium text-slate-800">{{$auction->admin_status}}</div>
                                </div>
                            </td>

                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                @if (in_array($auction->admin_status ,["Pending", "Rejected"]))
                                <button wire:click="rejected({{ $auction->id }})"
                                    class="btn border-rose-500 hover:border-rose-600">Reject</button>
                                @endif
                                @if (in_array($auction->admin_status ,["Pending", "Approved"]))
                                <button wire:click="approved({{ $auction->id }})"
                                    class="btn border-green-500 hover:border-green-600">Accept</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="px-5 py-3">
        {{ $auctions->links() }}
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
        Alpine.data('auctionModalData', () => ({
            showModal: false,
            auctionId: null,
            actionType: '',
            auctionTitle: '', // Add this property to store auction title
            openModal(type, auctionId, auctionTitle) {
                this.actionType = type === 'approve' ? 'accept' : 'reject';
                this.auctionId = auctionId;
                this.auctionTitle = auctionTitle; // Set the auction title
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
