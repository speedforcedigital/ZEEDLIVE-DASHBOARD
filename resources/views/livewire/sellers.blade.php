<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
            Seller Verification ✨
            </h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Delete button -->
                <x-actions.delete-button />
                <!-- Add customer button -->
                <button wire:click="filterSeller('pending')" class="btn border-slate-200 hover:border-slate-300 <?=($this->filterType=='pending' || $this->filterType=='') ? 'bg-indigo-500 text-white' : 'text-indigo-500' ?>">Pending</button>
                <button wire:click="filterSeller('verified')" class="btn border-slate-200 hover:border-slate-300 <?=($this->filterType=='verified') ? 'bg-indigo-500 text-white' : 'text-indigo-500' ?>">Verified</button>
                <button wire:click="filterSeller('rejected')" class="btn border-slate-200 hover:border-slate-300 <?=($this->filterType=='rejected') ? 'bg-indigo-500 text-white' : 'text-indigo-500' ?>">Rejected</button>
            </div>

        </div>

        <!-- Table -->
    
    <x-sellers.sellers-table :sellers="$sellers" :count="$total_sellers" />
    <!-- Pagination -->
   <div class="mt-8">
            {{$sellers->links()}}
        </div>
    </div>

   
