<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold"> Orders</h1>
        </div>
    </div>

    <div class="flex justify-between mb-2">
        <div class="flex">
            <ul class="flex">
                <li>
                    <button wire:click="filter('pending')"
                            class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border {{ $selected === 'pending' ? 'border-indigo-500' : 'border-transparent' }} shadow-sm {{ $selected === 'pending' ? 'bg-indigo-500 text-white' : 'bg-white text-slate-500' }} duration-150 ease-in-out">
                        Pending <span
                            class="ml-1 {{ $selected === 'pending' ? 'text-indigo-200' : 'text-slate-400' }}">{{ $totalPendingOrders }}</span>
                    </button>
                </li>
                <li class="ml-2">
                    <button wire:click="filter('shipped')"
                            class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border {{ $selected === 'shipped' ? 'border-indigo-500' : 'border-transparent' }} shadow-sm {{ $selected === 'shipped' ? 'bg-indigo-500 text-white' : 'bg-white text-slate-500' }} duration-150 ease-in-out">
                        Shipped <span
                            class="ml-1 {{ $selected === 'shipped' ? 'text-indigo-200' : 'text-slate-400' }}">{{ $totalShippedOrders }}</span>
                    </button>
                </li>
                <li class="ml-2">
                    <button wire:click="filter('delivered')"
                            class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border {{ $selected === 'delivered' ? 'border-indigo-500' : 'border-transparent' }} shadow-sm {{ $selected === 'delivered' ? 'bg-indigo-500 text-white' : 'bg-white text-slate-500' }} duration-150 ease-in-out">
                        Delivered <span
                            class="ml-1 {{ $selected === 'delivered' ? 'text-indigo-200' : 'text-slate-400' }}">{{ $totalDeliveredOrders }}</span>
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
            <h2 class="font-semibold text-slate-800">All Orders <span
                    class="text-slate-400 font-medium">{{$totalOrders}}</span></h2>
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
                            <div class="font-semibold text-left">Seller</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Buyer</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Status</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Order ID</div>
                        </th>
                        @if($selected === 'shipped' || $selected === 'delivered' )
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Tracking Number</div>
                        </th>
                        @endif

                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Action</div>
                        </th>
                    </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm divide-y divide-slate-200">
                    <!-- Row -->
                    <?php $perPage = 10; $startingPoint = (($orders->currentPage() - 1) * $perPage) + 1; ?>
                    @foreach($orders as $order)
{{--                        {{dd($orders)}}--}}

                        <tr>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left">{{$startingPoint++}}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="font-medium text-slate-800">
                                        <a
                                            href="{{route('user.show',$order->seller->id)}}"> {{$order->seller->name}}</a>
                                    </div>
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="font-medium text-slate-800">
                                        <a
                                            href="{{route('user.show',$order->customer->id ?? '' )}}">{{$order->customer?->name }} </a>
                                    </div>
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-left">
                                        <div
                                            class="text-xs inline-flex font-medium rounded-full text-center px-2.5 py-1 bg-emerald-100 text-emerald-600">
                                            @if($order->is_shipped == "0" && $order->is_deliverd == "0")
                                                Pending
                                            @elseif($order->is_deliverd == "1")
                                                Delivered
                                            @elseif($order->is_shipped == "1" && $order->is_deliverd == "0")
                                                Shipped
                                            @endif</div>

                                    </div>
                                </div>
                            </td>

                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left">{{$order->order_id ?? 'Null'}}</div>
                            </td>
                            @if($selected === 'shipped' || $selected === 'delivered' )
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left">{{$order->tracking_number ?? 'Null'}}</div>
                            </td>
                            @endif

                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="space-x-1">
                                    <button class="text-slate-400 hover:text-slate-500 rounded-full"
                                            wire:click="orderDetail({{ $order->id }})">
                                        <span class="sr-only">View</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id"
                                             width="27" height="27" viewBox="0 0 24 24" stroke-width="1.5"
                                             stroke="#2c3e50" fill="none" stroke-linecap="round"
                                             stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path
                                                d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z"/>
                                            <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/>
                                            <path d="M15 8l2 0"/>
                                            <path d="M15 12l2 0"/>
                                            <path d="M7 16l10 0"/>
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
                        class="bg-white rounded-xl w-9/10 sm:w-3/4 md:w-1/2 lg:w-1/3 xl:w-1/4 overflow-hidden shadow-2xl transform transition-all">
                        <!-- Header -->
                        <div class="bg-gray-100 p-5 border-b border-gray-200 rounded-t-xl">
                            <h3 class="text-xl leading-6 font-semibold text-gray-900">
                                Order Details
                            </h3>
                        </div>
                        <!-- Body -->
                        <div class="p-5">
                            <p class="text-gray-700 leading-relaxed"><strong>Seller:</strong> <a
                                    href="{{ route("user.show",$order->customer->id ) }}">  {{ $order->customer->name }}</a>
                            </p>
                            <p class="text-gray-700 leading-relaxed"><strong>Product:</strong> <a
                                    href="{{ route("product.show",$order->lot->id ) }}">  {{ $order->lot->title }}</a>
                            </p>
                            <p class="text-gray-700 leading-relaxed"><strong>Date:</strong> {{ $order->created_at }}</p>
                            <p class="text-gray-700 leading-relaxed"><strong>Price:</strong> SAR {{ $order->sub_total }}
                            </p>

                            <!-- Pictures -->
                            <div class="my-4">
                                <h4 class="font-semibold mb-2">Pictures:</h4>
                                <div class="flex space-x-2 h-24 overflow-x-auto">
                                    {{-- @foreach($order->pictures as $picture) --}}
                                    <img src="{{ asset('images/product/images/' . $order->lot->image) }}"
                                         class="object-cover rounded"/>
                                    {{-- @endforeach --}}
                                </div>
                            </div>


                            <!-- Seller Documents -->
                            <div class="my-4">
                                <h4 class="font-semibold mb-2">Seller Documents:</h4>
                                <ul>
                                    @if($order->seller && $order->seller->SellerVerification)
                                        <li><a href="{{ $order->seller->SellerVerification->document1 }}"
                                               class="text-blue-500 hover:underline"
                                               target="_blank">{{ $document->name }}</a></li>
                                    @else
                                        No Seller Document
                                    @endif

                                </ul>
                            </div>

                            <!-- Shipping Details -->
                            <div class="my-4">
                                <h4 class="font-semibold mb-2">Shipping Details:</h4>
                                <p class="text-gray-700 leading-relaxed"><strong>Address:</strong>
                                    {{ $order->address->address }}</p>
                                <p class="text-gray-700 leading-relaxed"><strong>Status:</strong> {{ $order->status }}
                                </p>
                                <!-- Additional Shipping Details Here -->
                            </div>
                        </div>
                        <!-- Footer -->
                        <div class="flex justify-end bg-gray-100 p-5 rounded-b-xl border-t border-gray-200">
                            <button wire:click="$set('showModal', false)"
                                    class="px-5 py-2 text-gray-100 bg-red-600 hover:bg-red-700 transition duration-150 rounded">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        @endif
    </div>

    <!-- Pagination -->
    <div class="px-5 py-3">
        {{ $orders->links() }}
    </div>
</div>
