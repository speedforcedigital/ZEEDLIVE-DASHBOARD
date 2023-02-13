<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
            @if($addNotification)
            Add Notification ✨
            @else
            Notifications ✨
            @endif
            </h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Delete button -->
                <x-actions.delete-button />
                @if(!$addNotification && !$updateMode)
                <button wire:click="add()" class="btn border-slate-200 hover:border-slate-300 bg-indigo-500 text-white">Add Notification</button>
                @endif
            </div>

        </div>

        <!-- Table -->
    @if($addNotification)
        <x-notification.add-notification />
    @elseif($updateMode)
    <x-notification.add-notification />
    @else
    <x-notification.notification-table :notification="$notification" :count="$total_notification" />
    @endif
   <!-- Pagination -->
   <div class="mt-8">
            {{$notification->links()}}
        </div>
    </div>
