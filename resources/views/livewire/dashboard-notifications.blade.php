<div class="relative m-6 inline-flex w-fit" x-data="{ open: false }">
    <button
        @click.prevent="open = !open"
        :aria-expanded="open">
        <div
            class="absolute bottom-auto left-auto right-0 top-0 z-10 inline-block -translate-y-1/2 translate-x-2/4 rotate-0 skew-x-0 skew-y-0 scale-x-100 scale-y-100 whitespace-nowrap rounded-full bg-indigo-700 px-2.5 py-1 text-center align-baseline text-xs font-bold leading-none text-white blink">
            {{ $count }}
        </div>
    </button>
    <div
        class="flex items-center justify-center rounded-lg bg-indigo-400  text-center text-white shadow-lg dark:text-gray-200">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            class="h-7 w-7">
            <path
                fill-rule="evenodd"
                d="M5.25 9a6.75 6.75 0 0113.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 01-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 11-7.48 0 24.585 24.585 0 01-4.831-1.244.75.75 0 01-.298-1.205A8.217 8.217 0 005.25 9.75V9zm4.502 8.9a2.25 2.25 0 104.496 0 25.057 25.057 0 01-4.496 0z"
                clip-rule="evenodd"/>
        </svg>
    </div>
    <div
        class="origin-top-right z-10 absolute top-full min-w-44 bg-white border border-slate-200 py-1.5 rounded shadow-lg overflow-hidden mt-1"
        @click.outside="open = false"
        @keydown.escape.window="open = false"
        x-show="open"
        x-transition:enter="transition ease-out duration-200 transform"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-out duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-cloak
    >
        <div class="pt-0.5 pb-2 px-3 mb-1 border-b border-slate-200 cursor-pointer">
            <div wire:click="handleSellerNotification">
                @if ($sellerNotification)
                    {{ $sellerNotification->body }} <br>
                    <hr>
                @endif
            </div>
            <div wire:click="handleLiveStreamNotification">
                @if ($liveStreamNotification)
                    {{ $liveStreamNotification->body }} <br>
                    <hr>
                @endif
            </div>
            <div wire:click="handleStandardNotification">
                @if ($standardNotification)
                    {{ $standardNotification->body }}
                    <hr>
                @endif
            </div>
            <div wire:click="handleBuyerReportNotification">
                @if ($buyerReportNotification)
                    {{ $buyerReportNotification->body }} <br>
                    <hr>
                @endif
            </div>
            <div wire:click="handleSellerReportNotification">
                @if ($sellerReportNotification)
                    {{ $sellerReportNotification->body }} <br>
                    <hr>
                @endif
            </div>
            <div wire:click="handleRefundNotification">
                @if ($refundNotification)
                    {{ $refundNotification->body }} <br>
                    <hr>
                @endif
            </div>
            <div wire:click="handleUserReportNotification">
                @if ($userReportNotification)
                    {{ $userReportNotification->body }} <br>
                    <hr>
                @endif
            </div>
        </div>


    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.5/push.js"></script>
<script>
    // Check if the browser supports notifications
    if ('Notification' in window) {
        // Request permission
        Notification.requestPermission().then(function (permission) {
            if (permission === 'granted') {
                // Show the notification
                if ({{ $count }} > 0) {
                    Push.create("Hello ZeedLive Admin!", {
                        body: "You've Some New Notifications!",
                        timeout: 7000,
                        icon: '/images/applications-image-01.jpg',
                        onClick: function () {
                            window.focus();
                            this.close();
                        }
                    });
                }
            }
        });
    }
</script>

<script>
    window.setInterval(() => {
    @this.call('refreshNotifications');
    }, 5000); // Poll every 5 seconds

    //remove .blink class when count is 0
    const blink = document.querySelector('.blink');
    if ({{ $count }} == 0) {
        blink.classList.remove('blink');
    }
</script>
<style>


    @keyframes blink {
        0% {
            opacity: 1;
        }
        50% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }

    .blink {
        animation: blink 1s infinite;
    }
</style>
