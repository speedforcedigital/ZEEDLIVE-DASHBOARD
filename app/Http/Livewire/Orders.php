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
    public $showModal=false;

    public function render()
    {

        $allOrders = Order::orderByDesc('created_at')->paginate(10);
        $pendingOrders = Order::orderByDesc('created_at')->where("is_deliverd", '0')->where("is_shipped", '0')->paginate(10);
        $delieverdOrders = Order::orderByDesc('created_at')->where("is_deliverd", '1')->paginate(10);
        $shippedOrders = Order::orderByDesc('created_at')->where("is_shipped", '1')->where("is_deliverd", '0')->paginate(10);

        if ($this->filter === 'pending') {
            $orders = $pendingOrders;
            $totalOrders = $orders->total();
        } elseif ($this->filter === 'shipped') {
            $orders = $shippedOrders;
            $totalOrders = $shippedOrders->total();
        } elseif ($this->filter === 'delivered') {
            $orders = $delieverdOrders;
            $totalOrders = $delieverdOrders->total();
        }

        $totalPendingOrders = $pendingOrders->total();
        $totalDeliveredOrders = $delieverdOrders->total();
        $totalShippedOrders = $shippedOrders->total();
        $totalOrdersCount = $allOrders->total();
        return view('livewire.order', compact('orders','totalOrdersCount','totalShippedOrders','totalDeliveredOrders','totalPendingOrders','totalOrders'));
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
