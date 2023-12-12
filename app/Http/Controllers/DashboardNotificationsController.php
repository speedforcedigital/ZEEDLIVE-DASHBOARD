<?php

namespace App\Http\Controllers;

use App\Models\DashboardNotifications;
use Illuminate\Http\Request;

class DashboardNotificationsController extends Controller
{
    public function getNotificationsCount()
    {
        $SellerNotification = DashboardNotifications::where('type', 'Seller Request')->where('is_read', 0)->first();
        $liveStreamNotification = DashboardNotifications::where('type', 'Live Stream')->where('is_read', 0)->first();
        $standardNotification = DashboardNotifications::where('type', 'Standard')->where('is_read', 0)->first();

        return view('components.app.header', compact('SellerNotification', 'liveStreamNotification', 'standardNotification'));


//        return response()->json([
//            'success' => true,
//            'sellerNotification' => $SellerNotification,
//            'liveStreamNotification' => $liveStreamNotification,
//            'standardNotification' => $standardNotification,
//        ]);
    }
    public function updateNotifications()
    {
        DashboardNotifications::where('type', 'Seller Request')->where('is_read', 0)->update(['is_read' => 1]);
        return response()->json(['success' => true]);
    }
}
