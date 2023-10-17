<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold"> Livestream Products</h1>
        </div>
    </div>


    <div class="flex justify-between mb-2">
        <div class="flex">
            <ul class="flex">
                <li class="m-1">
                    <button wire:click="filter('all')"
                            class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border {{ $selected === 'all' ? 'border-indigo-500' : 'border-transparent' }} shadow-sm {{ $selected === 'all' ? 'bg-indigo-500 text-white' : 'bg-white text-slate-500' }} duration-150 ease-in-out">
                        All <span
                            class="ml-1 {{ $selected === 'all' ? 'text-indigo-200' : 'text-slate-400' }}">{{ $total_products_count }}</span>
                    </button>
                </li>
                <li class="m-1">
                    <button wire:click="filter('scheduled')"
                            class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border {{ $selected === 'scheduled' ? 'border-indigo-500' : 'border-transparent' }} shadow-sm {{ $selected === 'scheduled' ? 'bg-indigo-500 text-white' : 'bg-white text-slate-500' }} duration-150 ease-in-out">
                        Schdeuled <span
                            class="ml-1 {{ $selected === 'scheduled' ? 'text-indigo-200' : 'text-slate-400' }}">{{ $scheduledProducts }}</span>
                    </button>
                </li>
                <li class="m-1">
                    <button wire:click="filter('on_going')"
                            class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border {{ $selected === 'on_going' ? 'border-indigo-500' : 'border-transparent' }} shadow-sm {{ $selected === 'on_going' ? 'bg-indigo-500 text-white' : 'bg-white text-slate-500' }} duration-150 ease-in-out">
                        On Going <span
                            class="ml-1 {{ $selected === 'on_going' ? 'text-indigo-200' : 'text-slate-400' }}">{{ $onGoingProducts }}</span>
                    </button>
                </li>
                <li class="m-1">
                    <button wire:click="filter('ended')"
                            class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border {{ $selected === 'ended' ? 'border-indigo-500' : 'border-transparent' }} shadow-sm {{ $selected === 'ended' ? 'bg-indigo-500 text-white' : 'bg-white text-slate-500' }} duration-150 ease-in-out">
                        Closed <span
                            class="ml-1 {{ $selected === 'ended' ? 'text-indigo-200' : 'text-slate-400' }}">{{ $endedProducts }}</span>
                    </button>
                </li>
                <li class="m-1">
                    <button wire:click="filter('sold')"
                            class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border {{ $selected === 'sold' ? 'border-indigo-500' : 'border-transparent' }} shadow-sm {{ $selected === 'sold' ? 'bg-indigo-500 text-white' : 'bg-white text-slate-500' }} duration-150 ease-in-out">
                        Sold <span
                            class="ml-1 {{ $selected === 'sold' ? 'text-indigo-200' : 'text-slate-400' }}">{{ $sold_products }}</span>
                    </button>
                </li>
            </ul>
        </div>

        <div class="flex">
            <input type="text" wire:model.lazy="search"
                   class="rounded-md px-4 py-2 border border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none "
                   placeholder="Search">
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
            <h2 class="font-semibold text-slate-800">All Products <span
                    class="text-slate-400 font-medium">{{$total_products}}</span></h2>
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
                    <?php $perPage = 10; $startingPoint = (($products->currentPage() - 1) * $perPage) + 1; ?>
                    @foreach($products as $product)

                        <tr>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left">{{$startingPoint++}}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="font-medium text-slate-800"><a
                                            href="{{ route('collection.show', $product->collection_id) }}"> {{$product->title}} </a>
                                    </div>
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-left">
                                        @if (in_array($product->auction->admin_status ,["Rejected"]))
                                            <div
                                                class="text-xs inline-flex font-medium rounded-full text-center px-2.5 py-1 bg-rose-100 text-rose-500">
                                                {{ $product->auction->admin_status }}</div>
                                        @elseif (in_array($product->auction->admin_status ,["Pending"]))
                                            <div
                                                class="text-xs inline-flex font-medium rounded-full text-center px-2.5 py-1 bg-slate-100 text-slate-500">
                                                {{ $product->auction->admin_status }}</div>
                                        @else
                                            <div
                                                class="text-xs inline-flex font-medium rounded-full text-center px-2.5 py-1 bg-emerald-100 text-emerald-600">
                                                {{ $product->auction->admin_status }}</div>
                                        @endif

                                    </div>
                                </div>
                            </td>

                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                @if (in_array($product->auction->admin_status ,["Pending"]))
                                    <div class="space-x-1">
                                        <button class="text-slate-400 hover:text-slate-500 rounded-full"
                                                wire:click="approve({{ $product->auction->id }})">
                                            <span class="sr-only">Approve</span>
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-check" width="27" height="27"
                                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M5 12l5 5l10 -10"/>
                                            </svg>
                                        </button>
                                        <button class="text-slate-400 hover:text-slate-500 rounded-full"
                                                wire:click="reject({{ $product->auction->id }})">
                                            <span class="sr-only">Reject</span>
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-ban"
                                                 width="27" height="27" viewBox="0 0 24 24" stroke-width="1.5"
                                                 stroke="#2c3e50" fill="none" stroke-linecap="round"
                                                 stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/>
                                                <path d="M5.7 5.7l12.6 12.6"/>
                                            </svg>
                                        </button>
                                        <button class="text-slate-400 hover:text-slate-500 rounded-full"
                                                wire:click="view({{ $product->id }})">
                                            <span class="sr-only">View</span>
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-eye"
                                                 width="27" height="27" viewBox="0 0 24 24" stroke-width="1.5"
                                                 stroke="#2c3e50" fill="none" stroke-linecap="round"
                                                 stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                                <path
                                                    d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                            </svg>
                                        </button>
                                    </div>

                                @elseif(in_array($product->auction->admin_status , ["Approved", "Rejected"]))

                                    <div class="space-x-1">
                                        @if($product->auction->auction_status == "Open")
                                            <button class="text-slate-400 hover:text-slate-500 rounded-full"
                                                    wire:click="view({{ $product->id }})">
                                                <span class="sr-only">View</span>
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="icon icon-tabler icon-tabler-device-tv" width="27"
                                                     height="27" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50"
                                                     fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path
                                                        d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"/>
                                                    <path d="M16 3l-4 4l-4 -4"/>
                                                </svg>
                                            </button>
                                        @elseif ($product->auction->auction_status == "Closed")
                                            <button class="text-slate-400 hover:text-slate-500 rounded-full"
                                                    wire:click="view({{ $product->id }})">
                                                <span class="sr-only">View</span>
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="icon icon-tabler icon-tabler-player-stop" width="27"
                                                     height="27" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50"
                                                     fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path
                                                        d="M5 5m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z"/>
                                                </svg>
                                            </button>

                                        @endif
                                        <button class="text-slate-400 hover:text-slate-500 rounded-full"
                                                wire:click="view({{ $product->id }})">
                                            <span class="sr-only">View</span>
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-eye"
                                                 width="27" height="27" viewBox="0 0 24 24" stroke-width="1.5"
                                                 stroke="#2c3e50" fill="none" stroke-linecap="round"
                                                 stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                                <path
                                                    d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                            </svg>
                                        </button>
                                    </div>
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
        {{ $products->links() }}
    </div>
</div>
