<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Reported Listings</h1>
        </div>
    </div>
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Left side -->
        <div class="mb-4 sm:mb-0">
        </div>



    </div>
    <!-- Message Container -->
    @if (session()->has('message'))
    <div class="mb-4 px-4 py-2 bg-green-100 text-green-900 rounded-md">
        {{ session('message') }}
    </div>
    @endif
    <!-- Table -->
    <div class="bg-white shadow-lg rounded-sm border border-slate-200">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800">All Reported Listings <span
                    class="text-slate-400 font-medium">{{$total_listings}}</span></h2>
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
                                <div class="font-semibold text-left">Reported By</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Collection</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Seller</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Date</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Action</div>
                            </th>
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm divide-y divide-slate-200">
                        <!-- Row -->
                        <?php $perPage = 10; $startingPoint = (($listings->currentPage() - 1) * $perPage) + 1; ?>
                        @foreach($listings as $listing)

                        <tr>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left">{{$startingPoint++}}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="font-medium text-slate-800"><a href="#"
                                            wire:click="view({{ $listing->user->id }})"> {{$listing->user->name}}</a>
                                    </div>
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="font-medium text-slate-800"> <a href="{{ route('collection.show',$listing->lot->collection->id) }}">{{$listing->lot->collection->title}} </a> </div>
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="font-medium text-slate-800"> <a href="#"
                                            wire:click="view({{ $listing->lot->auction->user->id }})">
                                            {{$listing->lot->auction->user->name}} </a></div>
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="font-medium text-slate-800">{{$listing->created_at}}</div>
                                </div>
                            </td>


                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="space-x-1">

                                    <button class="text-slate-400 hover:text-slate-500 rounded-full"
                                        wire:click="reportDetail({{ $listing->id }})">
                                        <span class="sr-only">Detail</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id"
                                            width="27" height="27" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                                            <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                            <path d="M15 8l2 0" />
                                            <path d="M15 12l2 0" />
                                            <path d="M7 16l10 0" />
                                        </svg>
                                    </button>
                                    <button class="text-slate-400 hover:text-slate-500 rounded-full"
                                        wire:click="viewProducts({{ $listing->lot->id }})">
                                        <span class="sr-only">View</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye"
                                            width="27" height="27" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path
                                                d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                        </svg>
                                    </button>
                                    <button class="text-slate-400 hover:text-slate-500 rounded-full"
                                        wire:click="delete({{ $listing->id }})">
                                        <span class="sr-only">Block</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ban"
                                            width="27" height="27" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                            <path d="M5.7 5.7l12.6 12.6" />
                                        </svg>
                                    </button>
                                </div>


                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if($showModal)
        <div class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-800 opacity-50"></div>
                </div>

                <!-- Modal content -->
                <div
                    class="bg-white rounded-xl w-3/4 md:w-1/2 lg:w-1/3 overflow-hidden shadow-2xl transform transition-all">
                    <!-- Header -->
                    <div class="bg-gray-100 p-5 border-b border-gray-200 rounded-t-xl">
                        <h3 class="text-xl leading-6 font-semibold text-gray-900">
                            Report Subject: {{ $report->subject }}
                        </h3>
                    </div>

                    <!-- Body -->
                    <div class="p-5">
                        <p class="text-gray-700 leading-relaxed">
                            {{ $report->message }}
                        </p>
                    </div>
                    <!-- Footer -->
                    <div class="flex justify-end bg-gray-100 p-5 rounded-b-xl border-t border-gray-200">
                        <button wire:click="$set('showModal', false)"
                            class="px-5 py-2 text-gray-100 bg-red-600 hover:bg-red-700 transition duration-150 rounded">Close</button>
                    </div>
                </div>
            </div>
        </div>

        @endif
    </div>

    <!-- Pagination -->
    <div class="px-5 py-3">
        {{ $listings->links() }}
    </div>
</div>
