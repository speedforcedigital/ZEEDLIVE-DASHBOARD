<?php
namespace App\Http\Livewire;
use App\Helpers\MakeCurlRequest;
use App\Helpers\makeCurlPostRequest;
use App\Helpers\baseUrl;
use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;
class Auctions extends Component
{
    public $filterAuction = false;
    public $filterType = '';
    public function render()
    {
    $url = baseUrl().'list/all/auction';
    $data = makeCurlRequest($url, 'GET');
    // echo "<pre>";print_r($data);die();
    if($this->filterAuction || $this->filterType)
    {
        $auctions = $this->filterAuction;
        $total_auctions = count($auctions);
    }
    else
    {
    $auctions = $data['data'];
    $total_auctions = count($auctions);
    }
    //pagination
    $page = request()->query('page', 1);
    $perPage = 10;
    $auctions = new LengthAwarePaginator(
        array_slice($auctions, ($page - 1) * $perPage, $perPage),
        count($auctions),
        $perPage,
        $page,
        [
            'path' => request()->url(),
            'query' => request()->query()
        ]
    );
        return view('livewire.auctions', compact('auctions', 'total_auctions'));
    }

    public function filterAuction($filterAuction)
    {  
    if($filterAuction=='verified')
    {
      $filter = 'list/approved/auction';
      $filterType='verified';
    }
    elseif($filterAuction=='rejected')
    {
        $filter = 'list/rejected/auction';
        $filterType='rejected';
    }
    elseif($filterAuction=='pending')
    {
        $filter = 'list/pending/auction';
        $filterType='pending';
    }
    else
    {
        $filter = 'list/all/auction';
        $filterType='all';
    }
    $url = baseUrl().$filter;
    $data = makeCurlRequest($url, 'GET');
    $this->filterAuction = $data['data'];
    $this->filterType = $filterType;
    }
    public function approved($id,$collection_id)
    {
        $urlCollectionStatus = baseUrl().'edit/collection/status/'.$collection_id;
        makeCurlRequest($urlCollectionStatus, 'GET');
        $url = baseUrl().'approve/auction/'.$id;
        $data = makeCurlRequest($url, 'GET');
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => ''.$data['message'].'']);
    }
    public function rejected($id)
    {
        $url = baseUrl().'reject/auction/'.$id;
        $data = makeCurlRequest($url, 'GET');
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => ''.$data['message'].'']);
    }
 
}
