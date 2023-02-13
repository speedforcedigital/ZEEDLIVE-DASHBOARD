<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
            Auction Verification ✨
            </h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Delete button -->
                <x-actions.delete-button />
                <!-- Add customer button -->
                <button wire:click="filterAuction('all')" class="btn border-slate-200 hover:border-slate-300 <?=($this->filterType=='all' || $this->filterType=='') ? 'bg-indigo-500 text-white' : 'text-indigo-500' ?>">All</button>
                <button wire:click="filterAuction('pending')" class="btn border-slate-200 hover:border-slate-300 <?=($this->filterType=='pending') ? 'bg-indigo-500 text-white' : 'text-indigo-500' ?>">Pending</button>
                <button wire:click="filterAuction('verified')" class="btn border-slate-200 hover:border-slate-300 <?=($this->filterType=='verified') ? 'bg-indigo-500 text-white' : 'text-indigo-500' ?>">Active</button>
                <button wire:click="filterAuction('rejected')" class="btn border-slate-200 hover:border-slate-300 <?=($this->filterType=='rejected') ? 'bg-indigo-500 text-white' : 'text-indigo-500' ?>">Rejected</button>
            </div>

        </div>

        <!-- Table -->
    
    <x-auctions.auctions-table :auctions="$auctions" :count="$total_auctions" />
    <!-- Pagination -->
   <div class="mt-8">
            {{$auctions->links()}}
        </div>
    </div>

   