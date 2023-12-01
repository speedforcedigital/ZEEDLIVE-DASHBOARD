<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class Orders extends Component
{

    // is_deliverd
    public $filter = 'pending';
    public $selected = 'pending';
    public $order;
    public $showModal = false;
    public $search = '';

    public function render()
    {
        $ordersQuery = Order::orderByDesc('created_at');
//        dd($ordersQuery);

        if ($this->search) {
            $ordersQuery->where(function ($query) {
                $query->whereHas('seller', function ($subQuery) {
                    $subQuery->where('name', 'like', '%' . $this->search . '%');
                })->orWhereHas('customer', function ($subQuery) {
                    $subQuery->where('name', 'like', '%' . $this->search . '%');
                })
                    ->orWhere('order_id', 'like', '%' . $this->search . '%');
            });
        }

        $allOrders = $ordersQuery->paginate(10);
        $pendingOrders = $ordersQuery->where("is_deliverd", '0')->where("is_shipped", '0')->paginate(10);
        $deliveredOrders = Order::where("is_deliverd", '1')->paginate(10);
        $shippedOrders = Order::where("is_shipped", '1')->where("is_deliverd", '0')->paginate(10);
//        dd($shippedOrders);


        if ($this->filter === 'pending') {
            $orders = $pendingOrders;
            $totalOrders = $orders->total();
        } elseif ($this->filter === 'shipped') {
            $orders = $shippedOrders;
            $totalOrders = $shippedOrders->total();
        } elseif ($this->filter === 'delivered') {
            $orders = $deliveredOrders;
            $totalOrders = $deliveredOrders->total();
        } else {
            $orders = $allOrders;
            $totalOrders = $allOrders->total();
        }

        $totalPendingOrders = $pendingOrders->total();
        $totalDeliveredOrders = $deliveredOrders->total();
        $totalShippedOrders = $shippedOrders->total();
        $totalOrdersCount = $allOrders->total();
//        dd($orders);

        return view('livewire.order', compact('orders', 'totalOrdersCount', 'totalShippedOrders', 'totalDeliveredOrders', 'totalPendingOrders', 'totalOrders'));
    }


    public function orderDetail($id)
    {
        $this->order = Order::find($id);  // Assuming you have a Report model
        $this->showModal = true;
    }

    public function filter($type)
    {
        $this->filter = $type;
        $this->selected = $type;
    }
}
