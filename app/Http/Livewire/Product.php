<?php

namespace App\Http\Livewire;

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
    public function render()
    {
        $perPage = 10;

        $products_all = Lot::orderByDesc('created_at')
            ->has('auction')
            ->paginate($perPage);

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
}
