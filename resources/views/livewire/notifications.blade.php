<?php
$array = Session::get('permissions');
//add
$add_capability_exists = false;
$permissionsArray = json_decode($array, true);
foreach ($permissionsArray as $item) {
  if (isset($item['Notifications']) && in_array('add', $item['Notifications'])) {
    $add_capability_exists = true;
    break;
  }
}
//list
$list_capability_exists = false;
$permissionsArray = json_decode($array, true);
foreach ($permissionsArray as $item) {
  if (isset($item['Notifications']) && in_array('list', $item['Notifications'])) {
    $list_capability_exists = true;
    break;
  }
}
?>
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">

            Notifications ✨
            </h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Delete button -->
                <x-actions.delete-button />

            </div>

        </div>

        <!-- Table -->
    @if($addNotification)
        <x-notification.add-notification />
    @elseif($updateMode)
    <x-notification.add-notification />
    @else
    @if($list_capability_exists)
    <x-notification.notification-table :notification="$notification" :count="$total_notification" />
    @endif
    @endif
   <!-- Pagination -->
   <div class="mt-8">
            {{$notification->links()}}
        </div>
    </div>
