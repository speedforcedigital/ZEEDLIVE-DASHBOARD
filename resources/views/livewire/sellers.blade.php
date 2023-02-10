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
                <button class="btn border-slate-200 hover:border-slate-300 bg-indigo-500 text-white">Add Brand</button>
               
            </div>

        </div>

        <!-- Table -->
    
    <x-sellers.sellers-table :sellers="$sellers" :count="$total_sellers" />
    <!-- Pagination -->
   <div class="mt-8">
            {{$sellers->links()}}
        </div>
    </div>

   
