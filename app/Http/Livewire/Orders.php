<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class Orders extends Component
{

    // is_deliverd
    public $filter = 'all';
    public $selected = 'all';
    public $order;
    public $showModal = false;
    public $search = '';

    public $fromDate, $toDate;

    public function render()
    {
        $ordersQuery = Order::orderByDesc('created_at');

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
        $reportedOrders = Order::where("is_reported", '1')->where("is_deliverd", '0')->where("is_shipped", '0')->paginate(10);
        $returnedOrders = Order::where("is_returned", '1')->paginate(10);

        if ($this->fromDate && $this->toDate) {
            $ordersQuery->whereBetween('created_at', [$this->fromDate, $this->toDate]);
        }
        $ordersAll = $allOrders->total(); // for all orders filter count
        if ($this->filter === 'all') {
            $orders = $allOrders;
            $totalOrders = $allOrders->total();
        } elseif ($this->filter === 'pending') {
            $orders = $pendingOrders;
            $totalOrders = $orders->total();
        } elseif ($this->filter === 'shipped') {
            $orders = $shippedOrders;
            $totalOrders = $shippedOrders->total();
        } elseif ($this->filter === 'delivered') {
            $orders = $deliveredOrders;
            $totalOrders = $deliveredOrders->total();
        } elseif ($this->filter === 'reported') {
            $orders = $reportedOrders;
            $totalOrders = $reportedOrders->total();
        } elseif ($this->filter === 'returned') {
            $orders = $returnedOrders;
            $totalOrders = $returnedOrders->total();
        } else {
            $orders = $allOrders;
            $totalOrders = $allOrders->total();
        }

        $totalPendingOrders = $pendingOrders->total();
        $totalDeliveredOrders = $deliveredOrders->total();
        $totalShippedOrders = $shippedOrders->total();
        $totalOrdersCount = $allOrders->total();
        $totalReportedOrders = $reportedOrders->total();
        $totalReturnedOrders = $returnedOrders->total();

        return view('livewire.order', compact('orders', 'totalOrdersCount', 'totalShippedOrders', 'totalDeliveredOrders', 'totalPendingOrders', 'totalOrders', 'totalReportedOrders', 'totalReturnedOrders', 'ordersAll'));
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
