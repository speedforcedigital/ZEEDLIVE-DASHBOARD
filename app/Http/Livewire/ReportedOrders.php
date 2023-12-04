<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Octw\Aramex\Aramex;

class ReportedOrders extends Component
{

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

        $allOrders = Order::where('is_reported', 1)->where('is_admin_approved', 0)->orderByDesc('created_at');
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

        foreach ($orders as $order) {
            $imagePaths = json_decode($order->report_images);
            $videoPaths = json_decode($order->report_videos);
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
        return view('livewire.reported-orders', compact('orders'));
    }

    public function accept($id)
    {
        // now buyer will be seller and seller will be buyer
        $order = Order::where('id', $id)->first();
        $getBuyer = $order->seller_id;
        $getSeller = $order->user_id;

        $buyer = User::where('id', $getBuyer)->first();
        $seller = User::where('id', $getSeller)->first();

        $sellerAddress = DB::table('addresses')->where('user_id', $getSeller)->first();
//        dd($sellerAddress);
        $buyerAddress = DB::table('addresses')->where('user_id', $getBuyer)->first();


        $line1 = $sellerAddress->address;
        $line2 = 'Saudi Arabia';

        $buyerLine1 = $buyerAddress->address;
        $buyerLine2 = 'Saudi Arabia';

        $pickup_date = strtotime('tomorrow 10:00:00');
        $ready_time = strtotime('tomorrow 10:10:00');
        $last_pickup_time = strtotime('tomorrow 17:00:00');
        $closing_time = strtotime('tomorrow 17:30:00');


        $data = Aramex::createPickup([
            'name' => $seller->name,
            'cell_phone' => $seller->mobile,
            'phone' => $seller->mobile,
            'email' => 'saad@speedforce.agency', // ahmed company email
            'city' => $sellerAddress->city,
            'country_code' => 'SA',
            'zip_code' => $sellerAddress->zip_code,
            'line1' => $line1,
            'line2' => $line2,
            'pickup_date' => $pickup_date,
            'ready_time' => $ready_time,
            'last_pickup_time' => $last_pickup_time,
            'closing_time' => $closing_time,
            'status' => 'Ready',
            'pickup_location' => 'Home',
            'weight' => 2,
            'volume' => 1,
        ]);

        $pickupGUID = null;

        if (isset($data->pickupGUID)) {
//            dd($data->pickupGUID);
            $pickupGUID = $data->pickupGUID;
        }

        $callResponse = Aramex::createShipment([
            'shipper' => [
                'name' => $seller->name,
                'email' => $seller->email,
                'phone' => $seller->mobile,
                'cell_phone' => $seller->mobile,
                'country_code' => 'SA',
                'city' => $sellerAddress->city,
                'zip_code' => $sellerAddress->zip_code,
                'line1' => $line1,
                'line2' => $line2,
            ],
            'consignee' => [
                'name' => $buyer->name,
                'email' => $buyer->email,
                'phone' => $buyer->mobile,
                'cell_phone' => $buyer->mobile,
                'country_code' => 'SA',
                'city' => $buyerAddress->city,
                'zip_code' => $buyerAddress->zip_code,
                'line1' => $buyerLine1,
                'line2' => $buyerLine2,
            ],
            'shipping_date_time' => time() + 50000,
            'due_date' => time() + 60000,
            'comments' => 'No Comment',
            'pickup_location' => 'Home',
            'pickup_guid' => $pickupGUID,
            'weight' => 2,
            'number_of_pieces' => 1,
            'description' => 'Boxes',
        ]);

        if (!empty($callResponse->error)) {
            foreach ($callResponse->errors as $errorObject) {
                $this->handleError($errorObject->Code, $errorObject->Message);
            }
        } else {
            $shipmentId = $callResponse->Shipments->ProcessedShipment->ID;
            $labelUrl = $callResponse->Shipments->ProcessedShipment->ShipmentLabel->LabelURL;

            $Sellerparams = array(
                'to' => $seller->email,
                'from' => env("MAIL_FROM_ADDRESS"),
                'fromname' => "Zeed",
                'subject' => "Aramex BarCode",
                'text' => "Hi Mr/Ms. " . $seller->name . ", " . "Your barcode for Aramex is ." . $labelUrl,

            );
            $this->sendMail($Sellerparams);
            $buyerparams = array(
                'to' => $buyer->email,
                'from' => env("MAIL_FROM_ADDRESS"),
                'fromname' => "Zeed",
                'subject' => "Tracking Number",
                'text' => "Hi Mr/Ms. " . $buyer->name . ", " . "Your tracking number for Aramex is ." . $shipmentId,
            );
            $this->sendMail($buyerparams);

//                    dump($shipmentId, $labelUrl);

            //store tracking number to orders table

            $order->tracking_number = $shipmentId;
            $order->is_admin_approved = 1;
            // is_shipped?  bcz we have tracking number
//            $order->user_id = $buyer->id;
//            $order->seller_id = $seller->id;
//            $order->is_shipped = 0;
//            $order->is_reported = 0;
            $order->save();
        }

        $message = 'Report Approved Successfully';
        session()->flash('message', $message);
    }

    public function handleError($code, $message)
    {
        echo "Error: $code - $message";
    }

    public function reject($id)
    {
//        dd($id);
        $order = Order::where('id', $id)->update([
            'is_deliverd' => 1,
            'deliverd_at' => Carbon::now(),
            'deliverd_comment' => 'Your Order Is Delivered.',
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
        $created_at = Carbon::now()->setTimezone('Asia/Kuwait');
        $updated_at = Carbon::now()->setTimezone('Asia/Kuwait');
        $data['created_at'] = $created_at;
        $data['updated_at'] = $updated_at;
        $transaction = DB::table('wallet_transactions')->insert($data);
    }

    public function sendMail($params)
    {
        $url = 'https://api.sendgrid.com/';
        $sendgrid_apikey = env("MAIL_PASSWORD");

        $request = $url . 'api/mail.send.json';
        // Generate curl request
        $session = curl_init($request);
        // Tell PHP not to use SSLv3 (instead opting for TLS)
        curl_setopt($session, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($session, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $sendgrid_apikey));
        // Tell curl to use HTTP POST
        curl_setopt($session, CURLOPT_POST, true);
        // Tell curl that this is the body of the POST
        curl_setopt($session, CURLOPT_POSTFIELDS, $params);
        // Tell curl not to return headers, but do return the response
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        // obtain response
        $response = curl_exec($session);
        curl_close($session);
        json_decode($response);
    }

}
