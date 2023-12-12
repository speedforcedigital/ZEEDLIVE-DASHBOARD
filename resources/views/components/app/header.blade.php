<header class="sticky top-0 bg-white border-b border-slate-200 z-30">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 -mb-px">

            <!-- Header: Left side -->
            <div class="flex">

                <!-- Hamburger button -->
                <button
                    class="text-slate-500 hover:text-slate-600 lg:hidden"
                    @click.stop="sidebarOpen = !sidebarOpen"
                    aria-controls="sidebar"
                    :aria-expanded="sidebarOpen"
                >
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <rect x="4" y="5" width="16" height="2"/>
                        <rect x="4" y="11" width="16" height="2"/>
                        <rect x="4" y="17" width="16" height="2"/>
                    </svg>
                </button>

            </div>

            <!-- Header: Right side -->
            <div class="flex items-center space-x-3">
                <div class="relative m-6 inline-flex w-fit" x-data="{ open: false }">
                    <button
                        @click.prevent="open = !open"
                        :aria-expanded="open">
                        <div
                            class="absolute bottom-auto left-auto right-0 top-0 z-10 inline-block -translate-y-1/2 translate-x-2/4 rotate-0 skew-x-0 skew-y-0 scale-x-100 scale-y-100 whitespace-nowrap rounded-full bg-indigo-700 px-2.5 py-1 text-center align-baseline text-xs font-bold leading-none text-white getCount">

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
                        <div class="pt-0.5 pb-2 px-3 mb-1 border-b border-slate-200 notificationDropdownContent">

                        </div>

                    </div>
                </div>
                <!-- Divider -->
                <hr class="w-px h-6 bg-slate-200"/>

                <!-- User button -->
                <x-dropdown-profile align="right"/>

            </div>

        </div>
    </div>
</header>

<script>
    $(document).ready(function () {
        $.ajax({
            url: '/get/notifications/count',
            method: 'GET',
            success: function (data) {
                const sellerNotification = data.sellerNotification;
                const liveStreamNotification = data.liveStreamNotification;
                const standardNotification = data.standardNotification;

                const notifications = [sellerNotification, liveStreamNotification, standardNotification];

                const count = notifications.reduce((acc, notification) => acc + (notification ? 1 : 0), 0);

                if (count > 0) {
                    $('.getCount').html(count);
                    $('.getCount').addClass('blink');
                }

                const notificationsHtml = notifications.map(notification => {
                    if (notification) {
                        return `
            <div class="notification-item">
                ${notification.body}
            </div>
            <hr class="my-1 border-t border-slate-200">
        `;
                    }
                }).join('');

                $('.notificationDropdownContent').html(notificationsHtml);


                // Add click event handler to each notification
                $('.notification-item').on('click', function () {
                    // const notificationId = $(this).data('notification-id');

                    window.location.href = '/sellers';

                    // Update the 'is_read' column in the database
                    $.ajax({
                        // url: '/update/seller/notification/' + notificationId,
                        url: '/update/seller/notifications',
                        method: 'GET',
                        success: function (response) {
                        }
                    });
                });

                console.log(data.details);
            }
        });
    });
</script>

<style>
    .notification-item {
        cursor: pointer;
    }

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

