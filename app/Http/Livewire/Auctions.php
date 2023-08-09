<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Auctions extends Component
{
    public $filterType = '';
    public $modalStates = [];
    public $deleteModalOpen = false;

    public function render()
    {
        $perPage = 10;

        // If filters are applied, adjust the query accordingly
        if ($this->filterType === 'verified') {
            $auctions = DB::table('auction')
                            ->join('my_collections', 'auction.collection_id', '=', 'my_collections.id')
                            ->select('auction.*', 'my_collections.title as collection_title')
                            ->where('status', 'verified')
                            ->paginate($perPage);
        } elseif ($this->filterType === 'rejected') {
            $auctions = DB::table('auction')
                            ->join('my_collections', 'auction.collection_id', '=', 'my_collections.id')
                            ->select('auction.*', 'my_collections.title as collection_title')
                            ->where('status', 'rejected')
                            ->paginate($perPage);
        } elseif ($this->filterType === 'pending') {
            $auctions = DB::table('auction')
                            ->join('my_collections', 'auction.collection_id', '=', 'my_collections.id')
                            ->select('auction.*', 'my_collections.title as collection_title')
                            ->where('status', 'pending')
                            ->paginate($perPage);
        } else {
            // Fetch all auctions without applying filters if no filter is selected
            $auctions = DB::table('auction')
                            ->join('my_collections', 'auction.collection_id', '=', 'my_collections.id')
                            ->select('auction.*', 'my_collections.title as collection_title')
                            ->paginate($perPage);
        }
        $total_auctions = $auctions->total();
          foreach ($auctions as $item) {
            $this->modalStates[$item->id] = false;
        }
        $modalStates = $this->modalStates;
        return view('livewire.auctions', compact('auctions', 'total_auctions','modalStates'));
    }


    public function filterAuction($filterAuction)
    {
        $this->filterType = $filterAuction;
    }

    public function approved($id)
    {
        $this->showModal = true;
        // Update the status of the collection and auction
        // DB::table('auction')->where('id', $id)->update(['admin_status' => 'Approved']);

        // $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Auction approved.']);
    }

    public function rejected($id)
    {
        // Update the status of the auction
        DB::table('auction')->where('id', $id)->update(['admin_status' => 'Rejected']);

        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Auction rejected.']);
    }
}
