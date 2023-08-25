<?php
$array = Session::get('permissions');

$add_capability_exists = false;
$permissionsArray = json_decode($array, true);
foreach ($permissionsArray as $item) {
    if (isset($item['Custom Field']) && in_array('add', $item['Custom Field'])) {
        $add_capability_exists = true;
        break;
    }
}
// List capability
$list_capability_exists = false;
foreach ($permissionsArray as $item) {
    if (isset($item['Custom Field']) && in_array('list', $item['Custom Field'])) {
        $list_capability_exists = true;
        break;
    }
}
// edit
$edit_capability_exists = false;
foreach ($permissionsArray as $item) {
    if (isset($item['Custom Field']) && in_array('edit', $item['Custom Field'])) {
        $edit_capability_exists = true;
        break;
    }
}
$delete_capability_exists = false;
foreach ($permissionsArray as $item) {
    if (isset($item['Custom Field']) && in_array('delete', $item['Custom Field'])) {
        $delete_capability_exists = true;
        break;
    }
}
?>
<x-loading-indicater />
<div class="bg-white shadow-lg rounded-sm border border-slate-200">
    <header class="px-5 py-4">
        <h2 class="font-semibold text-slate-800">Sellers <span class="text-slate-400 font-medium">{{ $count }}</span></h2>
    </header>

    <div x-data="handleSelect">

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <!-- Table header -->
                <thead class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                    <tr>
                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Sr No</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Title</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Category</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Type</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Values</div>
                        </th>



                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Action</div>
                        </th>

                    </tr>
                </thead>
                <!-- Table body -->
                <tbody class="text-sm divide-y divide-slate-200">
                    <!-- Row -->
                    <?php $i=0; ?>
                    @foreach($customfields as $customfield)
                    <?php $i++;?>
                        <tr>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left">{{$i}}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                    <div class="font-medium text-slate-800"><a href="#">{{ $customfield['custom_field_title'] }}</a></div>
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left">{{ $customfield['category'] }}</div>
                            </td>

                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left">{{ $customfield['type'] }}</div>
                            </td>

                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                            <div class="text-left">{{ !empty($customfield['values']) ? implode(",", (array)$customfield['values']) : 'Textual' }}</div>
                            </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        @if($edit_capability_exists)
                           <button wire:click="edit({{$customfield['custom_field_id']}})" class="btn border-slate-200 hover:border-slate-300">
                                <svg class="w-4 h-4 fill-current text-slate-500 shrink-0" viewBox="0 0 16 16">
                                    <path d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z"></path>
                                </svg>
                            </button>
                            @endif

                           @if($delete_capability_exists)
                            <button wire:click="delete({{ $customfield['custom_field_id'] }})" class="btn border-slate-200 hover:border-slate-300">
                                <svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16">
                                    <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z"></path>
                                </svg>
                            </button>
                            @endif
                     </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
<script>
    // A basic demo function to handle "select all" functionality
    document.addEventListener('alpine:init', () => {
        Alpine.data('handleSelect', () => ({
            selectall: false,
            selectAction() {
                countEl = document.querySelector('.table-items-action');
                if (!countEl) return;
                checkboxes = document.querySelectorAll('input.table-item:checked');
                document.querySelector('.table-items-count').innerHTML = checkboxes.length;
                if (checkboxes.length > 0) {
                    countEl.classList.remove('hidden');
                } else {
                    countEl.classList.add('hidden');
                }
            },
            toggleAll() {
                this.selectall = !this.selectall;
                checkboxes = document.querySelectorAll('input.table-item');
                [...checkboxes].map((el) => {
                    el.checked = this.selectall;
                });
                this.selectAction();
            },
            uncheckParent() {
                this.selectall = false;
                document.getElementById('parent-checkbox').checked = false;
                this.selectAction();
            }
        }))
    })
</script>
