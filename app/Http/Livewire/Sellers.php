<?php
namespace App\Http\Livewire;
use Livewire\Component;
use App\Helpers\baseUrl;
use App\Helpers\MakeCurlRequest;
use App\Models\SellerVerification;
use App\Helpers\makeCurlPostRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class Sellers extends Component
{
    public $filterSeller = null;
    public $filterType = '';
    public function render()
    {
        if ($this->filterSeller != null) {
            $sellers = $this->filterSeller->paginate(10);
            $total_sellers = $this->filterSeller->get()->count();
            $this->filterSeller = null;
        } else {
            $sellers = SellerVerification::where('status', 'Pending')->with('User')->orderBy('seller_verifications.id', 'desc');
            $total_sellers = $sellers->get()->count();
            $sellers = $sellers->paginate(10);
        }


        return view('livewire.sellers', compact('sellers', 'total_sellers'));
    }

    public function filterSeller($filterSeller)
    {
        if ($filterSeller == 'verified') {
            $list = SellerVerification::where('status', 'Approved')->with('User');
        } elseif ($filterSeller == 'rejected') {
            $list = SellerVerification::where('status', 'Rejected')->with('User');
        } else {
            $list = SellerVerification::where('status', 'Pending')->with('User');
        }
        $this->filterSeller = $list;
    }

    public function approved($id)
    {
        $url = baseUrl().'approve/seller/request/'.$id;
        $data = makeCurlRequest($url, 'GET');
        if($data['success']==true)
        {
            $this->dispatchBrowserEvent('alert',
                    ['type' => 'success',  'message' => ''.$data['message'].'']);
        }
    }

    public function rejected($id)
    {
        $url = baseUrl().'decline/seller/request/'.$id;
        $data = makeCurlRequest($url, 'GET');
        if($data['success']==true)
        {
            $this->dispatchBrowserEvent('alert',
                    ['type' => 'success',  'message' => ''.$data['message'].'']);
        }
    }





}
