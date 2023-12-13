<?php

namespace App\Http\Livewire;

use App\Models\DashboardNotifications;
use Livewire\Component;

class DashboardNotificationsLivewire extends Component
{
    public $sellerNotification, $liveStreamNotification, $standardNotification, $buyerReportNotification, $sellerReportNotification, $count;
    public $refundNotification;

    private $typeToProperty = [
        'Seller Request' => 'seller',
        'Live Stream' => 'liveStream',
        'Standard' => 'standard',
        'Buyer Report' => 'buyerReport',
        'Seller Report' => 'sellerReport',
        'Refund Request' => 'refund',
    ];

    public function mount()
    {
        $this->refreshNotifications();
    }

    public function render()
    {
        return view('livewire.dashboard-notifications');
    }

    public function refreshNotifications()
    {
        $notificationTypes = ['Seller Request', 'Live Stream', 'Standard', 'Buyer Report', 'Seller Report', 'Refund Request'];

        foreach ($notificationTypes as $type) {
            $notification = DashboardNotifications::where('type', $type)->where('is_read', 0)->first();
            $this->{$this->typeToProperty[$type] . 'Notification'} = $notification;
        }

        $this->count = count(array_filter([
            $this->sellerNotification,
            $this->liveStreamNotification,
            $this->standardNotification,
            $this->buyerReportNotification,
            $this->sellerReportNotification,
            $this->refundNotification,
        ]));
    }

    public function handleNotification($type, $route)
    {
        $property = $this->typeToProperty[$type];
        DashboardNotifications::where('type', $type)->where('is_read', 0)->update(['is_read' => 1]);
        return redirect()->route($route);
    }

    public function handleSellerNotification()
    {
        return $this->handleNotification('Seller Request', 'sellers.index');
    }
    public function handleRefundNotification()
    {
        return $this->handleNotification('Refund Request', 'refund.index');
    }

    public function handleBuyerReportNotification()
    {
        return $this->handleNotification('Buyer Report', 'reported.orders');
    }

    public function handleSellerReportNotification()
    {
        return $this->handleNotification('Seller Report', 'seller.reported.orders');
    }

    public function handleLiveStreamNotification()
    {
        return $this->handleNotification('Live Stream', 'livestream.products');
    }

    public function handleStandardNotification()
    {
        return $this->handleNotification('Standard', 'standard.products');
    }
}



