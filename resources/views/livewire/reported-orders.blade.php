<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Reported Orders</h1>
        </div>

        <!-- back button on right side -->
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

    <div class="flex justify-between mb-2">


        <div class="flex">
            <input type="text" wire:model.lazy="search"
                   class="rounded-md px-4 py-2 border border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none "
                   placeholder="Search">
        </div>
    </div>

    <!-- Message Container -->
    @if (session()->has('message'))
        <div class="mb-4 px-4 py-2 bg-green-100 text-green-900 rounded-md alert-success">
            {{ session('message') }}
        </div>
    @endif
    <!-- Table -->


    <div class="bg-white shadow-lg rounded-sm border border-slate-200">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800">All Orders <span
                    class="text-slate-400 font-medium"></span></h2>
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
                            <div class="font-semibold text-left">Product</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Seller</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Buyer</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Order ID</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Status</div>
                        </th>
                        {{--                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">--}}
                        {{--                            <div class="font-semibold text-left">Images</div>--}}
                        {{--                        </th>--}}
                        {{--                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">--}}
                        {{--                            <div class="font-semibold text-left">Videos</div>--}}
                        {{--                        </th>--}}

                        {{--                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">--}}
                        {{--                            <div class="font-semibold text-left">Description</div>--}}
                        {{--                        </th>--}}
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

                        <tr>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left">{{$startingPoint++}}</div>
                            </td>

                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left">
                                    <a href="{{route('product.show',$order->lot->id)}}"> {{$order->lot->title ?? 'No Name'}}</a>
                                </div>
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
                                            href="{{route('user.show',$order->customer->id )}}">{{$order->customer->name }} </a>
                                    </div>
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="font-medium text-slate-800">
                                        {{$order->order_id ?? 'Null'}}
                                    </div>
                                </div>
                            </td>

                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="font-medium text-slate-800">
                                        @if($order->is_reported == 1  && $order->is_returned==0)
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Reported
                                            </span>
                                        @elseif($order->is_returned==1)
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-green-700">
                                                Returned
                                            </span>
                                        @endif

                                    </div>
                                </div>
                            </td>


                            {{--                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">--}}
                            {{--                                <div class="flex items-center">--}}
                            {{--                                    <div class="swiper-container">--}}
                            {{--                                        <div class="swiper-wrapper">--}}
                            {{--                                            @foreach($order->report_images as $image)--}}
                            {{--                                                <div class="swiper-slide">--}}
                            {{--                                                    <img src="{{ $image }}" alt="image" class="w-5 h-auto">--}}
                            {{--                                                </div>--}}
                            {{--                                            @endforeach--}}
                            {{--                                        </div>--}}
                            {{--                                        <!-- Add Pagination -->--}}
                            {{--                                        <div class="swiper-pagination"></div>--}}
                            {{--                                        <!-- Add Navigation -->--}}
                            {{--                                        <div class="swiper-button-next"></div>--}}
                            {{--                                        <div class="swiper-button-prev"></div>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                            </td>--}}

                            {{--                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">--}}
                            {{--                                <div class="text-left">--}}
                            {{--                                    @foreach($order->report_videos as $video)--}}
                            {{--                                        <video width="320" height="240" controls>--}}
                            {{--                                            <source src="{{$video}}" type="video/mp4">--}}
                            {{--                                            <source src="{{$video}}" type="video/ogg">--}}
                            {{--                                            Your browser does not support the video tag.--}}
                            {{--                                        </video>--}}
                            {{--                                    @endforeach--}}
                            {{--                                </div>--}}
                            {{--                            </td>--}}
                            {{--                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">--}}
                            {{--                                <div class="text-left"> {{$order->report_description}}</div>--}}
                            {{--                            </td>--}}


                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex space-x-1 items-center">
                                    {{--                                <div class="space-x-1">--}}
                                    {{--                                    <button class="text-slate-400 hover:text-slate-500 rounded-full"--}}
                                    {{--                                            wire:click="orderDetail({{ $order->id }})">--}}
                                    {{--                                        <span class="sr-only">View</span>--}}
                                    {{--                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id"--}}
                                    {{--                                             width="27" height="27" viewBox="0 0 24 24" stroke-width="1.5"--}}
                                    {{--                                             stroke="#2c3e50" fill="none" stroke-linecap="round"--}}
                                    {{--                                             stroke-linejoin="round">--}}
                                    {{--                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>--}}
                                    {{--                                            <path--}}
                                    {{--                                                d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z"/>--}}
                                    {{--                                            <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/>--}}
                                    {{--                                            <path d="M15 8l2 0"/>--}}
                                    {{--                                            <path d="M15 12l2 0"/>--}}
                                    {{--                                            <path d="M7 16l10 0"/>--}}
                                    {{--                                        </svg>--}}
                                    {{--                                    </button>--}}
                                    {{--                                </div>--}}
                                    @if($order->is_reported == 1 && $order->is_admin_approved == 0)
                                        <div
                                            x-data="{ deleteModalOpen2: @entangle('deleteModalOpen2'), collectionsCount: @entangle('collectionsCount') }">
                                            <div class="flex items-center">
                                                <!-- Enable Button -->
                                                <button class="text-slate-400 hover:text-slate-500 rounded-full"
                                                        @click="deleteModalOpen2 = true">
                                                    <span class="sr-only">Enable</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="icon icon-tabler icon-tabler-check" width="27"
                                                         height="27"
                                                         viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50"
                                                         fill="none" stroke-linecap="round"
                                                         stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M5 12l5 5l10 -10"/>
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
                                            <div
                                                class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                                                x-show="deleteModalOpen2"
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
                                                aria-modal="true" x-show="deleteModalOpen2"
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
                                                    @click.outside="deleteModalOpen2 = false"
                                                    @keydown.escape.window="deleteModalOpen2 = false"
                                                    style="max-width: 640px;">
                                                    <!-- Modal header -->
                                                    <div
                                                        class="px-5 py-3 border-b border-slate-200 dark:border-slate-700">
                                                        <div class="flex justify-between items-center">
                                                            <div
                                                                class="font-semibold text-slate-800 dark:text-slate-100">
                                                                Accept
                                                            </div>
                                                            <button
                                                                class="text-slate-400 dark:text-slate-500 hover:text-slate-500 dark:hover:text-slate-400"
                                                                @click="deleteModalOpen2 = false">
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
                                                                Are you sure you want to accept this report?
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Modal footer -->
                                                    <div
                                                        class="px-5 py-4 border-t border-slate-200 dark:border-slate-700">
                                                        <div class="flex justify-end">
                                                            <button
                                                                class="btn-sm bg-gray-500 hover:bg-gray-700 text-white mr-2"
                                                                @click="deleteModalOpen2 = false">
                                                                Cancel
                                                            </button>
                                                            <button
                                                                class="btn-sm bg-indigo-600 hover:bg-indigo-700 text-white"
                                                                wire:click="accept({{ $order->id }})"
                                                                wire:loading.attr="disabled">
                                                                <span wire:loading.remove>Accept</span>
                                                                <span wire:loading>Please wait...</span>
                                                            </button>
                                                            <template x-if="collectionsCount > 0">
                                                                <button
                                                                    class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white"
                                                                    @click="deleteModalOpen2 = false">OK
                                                                </button>
                                                            </template>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            x-data="{ deleteModalOpen2: @entangle('deleteModalOpen2'), collectionsCount: @entangle('collectionsCount') }">
                                            <div class="flex items-center">
                                                <!-- Enable Button -->
                                                <button class="text-slate-400 hover:text-slate-500 rounded-full"
                                                        @click="deleteModalOpen2 = true">
                                                    <span class="sr-only">disable</span>
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

                                                <!-- Eye Button -->
                                                <button class="text-slate-400 hover:text-slate-500 rounded-full ml-2"
                                                        @click="/* Add your logic here */">
                                                    <span class="sr-only">View</span>
                                                    <!-- Your eye icon here -->
                                                </button>
                                            </div>

                                            <!-- Modal overlay -->
                                            <div
                                                class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                                                x-show="deleteModalOpen2"
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
                                                aria-modal="true" x-show="deleteModalOpen2"
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
                                                    @click.outside="deleteModalOpen2 = false"
                                                    @keydown.escape.window="deleteModalOpen2 = false"
                                                    style="max-width: 640px;">
                                                    <!-- Modal header -->
                                                    <div
                                                        class="px-5 py-3 border-b border-slate-200 dark:border-slate-700">
                                                        <div class="flex justify-between items-center">
                                                            <div
                                                                class="font-semibold text-slate-800 dark:text-slate-100">
                                                                Reject
                                                            </div>
                                                            <button
                                                                class="text-slate-400 dark:text-slate-500 hover:text-slate-500 dark:hover:text-slate-400"
                                                                @click="deleteModalOpen2 = false">
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
                                                                Are you sure you want to reject this report?
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Modal footer -->
                                                    <div
                                                        class="px-5 py-4 border-t border-slate-200 dark:border-slate-700">
                                                        <div class="flex justify-end">
                                                            <button
                                                                class="btn-sm bg-gray-500 hover:bg-gray-700 text-white mr-2"
                                                                @click="deleteModalOpen2 = false">
                                                                Cancel


                                                            </button>
                                                            <button
                                                                class="btn-sm bg-indigo-600 hover:bg-indigo-700 text-white"
                                                                wire:click="reject({{ $order->id }})">
                                                                Reject
                                                            </button>
                                                            <template x-if="collectionsCount > 0">
                                                                <button
                                                                    class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white"
                                                                    @click="deleteModalOpen2 = false">OK
                                                                </button>
                                                            </template>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div
                                        x-data="{ deleteModalOpen2: @entangle('deleteModalOpen2'), collectionsCount: @entangle('collectionsCount') }">
                                        <div class="flex items-center">
                                            <!-- Enable Button -->
                                            <button class="text-slate-400 hover:text-slate-500 rounded-full"
                                                    @click="deleteModalOpen2 = true">
                                                <span class="sr-only">Enable</span>
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

                                            <!-- Eye Button -->
                                            <button class="text-slate-400 hover:text-slate-500 rounded-full ml-2"
                                                    @click="/* Add your logic here */">
                                                <span class="sr-only">View</span>
                                                <!-- Your eye icon here -->
                                            </button>
                                        </div>

                                        <!-- Modal overlay -->
                                        <div
                                            class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                                            x-show="deleteModalOpen2"
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
                                            aria-modal="true" x-show="deleteModalOpen2"
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
                                                @click.outside="deleteModalOpen2 = false"
                                                @keydown.escape.window="deleteModalOpen2 = false"
                                                style="max-width: 640px;">
                                                <!-- Modal header -->
                                                <div
                                                    class="px-5 py-3 border-b border-slate-200 dark:border-slate-700">
                                                    <div class="flex justify-between items-center">
                                                        <div
                                                            class="font-semibold text-slate-800 dark:text-slate-100">
                                                            Report Details
                                                        </div>
                                                        <button
                                                            class="text-slate-400 dark:text-slate-500 hover:text-slate-500 dark:hover:text-slate-400"
                                                            @click="deleteModalOpen2 = false">
                                                            <div class="sr-only">Close</div>
                                                            <svg class="w-4 h-4 fill-current">
                                                                <path
                                                                    d="M7.95 6.536L12.192 2.293a1 1 0 111.414 1.414L9.364 7.95l4.243 4.243a1 1 0 11-1.414 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- Modal content -->
                                                <div class="px-8 py-7">
                                                    <div class="text-sm">
                                                        <div
                                                            class="font-medium text-slate-800 dark:text-slate-100 mb-3">
                                                            Report Images
                                                        </div>
                                                    </div>
                                                    <div class="container mx-auto px-4 py-8">
                                                        <div class="flex flex-wrap -mx-4">

                                                            <div class="w-full md:w-1/2 px-4 mb-4">
                                                                <div class="swiper-container gallery-slider mt-4">
                                                                    <h4 class="text-xl font-semibold mb-2">Gallery
                                                                        Images</h4>
                                                                    <div class="swiper-wrapper" style="height: 400px;">
                                                                        @foreach($order->report_images as $image)
                                                                            <div class="swiper-slide mr-2">
                                                                                <img src="{{ $image }}"
                                                                                     alt="Gallery Image"
                                                                                     class="w-3/4 h-auto object-cover rounded-lg shadow-lg">
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                    <!-- Add pagination and navigation controls if needed -->
                                                                    {{--                <div class="slider-pagination"></div>--}}
                                                                    {{--                <div class="slider-button-next"></div>--}}
                                                                    {{--                <div class="slider-button-prev"></div>--}}
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="text-sm mt-2">
                                                        <div
                                                            class="font-medium text-slate-800 dark:text-slate-100 mb-3">
                                                            Report Videos
                                                        </div>
                                                    </div>

                                                    <div class="container mx-auto px-4 py-8">
                                                        <div class="flex flex-wrap -mx-4">
                                                            <div class="w-full md:w-1/2 px-4 mb-4">
                                                                <div class="relative">
                                                                    @foreach($order->report_videos as $video)

                                                                        <video id="productVideo" controls width="100%"
                                                                               height="auto"
                                                                               class="rounded-lg shadow-lg">
                                                                            <source src="{{ $video }}" type="video/mp4">
                                                                            Your browser does not support the video tag.
                                                                        </video>
                                                                        <div id="playButtonContainer"
                                                                             class="absolute inset-0 flex items-center justify-center">
                                                                            <button id="playButton"
                                                                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                                                                Play Video
                                                                            </button>
                                                                        </div>
                                                                </div>

                                                                @endforeach

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="text-sm mt-2">
                                                        <div
                                                            class="font-medium text-slate-800 dark:text-slate-100 mb-3">
                                                            Report Description
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center ">

                                                        <p>{{$order->report_description}}</p>

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal footer -->
                                            {{--                                            <div--}}
                                            {{--                                                class="px-5 py-4 border-t border-slate-200 dark:border-slate-700">--}}
                                            {{--                                                <div class="flex justify-end">--}}
                                            {{--                                                    <button--}}
                                            {{--                                                        class="btn-sm bg-gray-500 hover:bg-gray-700 text-white mr-2"--}}
                                            {{--                                                        @click="deleteModalOpen2 = false">--}}
                                            {{--                                                        OK--}}
                                            {{--                                                    </button>--}}
                                            {{--                                                    <button--}}
                                            {{--                                                        class="btn-sm bg-indigo-600 hover:bg-indigo-700 text-white"--}}
                                            {{--                                                        wire:click="accept({{ $order->id }})">--}}
                                            {{--                                                        Accept--}}
                                            {{--                                                    </button>--}}
                                            {{--                                                    <template x-if="collectionsCount > 0">--}}
                                            {{--                                                        <button--}}
                                            {{--                                                            class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white"--}}
                                            {{--                                                            @click="deleteModalOpen2 = false">OK--}}
                                            {{--                                                        </button>--}}
                                            {{--                                                    </template>--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                        </div>
                                    </div>
                                </div>
                                {{--            </div>--}}


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
        {{--        {{ $orders->links() }}--}}
    </div>
</div>

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<script>
    $(document).ready(function () {
        window.livewire.on('alert_remove', () => {
            setTimeout(function () {
                $(".alert-success").fadeOut('fast');
            }, 3000);
            //reload page
            location.reload();
        });
    });
</script>
<script>

    var video = document.getElementById("productVideo");
    var playButton = document.getElementById("playButton");
    var playButtonContainer = document.getElementById("playButtonContainer");

    playButton.addEventListener("click", function () {
        video.play();
        playButtonContainer.style.display = "none";
    });

    video.addEventListener("pause", function () {
        playButtonContainer.style.display = "flex";
    });
    // Product Images Slider
    var productSwiper = new Swiper('.swiper-container', {
        slidesPerView: 1,
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });

</script>
