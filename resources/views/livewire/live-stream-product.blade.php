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
                                            {{--                                            <button class="text-slate-400 hover:text-slate-500 rounded-full"--}}
                                            {{--                                                    wire:click="view({{ $product->id }})">--}}
                                            {{--                                                <span class="sr-only">View</span>--}}
                                            {{--                                                <svg xmlns="http://www.w3.org/2000/svg"--}}
                                            {{--                                                     class="icon icon-tabler icon-tabler-device-tv" width="27"--}}
                                            {{--                                                     height="27" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50"--}}
                                            {{--                                                     fill="none" stroke-linecap="round" stroke-linejoin="round">--}}
                                            {{--                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>--}}
                                            {{--                                                    <path--}}
                                            {{--                                                        d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"/>--}}
                                            {{--                                                    <path d="M16 3l-4 4l-4 -4"/>--}}
                                            {{--                                                </svg>--}}
                                            {{--                                            </button>--}}
                                            <div x-data="window.modalController()">
                                                <!-- Your button code -->
                                                <div class="flex items-center">
                                                    <!-- Enable Button -->
                                                    <button class="text-slate-400 hover:text-slate-500 rounded-full"
                                                            wire:click="view({{ $product->id }})">
                                                        <span class="sr-only">View</span>
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                             class="icon icon-tabler icon-tabler-device-tv"
                                                             width="27" height="27" viewBox="0 0 24 24"
                                                             stroke-width="1.5"
                                                             stroke="#2c3e50" fill="none" stroke-linecap="round"
                                                             stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                                            <path
                                                                d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                                        </svg>
                                                    </button>

                                                    <!-- Eye Button -->
                                                    <button
                                                        class="text-slate-400 hover:text-slate-500 rounded-full ml-2"
                                                        @click="getVideo('{{ $product->id }}')">
                                                        <span class="sr-only">View</span>
                                                        <!-- Your eye icon here -->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                             class="icon icon-tabler icon-tabler-device-tv" width="27"
                                                             height="27" viewBox="0 0 24 24" stroke-width="1.5"
                                                             stroke="#2c3e50"
                                                             fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <path
                                                                d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"/>
                                                            <path d="M16 3l-4 4l-4 -4"/>
                                                        </svg>
                                                    </button>
                                                </div>

                                                <!-- Your existing modal overlay and dialog -->
                                                <div
                                                    class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                                                    x-show="rejectModalOpen"
                                                    x-transition:enter="transition ease-out duration-200"
                                                    x-transition:enter-start="opacity-0"
                                                    x-transition:enter-end="opacity-100"
                                                    x-transition:leave="transition ease-out duration-100"
                                                    x-transition:leave-start="opacity-100"
                                                    x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak></div>

                                                <div
                                                    class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6"
                                                    role="dialog"
                                                    aria-modal="true" x-show="rejectModalOpen"
                                                    x-transition:enter="transition ease-in-out duration-200"
                                                    x-transition:enter-start="opacity-0 translate-y-4"
                                                    x-transition:enter-end="opacity-100 translate-y-0"
                                                    x-transition:leave="transition ease-in-out duration-200"
                                                    x-transition:leave-start="opacity-100 translate-y-0"
                                                    x-transition:leave-end="opacity-0 translate-y-4" aria-hidden="true"
                                                    x-cloak>
                                                    <!-- Rest of your modal content -->
                                                    <div
                                                        class="bg-white dark:bg-slate-800 rounded shadow-lg overflow-auto max-w-lg w-full max-h-full"
                                                        @click.outside="rejectModalOpen = false"
                                                        @keydown.escape.window="rejectModalOpen = false"
                                                        style="max-width: 900px;">
                                                        <!-- Modal header -->
                                                        <div
                                                            class="px-5 py-3 border-b border-slate-200 dark:border-slate-700">
                                                            <div class="flex justify-between items-center">
                                                                <div
                                                                    class="font-semibold text-slate-800 dark:text-slate-100">
                                                                    Live Stream
                                                                </div>

                                                                <!-- end livestream button -->
                                                                {{--                                                                <button--}}
                                                                {{--                                                                    class="bg-red-500 text-white hover:bg-red-600 px-4 py-2 rounded-md"--}}
                                                                {{--                                                                   onclick="window.location.href = '/end/livestream/{{ $product->id }}'">--}}
                                                                {{--                                                                    End Stream--}}
                                                                {{--                                                                </button>--}}

                                                                <button
                                                                    class="bg-red-500 text-white hover:bg-red-600 px-4 py-2 rounded-md"
                                                                    onclick="endLivestream({{ $product->id }})">
                                                                    End Stream
                                                                </button>

                                                                <button
                                                                    class="text-slate-400 dark:text-slate-500 hover:text-slate-500 dark:hover:text-slate-400"
                                                                    @click="handleCloseClick">
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
                                                            <div id="app">


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        @elseif ($product->auction->auction_status == "Closed")
                                            <button class="text-slate-400 hover:text-slate-500 rounded-full"
                                                    wire:click="view({{ $product->id }})">
                                                <span class="sr-only">View</span>
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="icon icon-tabler icon-tabler-device-tv"
                                                     width="27" height="27" viewBox="0 0 24 24" stroke-width="1.5"
                                                     stroke="#2c3e50" fill="none" stroke-linecap="round"
                                                     stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                                    <path
                                                        d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                                </svg>
                                            </button>

                                        @endif


                                        {{--                                                <button class="text-slate-400 hover:text-slate-500 rounded-full"--}}
                                        {{--                                                        wire:click="liveStream({{ $product->id }})">--}}
                                        {{--                                                    <span class="sr-only">View</span>--}}
                                        {{--                                                    <svg xmlns="http://www.w3.org/2000/svg"--}}
                                        {{--                                                         class="icon icon-tabler icon-tabler-device-tv"--}}
                                        {{--                                                         width="27" height="27" viewBox="0 0 24 24" stroke-width="1.5"--}}
                                        {{--                                                         stroke="#2c3e50" fill="none" stroke-linecap="round"--}}
                                        {{--                                                         stroke-linejoin="round">--}}
                                        {{--                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>--}}
                                        {{--                                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>--}}
                                        {{--                                                        <path--}}
                                        {{--                                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>--}}
                                        {{--                                                    </svg>--}}
                                        {{--                                                </button>--}}
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


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="{{asset('/js/ZegoExpressWebRTC-3.0.0.js')}}"></script>
<script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt/zego-uikit-prebuilt.js"></script>

{{--<script>--}}
{{--    function getVideo(productId) {--}}
{{--        $.ajax({--}}
{{--            url: '/zego/' + productId,--}}
{{--            type: 'GET',--}}
{{--            contentType: 'application/json',--}}
{{--            success: function (data) {--}}
{{--                const appID = data.appID;--}}
{{--                const server = "wss://webliveroom1553886775-api.coolzcloud.com/ws";--}}
{{--                const zg = new ZegoExpressEngine(appID, server);--}}

{{--                async function loginRoom() {--}}
{{--                    const roomID = data.roomID;--}}
{{--                    const token = data.token;--}}
{{--                    const userID = data.userID;--}}
{{--                    const userName = 'co-host';--}}
{{--                    const result = await zg.loginRoom(roomID, token, { userID, userName }, { userUpdate: true });--}}

{{--                    // Set up the container for Zego UI Toolkit--}}
{{--                    const container = document.getElementById('zego-container');--}}
{{--                    const streamID = roomID + '_' + '200' + '_main';--}}

{{--                    // Render remote video using ZegoExpressEngine directly--}}
{{--                    zg.startPlayingStream(streamID, container);--}}

{{--                    // Show participants, comments, etc. using Zego UI Toolkit components--}}
{{--                    const zp = new ZegoUIKitPrebuilt();--}}
{{--                    zp.showUserList();--}}
{{--                    zp.showChatView();--}}
{{--                }--}}

{{--                loginRoom();--}}
{{--            },--}}
{{--            error: function (error) {--}}
{{--                console.error('Ajax error:', error);--}}
{{--            }--}}
{{--        });--}}
{{--    }--}}
{{--</script>--}}


<script>


    window.modalController = function () {
        return {
            zegoInstance: null, // Initialize Zego instance variable
            rejectModalOpen: false, // Initialize modal state

            handleCloseClick() {
                if (this.zegoInstance) {
                    // Leave Zego room and destroy the instance

                    this.zegoInstance.destroy();
                    this.zegoInstance = null;
                    // Close the modal
                    this.rejectModalOpen = false;

                } else {
                    // Close the modal if Zego instance doesn't exist
                    this.rejectModalOpen = false;
                }
            },

            getVideo(productId) {
                $.ajax({
                    url: '/zego/' + productId,
                    type: 'GET',
                    contentType: 'application/json',
                    success: (data) => {
                        const appID = data.appID;
                        const server = "wss://webliveroom1553886775-api.coolzcloud.com/ws";
                        const zg = new ZegoExpressEngine(appID, server);

                        const roomID = data.roomID;
                        // const roomID = '1367';
                        const token = data.token;
                        const userID = data.userID;
                        const userName = data.userName;
                        const streamID = roomID + '_' + '200' + '_main';

                        const KitToken = ZegoUIKitPrebuilt.generateKitTokenForProduction(
                            1553886775,
                            token,
                            roomID,
                            userID,
                            userName
                        );

                        const zp = ZegoUIKitPrebuilt.create(KitToken);
                        const appDiv = document.getElementById('app');

                        let role = 'Host';

                        zp.joinRoom({
                            container: appDiv,
                            branding: {
                                logoURL: 'https://www.zegocloud.com/_nuxt/img/zegocloud_logo_white.ddbab9f.png',
                            },
                            scenario: {
                                mode: ZegoUIKitPrebuilt.LiveStreaming,
                                config: {
                                    role,
                                    roomID,
                                },
                            },
                            onLeaveRoom: () => {
                                // do something if needed
                            },
                            showUserList: true,
                            turnOnCameraWhenJoining: false,
                            turnOnMicrophoneWhenJoining: false,
                        });

                        this.zegoInstance = zp; // Store the Zego instance
                        // Open the modal
                        this.rejectModalOpen = true;
                    },
                    error: (error) => {
                        console.error('Ajax error:', error);
                    }
                });
            }
        };
    };

    function getSignature(callback, product_id) {
        $.ajax({
            url: '/get/signature/' + product_id,
            type: 'GET',
            contentType: 'application/json',
            success: function (data) {
                // console.log('data',data);
                callback(data.signatureNonce, data.signature);
            },
            error: function (error) {
                console.error('Ajax error:', error);
                callback(null, null, null);
            }
        });
    }


    function endLivestream(product_id) {
        let apiUrl = 'https://rtc-api.zego.im/';
        let timestamp = Math.floor(Date.now() / 1000);
        let time = timestamp.toString();

        getSignature(function (signatureNonce, signature) {
            if (signatureNonce !== null) {
                let requestData = {
                    Action: 'CloseRoom',
                    RoomId: product_id.toString(),
                    AppId: '1553886775',
                    SignatureVersion: '2.0',
                    Timestamp: time,
                    SignatureNonce: signatureNonce,
                    Signature: signature
                };

                console.log('requestData', requestData);

                $.ajax({
                    url: apiUrl,
                    type: 'GET',
                    data: requestData,
                    success: function (data) {
                        // console.log(data);
                    },
                    error: function (error) {
                        console.error('Error:', error);
                    }
                });
            } else {
                console.error('Unable to get signature nonce.');
            }
        }, product_id);
    }
</script>

{{--<script>--}}
{{--    let zegoInstance = null;--}}

{{--    function handleCloseClick() {--}}
{{--        if (zegoInstance) {--}}
{{--            zegoInstance.destroy();--}}
{{--            zegoInstance = null;--}}
{{--        }--}}
{{--       window.livewire.emitTo('rejectModalOpen', false);--}}
{{--    }--}}

{{--    function getVideo(productId) {--}}
{{--        $.ajax({--}}
{{--            url: '/zego/' + productId,--}}
{{--            type: 'GET',--}}
{{--            contentType: 'application/json',--}}
{{--            success: function (data) {--}}
{{--                const appID = data.appID;--}}
{{--                const server = "wss://webliveroom1553886775-api.coolzcloud.com/ws";--}}
{{--                const zg = new ZegoExpressEngine(appID, server);--}}

{{--                async function loginRoom() {--}}
{{--                    const roomID = data.roomID;--}}
{{--                    const token = data.token;--}}
{{--                    const userID = data.userID;--}}
{{--                    const userName = 'co-host';--}}
{{--                    const streamID = roomID + '_' + '200' + '_main';--}}

{{--                    const KitToken = ZegoUIKitPrebuilt.generateKitTokenForProduction(--}}
{{--                        1553886775,--}}
{{--                        token,--}}
{{--                        roomID,--}}
{{--                        userID,--}}
{{--                        userName--}}
{{--                    );--}}

{{--                    const zp = ZegoUIKitPrebuilt.create(KitToken);--}}
{{--                    const appDiv = document.getElementById('app');--}}

{{--                    let role = 'Host';--}}

{{--                    zp.joinRoom({--}}
{{--                        container: appDiv,--}}
{{--                        branding: {--}}
{{--                            logoURL:--}}
{{--                                'https://www.zegocloud.com/_nuxt/img/zegocloud_logo_white.ddbab9f.png',--}}
{{--                        },--}}
{{--                        scenario: {--}}
{{--                            mode: ZegoUIKitPrebuilt.LiveStreaming,--}}
{{--                            config: {--}}
{{--                                role,--}}
{{--                                roomID,--}}
{{--                                video: false,--}}
{{--                                audio: false,--}}
{{--                            },--}}
{{--                        },--}}
{{--                        onLeaveRoom: () => {--}}
{{--                            rejectModalOpen = false; // Close the modal when leaving the room--}}
{{--                        },--}}
{{--                        showUserList: true,--}}
{{--                    });--}}

{{--                    zegoInstance = zp; // Store the Zego instance--}}
{{--                }--}}

{{--                window.Alpine.store('rejectModalOpen', true); // Open the modal--}}


{{--                loginRoom();--}}
{{--            },--}}
{{--            error: function (error) {--}}
{{--                console.error('Ajax error:', error);--}}
{{--            }--}}
{{--        });--}}
{{--    }--}}
{{--</script>--}}

{{--<div id="app"></div>--}}


{{--<script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt/zego-uikit-prebuilt.js"></script>--}}
{{--    <script>--}}

{{--        const appDiv = document.getElementById('app');--}}
{{--        appDiv.innerHTML = `<h1>JS Starter</h1>`;--}}

{{--        // get token--}}
{{--        function generateToken(tokenServerUrl, userID) {--}}
{{--            // Obtain the token interface provided by the App Server--}}
{{--            return fetch(--}}
{{--                `${tokenServerUrl}/access_token?userID=${userID}&expired_ts=7200`,--}}
{{--                {--}}
{{--                    method: 'GET',--}}
{{--                }--}}
{{--            ).then((res) => res.json());--}}
{{--        }--}}

{{--        function randomID(len) {--}}
{{--            let result = '';--}}
{{--            if (result) return result;--}}
{{--            var chars = '12345qwertyuiopasdfgh67890jklmnbvcxzMNBVCZXASDQWERTYHGFUIOLKJP',--}}
{{--                maxPos = chars.length,--}}
{{--                i;--}}
{{--            len = len || 5;--}}
{{--            for (i = 0; i < len; i++) {--}}
{{--                result += chars.charAt(Math.floor(Math.random() * maxPos));--}}
{{--            }--}}
{{--            return result;--}}
{{--        }--}}

{{--        function getUrlParams(url) {--}}
{{--            let urlStr = url.split('?')[1];--}}
{{--            const urlSearchParams = new URLSearchParams(urlStr);--}}
{{--            const result = Object.fromEntries(urlSearchParams.entries());--}}
{{--            return result;--}}
{{--        }--}}

{{--        async function init() {--}}
{{--            const roomID = getUrlParams(window.location.href)['roomID'] || randomID(5);--}}
{{--            let role = getUrlParams(window.location.href)['role'] || 'Host';--}}
{{--            role =--}}
{{--                role === 'Host'--}}
{{--                    ? ZegoUIKitPrebuilt.Host--}}
{{--                    : role === 'Cohost'--}}
{{--                        ? ZegoUIKitPrebuilt.Cohost--}}
{{--                        : ZegoUIKitPrebuilt.Audience;--}}

{{--            let sharedLinks = [];--}}
{{--            if (role === ZegoUIKitPrebuilt.Host || role === ZegoUIKitPrebuilt.Cohost) {--}}
{{--                sharedLinks.push({--}}
{{--                    name: 'Join as co-host',--}}
{{--                    url:--}}
{{--                        window.location.origin +--}}
{{--                        window.location.pathname +--}}
{{--                        '?roomID=' +--}}
{{--                        roomID +--}}
{{--                        '&role=Cohost',--}}
{{--                });--}}
{{--            }--}}
{{--            sharedLinks.push({--}}
{{--                name: 'Join as audience',--}}
{{--                url:--}}
{{--                    window.location.origin +--}}
{{--                    window.location.pathname +--}}
{{--                    '?roomID=' +--}}
{{--                    roomID +--}}
{{--                    '&role=Audience',--}}
{{--            });--}}

{{--            const userID = randomID(5);--}}
{{--            const userName = randomID(5);--}}
{{--            const { token } = await generateToken(--}}
{{--                'https://nextjs-token.vercel.app/api',--}}
{{--                userID--}}
{{--            );--}}
{{--            const KitToken = ZegoUIKitPrebuilt.generateKitTokenForProduction(--}}
{{--                1484647939,--}}
{{--                token,--}}
{{--                roomID,--}}
{{--                userID,--}}
{{--                userName--}}
{{--            );--}}
{{--            const zp = ZegoUIKitPrebuilt.create(KitToken);--}}
{{--            zp.joinRoom({--}}
{{--                container: appDiv,--}}
{{--                branding: {--}}
{{--                    logoURL:--}}
{{--                        'https://www.zegocloud.com/_nuxt/img/zegocloud_logo_white.ddbab9f.png',--}}
{{--                },--}}
{{--                scenario: {--}}
{{--                    mode: ZegoUIKitPrebuilt.LiveStreaming,--}}
{{--                    config: {--}}
{{--                        role,--}}
{{--                    },--}}
{{--                },--}}
{{--                sharedLinks,--}}
{{--                onLeaveRoom: () => {--}}
{{--                    // do do something--}}
{{--                },--}}
{{--                showUserList: true,--}}
{{--            });--}}
{{--        }--}}

{{--        init();--}}
{{--    </script>--}}
