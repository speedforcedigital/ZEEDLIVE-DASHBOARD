<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class SellerReportedOrders extends Component
{
    use withPagination;
    public $search = '';

    public function render()
    {
        $perPage = 10;
//        $ordersQuery = Order::where('is_reported', 1)->orderByDesc('created_at');
//        if ($this->search) {
//            $ordersQuery->where(function ($query) {
//                $query->whereHas('seller', function ($subQuery) {
//                    $subQuery->where('name', 'like', '%' . $this->search . '%');
//                })->orWhereHas('customer', function ($subQuery) {
//                    $subQuery->where('name', 'like', '%' . $this->search . '%');
//                })
//                    ->orWhere('order_id', 'like', '%' . $this->search . '%');
//            });
//        }

        $allOrders = Order::where('is_reported', 1)->where('is_seller_reported', 1)->orderByDesc('created_at');
        if (!empty($this->search)) {
            $allOrders = $allOrders->where(function ($query) {
                $query->whereHas('seller', function ($subQuery) {
                    $subQuery->where('name', 'like', '%' . $this->search . '%');
                })->orWhereHas('customer', function ($subQuery) {
                    $subQuery->where('name', 'like', '%' . $this->search . '%');
                })
                    ->orWhere('order_id', 'like', '%' . $this->search . '%');
            });
        }




        $orders = $allOrders->paginate($perPage);
//       dd($orders);

        foreach ($orders as $order) {
            $imagePaths = json_decode($order->seller_report_images);
            $videoPaths = json_decode($order->seller_report_videos);
            $imageUrls = [];
            $videoUrls = [];
            foreach ($imagePaths as $path) {
                $url = Storage::disk('do')->url($path);
                $imageUrls[] = $url;
            }
            foreach ($videoPaths as $path) {
                $url = Storage::disk('do')->url($path);
                $videoUrls[] = $url;
            }
            $order->report_images = $imageUrls;
            $order->report_videos = $videoUrls;
//            dd($order->report_images);
        }
        return view('livewire.seller-reported-orders', compact('orders'));
    }
}
