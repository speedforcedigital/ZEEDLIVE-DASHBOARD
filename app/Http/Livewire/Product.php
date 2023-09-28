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
        $products_all =  Lot::orderByDesc('created_at') // Use 'created_at' or appropriate column name
            ->has('auction')
            ->paginate($perPage);
        $products_auc = Lot::orderByDesc('created_at') // Use 'created_at' or appropriate column name
            ->whereHas('auction', function ($query) {
                $query->where('type', 'Auction');
            })
            ->paginate($perPage);
        $products_buy = Lot::orderByDesc('created_at') // Use 'created_at' or appropriate column name
            ->whereHas('auction', function ($query) {
                $query->where('type', 'Buy Now');
            })
            ->paginate($perPage);
        if ($this->filter === 'all') {
            $products = $products_all;
            $total_products = $products_all->total();
        } elseif ($this->filter === 'auctions') {
            $products = $products_auc;
            $total_products = $products_auc->total();
        } elseif ($this->filter === 'buy_now') {
            $products = $products_buy;
            $total_products = $products_buy->total();
        }
        $total_products_count =  $products_all->total();
        $buyNowProducts = $products_buy->total();
        $auctionsProducts = $products_auc->total();
        return view('livewire.product', compact('total_products', 'total_products_count','products', 'buyNowProducts', 'auctionsProducts'));
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
