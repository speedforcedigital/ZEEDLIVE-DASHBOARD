@php
    $permissionsArray = json_decode(Session::get('permissions'), true);
    $auctionPermissions = null;
    $verification_capability_exists = false;
    $delete_capability_exists = false;

    foreach ($permissionsArray as $item) {
        // Check if 'Auction' key exists in the current item
        if (isset($item['Auction']) && is_array($item['Auction'])) {
            $auctionPermissions = $item['Auction'];
            break; // Stop the loop once 'Auction' section is found
        }
    }

    // Now that the loop has finished, $auctionPermissions will contain the values

    if ($auctionPermissions) {
        if (in_array('verification', $auctionPermissions)) {
            $verification_capability_exists = true;
        }
        if (in_array('delete', $auctionPermissions)) {
            $delete_capability_exists = true;
        }
    }
@endphp


@props(['auctions', 'count'])

<x-loading-indicater />

<div class="bg-white shadow-lg rounded-sm border border-slate-200">
    <header class="px-5 py-4">
        <h2 class="font-semibold text-slate-800">Sellers <span class="text-slate-400 font-medium">{{ $count }}</span></h2>
    </header>

   
</div>

<script>
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
