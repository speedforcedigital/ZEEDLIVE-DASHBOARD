<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ReportedOrders extends Component
{

    public $search = '';

    public function render()
    {
        $ordersQuery = Order::where('is_reported', 1)->orderByDesc('created_at');
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

        foreach ($ordersQuery->get() as $order) {

//            dd($order);
            $reportImagesArray = json_decode($order->report_images, true);

//            if ($reportImagesArray !== null) {
//                foreach ($reportImagesArray as $imageName) {
//                    $imageUrl = 'https://api.zeedlive.com/storage/users/reports/images/6549f5c1aeb59.jpg';
//                    $response = Http::get($imageUrl);
//                    if ($response->successful()) {
//                        $imageContent = $response->body();
//
//                        $order->imageContent = $imageContent;
//
//                    } else {
//                        dd("Error fetching image for {$imageName}");
//                    }
//
//                }
//            } else {
//                dd("Error decoding JSON string for report_images in order ID: {$order->id}");
//            }
        }
        $orders = $ordersQuery->paginate(10);
        return view('livewire.reported-orders', compact('orders'));
    }

    public function accept($id)
    {
        dd($id);
    }

    public function reject($id)
    {
        dd($id);
        $order = Order::where('id', $id)->update([
            'is_deliverd' => 1,
            'deliverd_at' => Carbon::now(),
            'deliverd_comment' => 'Your Order Is Deliverd.',
            'is_reported' => 0,
        ]);

        $orderData = DB::table('orders')->where('id', $id)->first();
        $getCompanyComissionPercentage = DB::table('generalsettings')->select('order_delivered_company_commision')->where('id', 1)->first();
        $companyPercentage = $getCompanyComissionPercentage->order_delivered_company_commision;
        $sellerPercentage = 100 - $companyPercentage;
        $companyComission = ($companyPercentage / 100) * $orderData->sub_total;
        $sellerAmount = ($sellerPercentage / 100) * $orderData->sub_total;
        $companyArr = array(
            'user_id' => $orderData->user_id,
            'seller_id' => $orderData->seller_id,
            'lot_id' => $orderData->lot_id,
            'comission_amount' => $companyComission
        );
        DB::table('company_wallet_record')->insert($companyArr);
        $sellerArr = array(
            'user_id' => $orderData->user_id,
            'seller_id' => $orderData->seller_id,
            'lot_id' => $orderData->lot_id,
            'order_amount_to_add_wallet' => $sellerAmount
        );
        DB::table('seller_wallet_record')->insert($sellerArr);
        $sellerWallet = DB::table('wallets')->where('user_id', $orderData->seller_id)->first();
        DB::table('wallets')->where('user_id', $orderData->seller_id)->update(['balance' => $sellerWallet->balance + $sellerAmount]);
        //end
        $payLoad =
            [
                "name" => "Order",
                "user_id" => $orderData->seller_id,
                "amount" => 1000,
                "type" => "addition",
                "wallet_id" => $sellerWallet->id,
            ];
        $this->storeTransaction($payLoad);
    }


    public function storeTransaction($data)
    {
        $transaction = DB::table('wallet_transactions')->insert($data);
    }

}
