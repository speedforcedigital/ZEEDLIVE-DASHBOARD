<?php
namespace App\Http\Livewire;
use App\Helpers\MakeCurlRequest;
use App\Helpers\baseUrl;
use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;
class Offers extends Component
{
    public $offer_id;
    public function render()
    {
    $url = baseUrl().'accepted/offers/list';
    $data = makeCurlRequest($url, 'GET');
    $offers = $data['data'];
    // echo "<pre>";print_r($offers);die();
    $total_offers = count($offers);
    //pagination
    $page = request()->query('page', 1);
    $perPage = 10;
    $offers = new LengthAwarePaginator(
        array_slice($offers, ($page - 1) * $perPage, $perPage),
        count($offers),
        $perPage,
        $page,
        [
            'path' => request()->url(),
            'query' => request()->query()
        ]
    );
        return view('livewire.offers', compact('offers', 'total_offers'));
    }

    public function accept($id)
    { 
    $url = baseUrl()."modrator/offer/acception/".$id;
    $data = makeCurlRequest($url, 'GET');
    if($data['success']=true)
    {
        $this->dispatchBrowserEvent('alert', 
                ['type' => 'success',  'message' => ''.$data['message'].'']);
    }
    }
     
}
