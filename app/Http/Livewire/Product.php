<?php

namespace App\Http\Livewire;

use App\Models\Auction;
use App\Models\Lot;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithEvents;
use App\Http\Livewire\SuccessMessage;
use App\Models\UserReport;

class Product extends Component
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
            ->has('auction');
//            ->paginate($perPage);

        if (!empty($this->search)) {
            $products_all = $products_all->where('title', 'like', '%' . $this->search . '%');
        }

        $products_all = $products_all->paginate($perPage);

        $products_auc = Lot::orderByDesc('created_at')
            ->whereHas('auction', function ($query) {
                $query->where('type', 'Auction');
            })
            ->paginate($perPage);

        $products_buy = Lot::orderByDesc('created_at')
            ->whereHas('auction', function ($query) {
                $query->where('type', 'Buy Now');
            })
            ->paginate($perPage);

        $products_sold = Lot::orderByDesc('created_at')
            ->whereHas('auction', function ($query) {
                $query->where('auction_status', 'Sold');
            })
            ->paginate($perPage);

        $total_products_count = $products_buy->total() + $products_auc->total() + $products_sold->total();
        $total_products = $total_products_count;

        if ($this->filter === 'all') {
            $products = $products_all;
        } elseif ($this->filter === 'auctions') {
            $products = $products_auc;
        } elseif ($this->filter === 'buy_now') {
            $products = $products_buy;
        } elseif ($this->filter === 'sold') {
            $products = $products_sold;
        }

        $buyNowProducts = $products_buy->total();
        $auctionsProducts = $products_auc->total();
        $sold_products = $products_sold->total();

        return view('livewire.product', compact('total_products', 'total_products_count', 'products', 'buyNowProducts', 'auctionsProducts', 'sold_products'));
    }




    public function approve($id)
    {
        DB::table('auction')->where('id', $id)->update(['admin_status' => 'Approved']);
        $message = 'Product Approved.';
        session()->flash('message', $message);
    }

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
