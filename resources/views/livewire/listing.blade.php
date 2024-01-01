<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Reported Listings</h1>
        </div>
{{--        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">--}}
{{--            <a href="{{ route('dashboard') }}"--}}
{{--               class="btn-sm text-white hover:text-white bg-indigo-600 hover:bg-indigo-800">--}}
{{--                <!-- back button icon -->--}}
{{--                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left"--}}
{{--                     width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"--}}
{{--                     stroke-linecap="round" stroke-linejoin="round">--}}
{{--                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>--}}
{{--                    <line x1="5" y1="12" x2="15" y2="12"/>--}}
{{--                    <line x1="5" y1="12" x2="9" y2="16"/>--}}
{{--                    <line x1="5" y1="12" x2="9" y2="8"/>--}}
{{--                </svg>--}}
{{--                <span>Back</span>--}}
{{--            </a>--}}
{{--        </div>--}}
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

    <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2 mb-2 ">
        <input type="text" wire:model.lazy="search"
               class="mt-2 w-full  rounded-md px-4 py-2 border border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none"
               placeholder="Search">
    </div>
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
                                    <div class="font-medium text-slate-800"> <a href="{{ route('collection.show',$listing->lot->collection->id ?? '') }}">{{$listing->lot->collection->title ?? ''}} </a> </div>
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
                                <div class="flex space-x-1 items-center">


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
{{--                                    <button class="text-slate-400 hover:text-slate-500 rounded-full"--}}
{{--                                        wire:click="delete({{ $listing->id }})">--}}
{{--                                        <span class="sr-only">Block</span>--}}
{{--                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ban"--}}
{{--                                            width="27" height="27" viewBox="0 0 24 24" stroke-width="1.5"--}}
{{--                                            stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">--}}
{{--                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />--}}
{{--                                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />--}}
{{--                                            <path d="M5.7 5.7l12.6 12.6" />--}}
{{--                                        </svg>--}}
{{--                                    </button>--}}
                                    <div
                                        x-data="{ acceptModalOpen: @entangle('acceptModalOpen') }">

                                        <div class="flex items-center">
                                            <!-- Enable Button -->
                                            <button class="text-slate-400 hover:text-slate-500 rounded-full"
                                                    @click="acceptModalOpen = true">
                                                <span class="sr-only">Block</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ban"
                                                     width="27" height="27" viewBox="0 0 24 24" stroke-width="1.5"
                                                     stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                    <path d="M5.7 5.7l12.6 12.6" />
                                                </svg>
                                            </button>

                                            <!-- Eye Button -->
                                            <button class="text-slate-400 hover:text-slate-500 rounded-full ml-2"
                                                    @click="/* Add your logic here */">
                                                <span class="sr-only">View</span>
                                                <!-- Your eye icon here -->
                                            </button>
                                        </div>

                                        <!-- Modal overlay -->
                                        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                                             x-show="acceptModalOpen"
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="opacity-0"
                                             x-transition:enter-end="opacity-100"
                                             x-transition:leave="transition ease-out duration-100"
                                             x-transition:leave-start="opacity-100"
                                             x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak></div>

                                        <!-- Delete Category Modal Dialog -->
                                        <div
                                            class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6"
                                            role="dialog"
                                            aria-modal="true"
                                            x-show="acceptModalOpen"
                                            x-transition:enter="transition ease-in-out duration-200"
                                            x-transition:enter-start="opacity-0 translate-y-4"
                                            x-transition:enter-end="opacity-100 translate-y-0"
                                            x-transition:leave="transition ease-in-out duration-200"
                                            x-transition:leave-start="opacity-100 translate-y-0"
                                            x-transition:leave-end="opacity-0 translate-y-4" aria-hidden="true"
                                            x-cloak>
                                            <!-- Modal content -->
                                            <div
                                                class="bg-white dark:bg-slate-800 rounded shadow-lg overflow-auto max-w-lg w-full max-h-full"
                                                @click.outside="acceptModalOpen = false"
                                                @keydown.escape.window="acceptModalOpen = false"
                                                style="max-width: 640px;">
                                                <!-- Modal header -->
                                                <div
                                                    class="px-5 py-3 border-b border-slate-200 dark:border-slate-700">
                                                    <div class="flex justify-between items-center">
                                                        <div
                                                            class="font-semibold text-slate-800 dark:text-slate-100">
                                                            Block Listing
                                                        </div>
                                                        <button
                                                            class="text-slate-400 dark:text-slate-500 hover:text-slate-500 dark:hover:text-slate-400"
                                                            @click="acceptModalOpen = false">
                                                            <div class="sr-only">Close</div>
                                                            <svg class="w-4 h-4 fill-current">
                                                                <path
                                                                    d="M7.95 6.536L12.192 2.293a1 1 0 111.414 1.414L9.364 7.95l4.243 4.243a1 1 0 11-1.414 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- Modal content -->
                                                <div class="px-5 py-4">
                                                    <div class="text-sm">
                                                        <div
                                                            class="font-medium text-slate-800 dark:text-slate-100 mb-3">
                                                            Are you sure you want to Block this Listing?
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div
                                                    class="px-5 py-4 border-t border-slate-200 dark:border-slate-700">
                                                    <div class="flex justify-end">
                                                        <button
                                                            class="btn-sm bg-gray-500 hover:bg-gray-700 text-white mr-2"
                                                            @click="acceptModalOpen = false">
                                                            Cancel
                                                        </button>
                                                        <button
                                                            class="btn-sm bg-indigo-600 hover:bg-indigo-700 text-white"
                                                            wire:click="delete({{ $listing->id }})">
                                                            Block
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


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
