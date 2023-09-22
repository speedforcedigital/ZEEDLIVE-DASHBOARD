<?php

namespace App\Http\Livewire;

use App\Models\Lot;
use Livewire\Component;
use App\Models\UserReport;

class Listing extends Component
{
    public $showModal = false;
    public $report;
    public function render()
    {
        $perPage = 10;
        $listings = UserReport::orderByDesc('created_at')->whereHas("lot")->paginate($perPage);;
        $total_listings = $listings->total();

        return view('livewire.listing', compact('listings', 'total_listings'));
    }

    public function view($userId)
    {
        return redirect()->route('user.show', $userId);
    }

    public function viewProducts($id)
    {
        return redirect()->route('product.show', $id);
    }


      public function delete($id)
    {
        UserReport::destroy($id);
        $message = 'Listing Blocked Sucessfully.';
        session()->flash('message', $message);
    }

     public function reportDetail($id)
    {
        $this->report = UserReport::find($id);  // Assuming you have a Report model
        $this->showModal = true;
    }


}
