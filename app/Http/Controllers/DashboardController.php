<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\DataFeed;
use App\Helpers\makeCurlPostRequest;
use App\Helpers\baseUrl;
use App\Models\BidDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\Lot;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Followers;
use App\Models\MyCollection;
use App\Models\Offers;
use App\Models\Order;
use App\Models\OrderTransactions;

class DashboardController extends Controller
{

    /**
     * Displays the dashboard screen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $type = 'Pending';
        $totalLiveAuctions = Lot::where("is_live", 1)->count();

        $totalLiveStreams = Lot::where('is_delete', 0)->whereHas('auction', function ($query) use ($type) {
            $query->where('is_scadual_live', 1);
        })->count();

        $totalBuyNowProducts = Lot::where('is_delete', 0)->whereHas('auction', function ($query) use ($type) {
            $query->where('type', "Buy Now");
        })->count();

        $totalSales = OrderTransactions::sum('amount');


        $totalBids = BidDetails::where("is_active", 1)->count();
        $closedBids = BidDetails::where("is_active", 0)->count();


        $totalLiveBids = BidDetails::whereHas('lot.auction', function ($query) use ($type) {
            $query->where('is_scadual_live', 1);
        })->count();
        $totalBuyNowBids = BidDetails::whereHas('lot.auction', function ($query) use ($type) {
            $query->where('type', "Buy Now");
        })->count();


//        $totalBuyNowSales = Lot::where('is_delete', 0)->whereHas('auction', function ($query) use ($type) {
//            $query->where('type', "Buy Now" && 'auction_status', 'Sold');
//        })->count();
//        dd($totalBuyNowSales);

        // Buy Now sales
        $totalBuyNowSales = Order::whereHas('lot.auction', function ($query) use ($type) {
            $query->where('type', "Buy Now")->where('auction_status', 'Sold');
        })->count();

        $buyNowSalesAmount = Order::whereHas('lot.auction', function ($query) use ($type) {
            $query->where('type', "Buy Now")->where('auction_status', 'Sold');
        })->sum('sub_total');

        // Auction sales

        $totalAuctionSales = Order::whereHas('lot.auction', function ($query) use ($type) {
            $query->where('type', "Auction")->where('auction_status', 'Sold');
        })->count();
        $auctionSalesAmount = Order::whereHas('lot.auction', function ($query) use ($type) {
            $query->where('type', "Auction")->where('auction_status', 'Sold');
        })->sum('sub_total');

        // Live Streams sales

        $totalLiveStreamsSales = Order::whereHas('lot.auction', function ($query) use ($type) {
            $query->where('is_scadual_live', 1)->where('auction_status', 'Sold');
        })->count();
        $totalLiveStreamsAmount = Order::whereHas('lot.auction', function ($query) use ($type) {
            $query->where('is_scadual_live', 1)->where('auction_status', 'Sold');
        })->sum('sub_total');

        $totalSalesAmount = $buyNowSalesAmount + $auctionSalesAmount + $totalLiveStreamsAmount;


//        dd($toalBuyNowSales, $totalAuctionSales,$totalLiveStreamsSales);

        $data = [
            'totalLiveAuctions' => $totalLiveAuctions,
            'totalLiveStreams' => $totalLiveStreams,
            'totalBuyNowProducts' => $totalBuyNowProducts,
            'totalBids' => $totalBids,
            'totalLiveBids' => $totalLiveBids,
            'totalBuyNowBids' => $totalBuyNowBids,
            'closedBids' => $closedBids,
            'totalBuyNowSales' => $totalBuyNowSales,
            'buyNowSalesAmount' => $buyNowSalesAmount,
            'totalAuctionSales' => $totalAuctionSales,
            'auctionSalesAmount' => $auctionSalesAmount,
            'totalLiveStreamsSales' => $totalLiveStreamsSales,
            'totalLiveStreamsAmount' => $totalLiveStreamsAmount,
            'totalSalesAmount' => $totalSalesAmount,
        ];

        // get ranking data from database
        $getRanking = null;

        $i = 0;
        $ranking_data = [];
        if ($getRanking) {
            foreach ($getRanking as $val) {
                $i++;
                $AuctualRate = sprintf("%.2f", $val->totalRate / $val->totalCount);
                $ranking_data[] = array(
                    "seller_id" => $val->seller_id,
                    "position" => $i,
                    "name" => $val->name,
                    "followers" => $this->getFollowers($val->seller_id),
                    "followings" => $this->getFollowings($val->seller_id),
                    "totalRateCounts" => $val->totalCount,
                    "AuctualRate" => ($AuctualRate < 1000 ? $AuctualRate : $this->thousand_format($AuctualRate)),
                    "profileImage" => $this->profileImage($val->seller_id),
                );
            }
        }


        return view('pages/dashboard/dashboard', compact('data', 'ranking_data', 'totalSales'));
    }

    public function getChartData()
    {
        $buyNowSalesAmount = Order::whereHas('lot.auction', function ($query) {
            $query->where('type', "Buy Now")->where('auction_status', 'Sold');
        })->sum('sub_total');

        $auctionSalesAmount = Order::whereHas('lot.auction', function ($query) {
            $query->where('type', "Auction")->where('auction_status', 'Sold');
        })->sum('sub_total');

        $totalLiveStreamsAmount = Order::whereHas('lot.auction', function ($query) {
            $query->where('is_scadual_live', 1)->where('auction_status', 'Sold');
        })->sum('sub_total');

        $totalSalesAmount = $buyNowSalesAmount + $auctionSalesAmount + $totalLiveStreamsAmount;

        $data = [$buyNowSalesAmount, $auctionSalesAmount, $totalLiveStreamsAmount];

        $response = [
            'data' => $data,
            'totalSalesAmount' => $totalSalesAmount,
        ];
        return response()->json($response);
    }

    public function getFollowers($id)
    {
        $followers = Followers::where('leader_id', $id)->count();
        return $followers;
    }

    public function getFollowings($id)
    {
        $following = Followers::where('follower_id', $id)->count();
        return $following;
    }

    public function profileImage($seller_id)
    {
        $result = DB::table('account_detail')
            ->select('profile_image')
            ->where('user_id', $seller_id)
            ->get();
        $i = 0;
        if ($result != '' && $result != null) {
            foreach ($result as $row) {
                $type[$i]['profile_image'] = $row->profile_image;
                $i++;
            }
        }
        return isset($type) ? $type : null;
    }

    public function getSalesData(Request $request)
    {
        // Get the current date
        $currentDate = Carbon::now();

        // Initialize arrays to store data for daily, monthly, and yearly scales
        $dailyData = [];
        $monthlyData = [];
        $yearlyData = [];

        // Initialize arrays to store labels for each scale
        $dailyLabels = [];
        $monthlyLabels = [];
        $yearlyLabels = [];

        // Calculate the start date for the last 30 days
        $startDate = $currentDate->subDays(30);

        // Retrieve transaction data for the last 30 days
        $dailyTransactions = DB::table('order_transactions')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total'))
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->get();

        // Process daily transactions and create a dictionary for quick access
        for ($i = 0; $i < 30; $i++) {
            $dailyKey = $currentDate->format('m/d/y');
            $dailyDataDict[$dailyKey] = 0;
            $dailyLabels[] = $dailyKey;
            $currentDate->addDay();
        }

        // Fill in actual daily transaction data where available
        foreach ($dailyTransactions as $transaction) {
            $dailyKey = Carbon::parse($transaction->date)->format('m/d/y');
            $dailyDataDict[$dailyKey] = $transaction->total;
        }

        // Create arrays for the last 12 months' labels
        $last12MonthsLabels = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $last12MonthsLabels[] = $date->format('M Y');
        }

        // Retrieve transaction data for the last 12 months
        $monthlyTransactions = DB::table('order_transactions')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('SUM(amount) as total'))
            ->where('created_at', '>=', $currentDate->subMonths(12))
            ->groupBy('month')
            ->get();

        // Process monthly transactions and create a dictionary for quick access
        $monthlyDataDict = [];
        foreach ($monthlyTransactions as $transaction) {
            $monthlyKey = Carbon::parse($transaction->month)->format('M Y');
            $monthlyDataDict[$monthlyKey] = $transaction->total;
            $monthlyLabels[] = $monthlyKey;
        }

        // Create arrays for the last 5 years' labels
        $last5YearsLabels = [];
        for ($i = 0; $i < 5; $i++) {
            $year = Carbon::now()->subYears($i)->format('Y');
            $last5YearsLabels[] = $year;
        }

        // Retrieve transaction data for the last 5 years
        $yearlyTransactions = DB::table('order_transactions')
            ->select(DB::raw('YEAR(created_at) as year'), DB::raw('SUM(amount) as total'))
            ->where('created_at', '>=', $currentDate->subYears(5))
            ->groupBy('year')
            ->get();

        // Process yearly transactions and create a dictionary for quick access
        $yearlyDataDict = [];
        foreach ($yearlyTransactions as $transaction) {
            $yearlyKey = $transaction->year;
            $yearlyDataDict[$yearlyKey] = $transaction->total;
            $yearlyLabels[] = $yearlyKey;
        }

        // Fill in zero values for days, months, and years with no transactions
        foreach ($dailyLabels as $label) {
            if (!isset($dailyDataDict[$label])) {
                $dailyDataDict[$label] = 0;
            }
        }

        foreach ($last12MonthsLabels as $label) {
            if (!isset($monthlyDataDict[$label])) {
                $monthlyDataDict[$label] = 0;
            }
        }

        foreach ($last5YearsLabels as $label) {
            if (!isset($yearlyDataDict[$label])) {
                $yearlyDataDict[$label] = 0;
            }
        }

        // Rebuild data arrays with zero values included
        foreach ($dailyLabels as $label) {
            $dailyData[] = $dailyDataDict[$label];
        }

        foreach ($last12MonthsLabels as $label) {
            $monthlyData[] = $monthlyDataDict[$label];
        }

        foreach ($last5YearsLabels as $label) {
            $yearlyData[] = $yearlyDataDict[$label];
        }

        // Create an associative array to hold the data for each scale
        $chartData = [
            'daily' => [
                'labels' => $dailyLabels,
                'data' => $dailyData,
                'totalSales' => $dailyTransactions->sum('total')
            ],
            'monthly' => [
                'labels' => $last12MonthsLabels,
                'data' => $monthlyData,
                'totalSales' => $monthlyTransactions->sum('total')
            ],
            'yearly' => [
                'labels' => $last5YearsLabels,
                'data' => $yearlyData,
                'totalSales' => $yearlyTransactions->sum('total')
            ],
        ];

        return response()->json($chartData);
    }

    public function getDataFeed(Request $request)
    {
        $df = new DataFeed();

        return ((object)[
            'labels' => $df->getDataFeed(
                $request->datatype,
                'label',
                $request->limit
            ),
            'data' => $df->getDataFeed(
                $request->datatype,
                'data',
                $request->limit
            ),
        ]);
    }

    public function getUsersByAge()
    {
        $ageGroups = [
            "<18",
            "18-24",
            "25-35",
            ">35",
        ];

        $data = [
            'labels' => [],
            'data' => [],
        ];

        foreach ($ageGroups as $ageGroup) {
            $usersCount = 0;

            if (strpos($ageGroup, '<') !== false) {
                // Handle age group "<18"
                $maxAge = intval(str_replace('<', '', $ageGroup));
                $usersCount = User::where('date_of_birth', '>', now()->subYears($maxAge))->count();
            } elseif (strpos($ageGroup, '>') !== false) {
                // Handle age group ">35"
                $minAge = intval(str_replace('>', '', $ageGroup));
                $usersCount = User::where('date_of_birth', '<', now()->subYears($minAge + 1))->count();
            } else {
                // Handle age group "18-24" and "25-35"
                list($minAge, $maxAge) = explode('-', $ageGroup);
                $usersCount = User::whereBetween('date_of_birth', [now()->subYears($maxAge), now()->subYears($minAge + 1)])->count();
            }

            $data['labels'][] = $ageGroup;
            $data['data'][] = $usersCount;
        }

        return response()->json($data);
    }

    public function getUsersByGender()
    {
        $genders = ["Male", "Female"];

        $data = [
            'labels' => [],
            'data' => [],
        ];

        foreach ($genders as $gender) {
            $userCount = User::where('gender', $gender)->count();
            $data['labels'][] = $gender;
            $data['data'][] = $userCount;
        }
        return response()->json($data);
    }

    public function userView($id)
    {
        $user = User::find($id);
        $products = Lot::whereHas('collection', function ($query) use ($id) {
            $query->where('user_id', $id);
        })->get();
        $offers = Offers::where("offer_sender_id", $user->id)->count();
        $orders = Order::where("user_id", $user->id)->get();
        return view('pages.dashboard.user-view', compact('user', 'products', 'offers', 'orders'));

    }

    public function collectionView($id)
    {
        $collection = MyCollection::find($id);
        return view('pages.dashboard.collection-view', compact('collection'));

    }
}
