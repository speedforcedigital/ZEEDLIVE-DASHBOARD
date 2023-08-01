<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Auction; // Replace "Auction" with your actual Eloquent model name

class Auctions extends Component
{
    public $filterAuction = false;
    public $filterType = '';

    public function render()
    {
        // Replace this with your actual Eloquent query to fetch all auctions from the database
        $query = Auction::query();
        
        if ($this->filterAuction || $this->filterType) {
            // If filters are applied, adjust the query accordingly
            if ($this->filterType === 'verified') {
                $query->where('status', 'verified');
            } elseif ($this->filterType === 'rejected') {
                $query->where('status', 'rejected');
            } elseif ($this->filterType === 'pending') {
                $query->where('status', 'pending');
            }
            
            $auctions = $query->get();
            $total_auctions = count($auctions);
        } else {
            // If no filters are applied, fetch all auctions
            $auctions = $query->get();
            $total_auctions = count($auctions);
        }

        // Pagination
        $page = request()->query('page', 1);
        $perPage = 10;
        $auctions = new LengthAwarePaginator(
            $auctions->forPage($page, $perPage),
            $total_auctions,
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        return view('livewire.auctions', compact('auctions', 'total_auctions'));
    }

    public function filterAuction($filterAuction)
    {  
        if ($filterAuction === 'verified') {
            $this->filterAuctionByStatus('verified');
        } elseif ($filterAuction === 'rejected') {
            $this->filterAuctionByStatus('rejected');
        } elseif ($filterAuction === 'pending') {
            $this->filterAuctionByStatus('pending');
        } else {
            $this->filterAuctionByStatus('all');
        }
    }

    private function filterAuctionByStatus($status)
    {
        // Replace this with your actual Eloquent query to filter auctions by status
        $this->filterAuction = Auction::where('status', $status)->get();
        $this->filterType = $status;
    }

    public function approved($id, $collection_id)
    {
        // Replace this with your actual Eloquent code to update the status of the auction
        $collectionStatus = Collection::find($collection_id); // Replace "Collection" with your actual Eloquent model name for collections
        $collectionStatus->status = 'approved';
        $collectionStatus->save();
        
        $auction = Auction::find($id); // Replace "Auction" with your actual Eloquent model name
        $auction->status = 'approved';
        $auction->save();

        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Auction approved.']);
    }

    public function rejected($id)
    {
        // Replace this with your actual Eloquent code to update the status of the auction
        $auction = Auction::find($id); // Replace "Auction" with your actual Eloquent model name
        $auction->status = 'rejected';
        $auction->save();

        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Auction rejected.']);
    }
}