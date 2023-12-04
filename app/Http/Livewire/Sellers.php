<?php

namespace App\Http\Livewire;

use App\Events\BidEvent;
use App\Events\SellerStatusChanged;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Livewire\Component;
use App\Helpers\baseUrl;
use App\Helpers\MakeCurlRequest;
use App\Models\SellerVerification;
use App\Helpers\makeCurlPostRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class Sellers extends Component
{
    public $filterSeller = null;
    public $filterType = 'all';
    public $search = '';
    public $reason = '';
    protected $listeners = ['openUserView' => 'openUserView'];
    protected $rules = [
        'reason' => 'required',
    ];

    public function render()
    {
        if ($this->filterSeller != null) {
//            dd($this->filterSeller);
            $sellers = $this->filterSeller->paginate(10);
            $total_sellers = $this->filterSeller->get()->count();
            $this->filterSeller = null;
        } else {
            $sellers = SellerVerification::with('User')->orderBy('seller_verifications.id', 'desc');
            $total_sellers = $sellers->get()->count();
            $sellers = $sellers->paginate(10);
//            dd($sellers);

            $this->filterSeller = null;
        }

        if (!empty($this->search)) {
            $sellers = SellerVerification::whereHas('User', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })->paginate(10);
            $total_sellers = $sellers->total();
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
        } elseif ($filterSeller == 'pending') {
            $list = SellerVerification::where('status', 'Pending')->with('User');
        } elseif ($filterSeller == 'all') {
            $list = SellerVerification::with('User');
        }
        $this->filterSeller = $list;
    }

    public function approved($id)
    {
        $role = Role::where('name', 'Seller')->first();
        $seller = SellerVerification::where('id', $id)->first();
        $seller->status = "Approved";
        $seller->save();
        $user = User::where("id", $seller->user_id)->first();
        $user->seller_type = $seller->seller_type;
        $user->role_id = $role->id;
        $user->is_seller = 1;
        $user->rank = "Seller";
        $user->save();
        $message = 'Seller Accepted Successfully.';
//        event(new SellerStatusChanged($seller->id, 'Approved'));

        if ($user->device_token) {
            $title = 'Seller Verification';
            $body = array(
                'notification_body' => 'Your seller request has been approved.',
                'type' => 'seller',
                'id' => $user->id,
            );
            $input = $this->sendNotification($user->device_token, $title, $body);
        }
        return redirect()->route('sellers.index')->with('message', $message);
    }

    public function rejected($id)
    {
        $this->validate();

        $role = Role::where('name', 'Seller')->first();
        $seller = SellerVerification::where('id', $id)->first();
        $sellerDetails = User::where("id", $seller->user_id)->first();
        $params = array(
            'to' => $sellerDetails->email,
            'from' => env("MAIL_FROM_ADDRESS"),
            'fromname' => "Zeedlive",
            'subject' => "Seller Request Rejected",
            'text' => "Dear Mr/Ms. " . $sellerDetails->name . " Your seller request has been rejected due to the following reason: " . $this->reason,
        );
        $this->sendMail($params);
        $seller->status = "Rejected";
        $seller->save();
        $message = 'Seller Rejected Successfully.';
        event(new SellerStatusChanged($seller->id, 'Rejected'));
        return redirect()->route('sellers.index')->with('message', $message);

//        $this->dispatchBrowserEvent(
//            'alert',
//            ['type' => 'success', 'message' => 'Seller Request Rejected successfully.']
//        );
    }

    public function openUserView($id)
    {
        return redirect()->route('users', ['userId' => $id]);
    }

    public function sendNotification($token, $title, $body)
    {
        $messaging = app('firebase.messaging');
        $message = CloudMessage::withTarget('token', $token)
            ->withNotification(Notification::fromArray([
                'title' => $title,
                'body' => $body['notification_body'],
            ])) // Optional
            ->withData($body); // Optional

        $messaging->send($message);
    }

    public function sendMail($params)
    {
        $url = 'https://api.sendgrid.com/';
        $sendgrid_apikey = env("MAIL_PASSWORD");

        $request = $url . 'api/mail.send.json';
        // Generate curl request
        $session = curl_init($request);
        // Tell PHP not to use SSLv3 (instead opting for TLS)
        curl_setopt($session, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($session, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $sendgrid_apikey));
        // Tell curl to use HTTP POST
        curl_setopt($session, CURLOPT_POST, true);
        // Tell curl that this is the body of the POST
        curl_setopt($session, CURLOPT_POSTFIELDS, $params);
        // Tell curl not to return headers, but do return the response
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        // obtain response
        $response = curl_exec($session);
        curl_close($session);
        json_decode($response);
    }
}
