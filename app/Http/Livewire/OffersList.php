<?php

namespace App\Http\Livewire;

use App\Models\Offers;
use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;

class OffersList extends Component
{
    public $offer_id;

    public $search = '';

//    public function render()
//    {
//        $perPage= 10 ;
//        $offers = Offers::with(['user', 'receiver', 'collection'])->get();
//        $total_offers = count($offers);
//        $offers = Offers::with(['user', 'receiver', 'collection'])->paginate($perPage);
//
//        return view('livewire.offers', compact('offers', 'total_offers'));
//    }

    public function render()
    {
        $perPage = 10;
        $query = Offers::with(['user', 'receiver', 'collection']);

        if (!empty($this->search)) {
            $query->whereHas('user', function ($userQuery) {
                $userQuery->where('name', 'like', '%' . $this->search . '%');
            })
                ->orWhereHas('receiver', function ($receiverQuery) {
                    $receiverQuery->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('collection', function ($collectionQuery) {
                    $collectionQuery->where('title', 'like', '%' . $this->search . '%');
                });

        }

        $offers = $query->where('is_accepted', 1)->paginate($perPage);
        $total_offers = $query->count(); // Count without pagination

        return view('livewire.offers', compact('offers', 'total_offers'));
    }


    public function accept($id)
    {
        $offer = Offers::find($id);
        // Update the offer as accepted, assuming you have an 'accepted' column in the offers table
        $offer->is_accepted = true;
        $offer->modrator_status = 'Accepted';
        $offer->save();
        $message = 'Offer Accepted Sucessfully.';
        return redirect()->route('offers')->with('message', $message);
//        session()->flash('message', $message);


    }

    public function reject($id)
    {
        $offer = Offers::find($id);
        // Update the offer as accepted, assuming you have an 'accepted' column in the offers table
        $offer->delete();
//        $offer->is_accepted = false;
//        $offer->modrator_status = 'Rejected';
//        $offer->save();
        $message = 'Offer Rejected Successfully.';
        return redirect()->route('offers')->with('message', $message);

//        session()->flash('message', $message);
    }



}
