<?php

namespace App\Http\Livewire;

use App\Models\Auction;
use App\Models\Lot;
use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class LiveStreamProduct extends Component
{

    public $filter = 'all';
    public $selected = 'all';
    public $search = '';
    public $reason = '';
    protected $rules = [
        'reason' => 'required',
    ];

    public function render()
    {
        $perPage = 10;
        $products_all = Lot::orderByDesc('created_at')
            ->whereHas('auction', function ($query) {
                $query->where('is_scadual_live', '1');
            });
//            ->paginate($perPage);

        if (!empty($this->search)) {
            $products_all = $products_all->where('title', 'like', '%' . $this->search . '%');
        }

        $products_all = $products_all->paginate($perPage);


        $onGoingProducts = Lot::orderByDesc('created_at')
            ->whereHas('auction', function ($query) {
                $query->where('is_scadual_live', '1')->where("auction_status", 'Open');
            })
            ->paginate($perPage);
        $endedProducts = Lot::orderByDesc('created_at')
            ->whereHas('auction', function ($query) {
                $query->where('is_scadual_live', '1')->whereIn("auction_status", ['Closed']);
            })
            ->paginate($perPage);
        $scheduledProducts = Lot::orderByDesc('created_at')
            ->whereHas('auction', function ($query) {
                $query->where('is_scadual_live', '1')->where("auction_status", "New");
            })
            ->paginate($perPage);
        $sold_products = Lot::orderByDesc('created_at')
            ->whereHas('auction', function ($query) {
                $query->where('is_scadual_live', '1')->where("auction_status", "Sold");
            })
            ->paginate($perPage);

        if ($this->filter === 'all') {
            $products = $products_all;
            $total_products = $products_all->total();
        } elseif ($this->filter === 'on_going') {
            $products = $onGoingProducts;
            $total_products = $onGoingProducts->total();
        } elseif ($this->filter === 'ended') {
            $products = $endedProducts;
            $total_products = $endedProducts->total();
        } elseif ($this->filter === 'scheduled') {
            $products = $scheduledProducts;
            $total_products = $scheduledProducts->total();
        } elseif ($this->filter === 'sold') {
            $products = $sold_products;
            $total_products = $sold_products->total();
        }
        $total_products_count = $products_all->total();
        $onGoingProducts = $onGoingProducts->total();
        $scheduledProducts = $scheduledProducts->total();
        $endedProducts = $endedProducts->total();
        $sold_products = $sold_products->total();
        return view('livewire.live-stream-product', compact('total_products', 'total_products_count', 'products', 'onGoingProducts', 'scheduledProducts', 'endedProducts', 'sold_products'));
    }

    public function approve($id)
    {
        DB::table('auction')->where('id', $id)->update(['admin_status' => 'Approved']);
        $message = 'Product Approved.';
        session()->flash('message', $message);
    }

//    public function reject($id)
//    {
//        DB::table('auction')->where('id', $id)->update(['admin_status' => 'Rejected']);
//        $message = 'Product rejected.';
//        session()->flash('message', $message);
//    }
    public function reject($id)
    {

        DB::table('auction')->where('id', $id)->update(['admin_status' => 'Rejected']);
        $sellerDetails = Auction::with('user')->where('id', $id)->first();
        $params = array(
            'to' => $sellerDetails->user->email,
            'from' => env("MAIL_FROM_ADDRESS"),
            'fromname' => "Zeedlive",
            'subject' => "Seller Request Rejected",
            'text' => "Dear Mr/Ms. " . $sellerDetails->user->name . " Your collection convert request is rejected due to the following reason: " . $this->reason,
        );
        $this->sendMail($params);
        $message = 'Product rejected.';
        session()->flash('message', $message);
    }

    public function view($id)
    {
        return redirect()->route('product.show', $id);
    }

    public function liveStream($roomId)
    {
//        return redirect()->route('liveStream', $roomId);
    }

    public function filter($type)
    {
        $this->filter = $type;
        $this->selected = $type;
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
