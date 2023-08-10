<?php
namespace App\Http\Livewire;
use App\Models\Role;
use App\Models\User;
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
      protected $listeners = ['openUserView' => 'openUserView'];
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
        $this->filterType = $filterSeller;
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
        $role = Role::where('name', 'Seller')->first();
        $seller =  SellerVerification::where('user_id', $id)->where('status', 'Pending')->first();
        $seller->status = "Approved";
        $seller->save();
        $user = User::where("id", $id)->first();
        $user->seller_type = $seller->seller_type;
        $user->role_id = $role->id;
        $user->is_seller = 1;
        $user->rank = "Seller";
        $user->save();
        $this->dispatchBrowserEvent(
            'alert',
            ['type' => 'success',  'message' => 'Seller Request Approved successfully.']
        );
    }

    public function rejected($id)
    {
        $role = Role::where('name', 'Seller')->first();
        $seller =  SellerVerification::where('user_id', $id)->first();
        $seller->status = "Rejected";
        $seller->save();
        $this->dispatchBrowserEvent(
            'alert',
            ['type' => 'success', 'message' => 'Seller Request Rejected successfully.']
        );
    }

    public function openUserView($id)
    {
       return redirect()->route('users', ['userId' => $id]);
    }
}
