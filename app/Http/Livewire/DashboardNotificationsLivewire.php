<?php

namespace App\Http\Livewire;

use App\Models\DashboardNotifications;
use Livewire\Component;

class DashboardNotificationsLivewire extends Component
{
    public $sellerNotification;
    public $liveStreamNotification;
    public $standardNotification;
    public $count;

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
        $this->sellerNotification = DashboardNotifications::where('type', 'Seller Request')->where('is_read', 0)->first();
        $this->liveStreamNotification = DashboardNotifications::where('type', 'Live Stream')->where('is_read', 0)->first();
        $this->standardNotification = DashboardNotifications::where('type', 'Standard')->where('is_read', 0)->first();

        $this->count = ($this->sellerNotification ? 1 : 0) + ($this->liveStreamNotification ? 1 : 0) + ($this->standardNotification ? 1 : 0);
    }

    public function handleSellerNotification()
    {
        DashboardNotifications::where('type', 'Seller Request')->where('is_read', 0)->update(['is_read' => 1]);
        return redirect()->route('sellers.index');
    }

    public function handleLiveStreamNotification()
    {
        DashboardNotifications::where('type', 'Live Stream')->where('is_read', 0)->update(['is_read' => 1]);
        return redirect()->route('livestream.products');
    }

    public function handleStandardNotification()
    {
        DashboardNotifications::where('type', 'Standard')->where('is_read', 0)->update(['is_read' => 1]);
        return redirect()->route('standard.products');
    }

}
