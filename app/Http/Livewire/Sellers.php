<?php
namespace App\Http\Livewire;
use App\Helpers\MakeCurlRequest;
use App\Helpers\makeCurlPostRequest;
use App\Helpers\baseUrl;
use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;
class Sellers extends Component
{
    // public  $brand_id, $name, $image, $category_id;
    // public $addBrand = false;
    // public $updateMode = false;
    public function render()
    {
    $url = baseUrl().'pending/seller/verification/list';
    $data = makeCurlRequest($url, 'GET');
    $sellers = $data['data'];
    $total_sellers = count($sellers);
    //pagination
    $page = request()->query('page', 1);
    $perPage = 10;
    $sellers = new LengthAwarePaginator(
        array_slice($sellers, ($page - 1) * $perPage, $perPage),
        count($sellers),
        $perPage,
        $page,
        [
            'path' => request()->url(),
            'query' => request()->query()
        ]
    );
        return view('livewire.sellers', compact('sellers', 'total_sellers'));
    }

    
    

   
}
