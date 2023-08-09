<?php

namespace App\Http\Livewire;

use App\Models\Offers;
use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;

class OffersList extends Component
{
    public $offer_id;

    public function render()
    {
        $perPage= 10 ;
        $offers = Offers::with(['user', 'receiver', 'collection'])->get();
        $total_offers = count($offers);
        $offers = Offers::with(['user', 'receiver', 'collection'])->paginate($perPage);

        return view('livewire.offers', compact('offers', 'total_offers'));
    }

    public function accept($id)
    {
        $offer = Offers::find($id);
        // Update the offer as accepted, assuming you have an 'accepted' column in the offers table
        $offer->is_accepted = true;
        $offer->save();

        $this->dispatchBrowserEvent('alert', [
            'type' => 'success',
            'message' => 'Offer accepted successfully.',
        ]);
    }
}
