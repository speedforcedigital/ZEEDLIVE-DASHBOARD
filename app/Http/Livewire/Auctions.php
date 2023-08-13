<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Auctions extends Component
{
    public $filterType = '';
    public $modalStates = [];
    public $deleteModalOpen = false;
    public $selectedAuctionId;
    public $selectedActionType;
    
    public function render()
    {
        $perPage = 10;
    
        // If filters are applied, adjust the query accordingly
        $query = DB::table('auction')
            ->join('my_collections', 'auction.collection_id', '=', 'my_collections.id')
            ->select('auction.*', 'my_collections.title as collection_title');
    
        if ($this->filterType === 'verified') {
            $query->where('status', 'verified');
        } elseif ($this->filterType === 'rejected') {
            $query->where('status', 'rejected');
        } elseif ($this->filterType === 'pending') {
            $query->where('status', 'pending');
        }
    
        // Order the auctions by their creation or update date (replace 'created_at' with appropriate column)
        $auctions = $query->orderByDesc('created_at') // Use 'created_at' or appropriate column name
                          ->paginate($perPage);
    
        $total_auctions = $auctions->total();
        foreach ($auctions as $item) {
            $this->modalStates[$item->id] = false;
        }
        $modalStates = $this->modalStates;
    
        return view('livewire.auctions', compact('auctions', 'total_auctions', 'modalStates'));
    }    

    public function filterAuction($filterAuction)
    {
        $this->filterType = $filterAuction;
    }

    public function approved($id)
    {
        $this->selectedAuctionId = $id;
        $this->selectedActionType = 'approve';
        $this->dispatchBrowserEvent('openModal');
    }
    
    public function rejected($id)
    {
        $this->selectedAuctionId = $id;
        $this->selectedActionType = 'reject';
        $this->dispatchBrowserEvent('openModal');
    }

    public function performAction()
{
    if ($this->selectedActionType === 'approve') {
        // Update the status of the collection and auction
        DB::table('auction')->where('id', $this->selectedAuctionId)->update(['admin_status' => 'Approved']);
    } elseif ($this->selectedActionType === 'reject') {
        // Update the status of the auction
        DB::table('auction')->where('id', $this->selectedAuctionId)->update(['admin_status' => 'Rejected']);
    }

    $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Auction action performed.']);
}
    
}
