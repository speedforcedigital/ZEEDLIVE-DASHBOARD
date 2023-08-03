<div>
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($auctions as $auction)
                <tr>
                    <td>{{ $auction->id }}</td>
                    <div class="font-medium text-slate-800">{{$auction->collection_title}}</div>
                    <td>{{ $auction->admin_status }}</td>
                    <td>
                        @if ($auction->status !== 'approved')
                            <button wire:click="approved({{ $auction->id }}, {{ $auction->collection_id }})" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Approve
                            </button>
                        @endif
                        @if ($auction->status !== 'rejected')
                            <button wire:click="rejected({{ $auction->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Reject
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $auctions->links() }}

    <script>
        window.addEventListener('alert', event => { 
            alert(event.detail.message); 
        })
    </script>
</div>
