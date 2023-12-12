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


                @livewire('dashboard-notifications')

                <!-- Divider -->
                <hr class="w-px h-6 bg-slate-200"/>

                <!-- User button -->
                <x-dropdown-profile align="right"/>

            </div>

        </div>
    </div>
</header>

{{--<script>--}}
{{--    $(document).ready(function () {--}}
{{--        $.ajax({--}}
{{--            url: '/get/notifications/count',--}}
{{--            method: 'GET',--}}
{{--            success: function (data) {--}}
{{--                const sellerNotification = data.sellerNotification;--}}
{{--                const liveStreamNotification = data.liveStreamNotification;--}}
{{--                const standardNotification = data.standardNotification;--}}

{{--                const notifications = [sellerNotification, liveStreamNotification, standardNotification];--}}

{{--                const count = notifications.reduce((acc, notification) => acc + (notification ? 1 : 0), 0);--}}

{{--                if (count > 0) {--}}
{{--                    $('.getCount').html(count);--}}
{{--                    $('.getCount').addClass('blink');--}}
{{--                }--}}

{{--                const notificationsHtml = notifications.map(notification => {--}}
{{--                    if (notification) {--}}
{{--                        return `--}}
{{--            <div class="notification-item">--}}
{{--                ${notification.body}--}}
{{--            </div>--}}
{{--            <hr class="my-1 border-t border-slate-200">--}}
{{--        `;--}}
{{--                    }--}}
{{--                }).join('');--}}

{{--                $('.notificationDropdownContent').html(notificationsHtml);--}}


{{--                $('.notification-item').on('click', function () {--}}

{{--                    window.location.href = '/sellers';--}}

{{--                    $.ajax({--}}
{{--                        // url: '/update/seller/notification/' + notificationId,--}}
{{--                        url: '/update/seller/notifications',--}}
{{--                        method: 'GET',--}}
{{--                        success: function (response) {--}}
{{--                        }--}}
{{--                    });--}}
{{--                });--}}

{{--                // console.log(data.details);--}}
{{--            }--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}

{{--<style>--}}
{{--    .notification-item {--}}
{{--        cursor: pointer;--}}
{{--    }--}}

{{--    @keyframes blink {--}}
{{--        0% {--}}
{{--            opacity: 1;--}}
{{--        }--}}
{{--        50% {--}}
{{--            opacity: 0;--}}
{{--        }--}}
{{--        100% {--}}
{{--            opacity: 1;--}}
{{--        }--}}
{{--    }--}}

{{--    .blink {--}}
{{--        animation: blink 1s infinite;--}}
{{--    }--}}
{{--</style>--}}

