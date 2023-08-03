<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Auctions extends Component
{
    public $filterType = '';

    public function render()
    {
        $perPage = 10;

        // If filters are applied, adjust the query accordingly
        if ($this->filterType === 'verified') {
            $auctions = DB::table('auction')->where('status', 'verified')->paginate($perPage);
        } elseif ($this->filterType === 'rejected') {
            $auctions = DB::table('auction')->where('status', 'rejected')->paginate($perPage);
        } elseif ($this->filterType === 'pending') {
            $auctions = DB::table('auction')->where('status', 'pending')->paginate($perPage);
        } else {
            // Fetch all auctions without applying filters if no filter is selected
            $auctions = DB::table('auction')->paginate($perPage);
        }

        $total_auctions = $auctions->total();

        return view('livewire.auctions', compact('auctions', 'total_auctions'));
    }

    public function filterAuction($filterAuction)
    {  
        $this->filterType = $filterAuction;
    }

    public function approved($id, $collection_id)
    {
        // Update the status of the collection and auction
        DB::table('my_collections')->where('id', $collection_id)->update(['status' => 'approved']);
        DB::table('auction')->where('id', $id)->update(['status' => 'approved']);

        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Auction approved.']);
    }

    public function rejected($id)
    {
        // Update the status of the auction
        DB::table('auction')->where('id', $id)->update(['status' => 'rejected']);

        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Auction rejected.']);
    }
}