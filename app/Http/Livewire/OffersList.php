<?php

namespace App\Http\Livewire;

use App\Models\Auction;
use App\Models\Cart;
use App\Models\FreezeModel;
use App\Models\Lot;
use App\Models\MyCollection;
use App\Models\Offers;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;

class OffersList extends Component
{
    public $offer_id;

    public $search = '';

    public $reason = '';

    protected $rules = [
        'reason' => 'required',
    ];

//    public function render()
//    {
//        $perPage= 10 ;
//        $offers = Offers::with(['user', 'receiver', 'collection'])->get();
//        $total_offers = count($offers);
//        $offers = Offers::with(['user', 'receiver', 'collection'])->paginate($perPage);
//
//        return view('livewire.offers', compact('offers', 'total_offers'));
//    }

    public function render()
    {
        $perPage = 10;
        $query = Offers::with(['user', 'receiver', 'collection']);

        if (!empty($this->search)) {
            $query->whereHas('user', function ($userQuery) {
                $userQuery->where('name', 'like', '%' . $this->search . '%');
            })
                ->orWhereHas('receiver', function ($receiverQuery) {
                    $receiverQuery->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('collection', function ($collectionQuery) {
                    $collectionQuery->where('title', 'like', '%' . $this->search . '%');
                });

        }

        $offers = $query->where('is_accepted', 1)->paginate($perPage);
        $total_offers = $query->count(); // Count without pagination

        return view('livewire.offers', compact('offers', 'total_offers'));
    }


    public function accept($id)
    {
        $offer_id = $id;
        $offer = Offers::where("offer_id", $offer_id)->first();
        $sellerData = User::where("id", $offer->offer_receiver_id)->first();
        $buyerData = User::where("id", $offer->offer_sender_id)->first();
        $collectionData = MyCollection::where("id", $offer->collection_id)->first();
        if ($offer->modrator_status == 'Approved') {
            $status = 200;
            $data = array(
                'success' => true,
                'message' => 'Already Approved'
            );
            return response()->json($data, $status);
        }
        if ($offer->modrator_status == 'Pending') {
            DB::beginTransaction();
            try {

                $offer->modrator_status = "Approved";
                $offer->save();
                $auction = new Auction;
                $auction->collection_id = $offer->collection_id;
                $auction->user_id = $collectionData->user_id;
                $auction->type = 'Buy Now';
                $auction->auction_status = 'Sold';
                $auction->admin_status = 'Approved';
                $auction->save();

                $auctionLastInsertId = $auction->id;
                $Lot = new Lot;
                $Lot->collection_id = $offer->collection_id;
                $Lot->auction_id = $auctionLastInsertId;
                $Lot->title = $collectionData->title;
                $Lot->image = $collectionData->image;
                $Lot->description = $collectionData->description;
                $Lot->price = $offer->amount;
                $Lot->year = $collectionData->year;
                $Lot->gender = $collectionData->gender;
                $Lot->color = $collectionData->color;
                $Lot->conditions = $collectionData->conditions;
                $Lot->appendices = $collectionData->appendices;
                $Lot->category_id = $collectionData->category_id;
                $Lot->brand_id = $collectionData->brand_id;
                $Lot->model_id = $collectionData->model_id;
                $Lot->save();
                $collectionData->is_auction = 1;
                $collectionData->save();

                $LotLastInsertId = $Lot->id;
                //gallery
                DB::table('product_galleries')->where('collection_id', $offer->collection_id)->update(['product_id' => $LotLastInsertId]);
                //cart
                $now = Carbon::now()->setTimezone('Asia/Kuwait');
                $after_24_hours = $now->addHours(24);

                Cart::create([
                    'user_id' => $offer->offer_sender_id,
                    'lot_id' => $LotLastInsertId,
                    'status' => 'Offer',
                    'experied_time' => $after_24_hours,
                    'offer_id' => $offer_id,
                ]);
//                //send email to buyer
                $buyerParams = array(
                    'to' => $buyerData->email,
                    'from' => env('MAIL_FROM_ADDRESS'),
                    'fromname' => "Zeed Offer",
                    'subject' => "Zeed Offer Acception",
                    'text' => "Your offer has been accepted by “" . $sellerData->name . "” on the collection “" . $collectionData->title . "”, Kindly proceed with the payment within 24 hours.",
                );

                $this->sendMail($buyerParams);

//                //send email to seller
//
                $sellerParams = array(
                    'to' => $sellerData->email,
                    'from' => env('MAIL_FROM_ADDRESS'),
                    'fromname' => "Zeed Offer",
                    'subject' => "Zeed Offer Acception",
                    'text' => "We have accepted your request to sell your collection “" . $collectionData->title . "” to the person " . $buyerData->name . ", Once the buyer complete the purchase, We will inform you to complete the shipping process.",
                );

                $this->sendMail($sellerParams);
                $message = 'Offer Accepted Sucessfully.';
                DB::commit();
                return redirect()->route('offers')->with('message', $message);
//                return response()->json($data, $status);
            } catch (\Exception $e) {
                $status = 200;
                $data = array(
                    'success' => false,
                    'message' => $e->getMessage()
                );
                DB::rollback();
                // Rollback the transaction on exception
                return response()->json($data, $status);
            }


        }


    }


    public function reject($id)
    {
        $this->validate();
        $offer = Offers::find($id);
        $offer->is_accepted = false;
        $offer->modrator_status = 'Rejected';
        $offer->save();
        $sellerData = User::where("id", $offer->offer_receiver_id)->first();
        $buyerData = User::where("id", $offer->offer_sender_id)->first();
        // send freeze amount back to offer_sender
        $freezeAmount = FreezeModel::where("offer_id", $id)->first();
        if ($freezeAmount) {
            $wallet = Wallet::where('user_id', $freezeAmount->user_id)->first();
            $wallet->balance = $wallet->balance + 1000;
            $wallet->save();
            $data =
                [
                    "name" => "Freezed Amount Refund",
                    "user_id" => $freezeAmount->user_id,
                    "amount" => 1000,
                    "type" => "addition",
                    "wallet_id" => $wallet->id,
                ];
            $this->storeTransaction($data);

            $freezeAmount->delete();
        }

        //send email to buyer
        $buyerParams = array(
            'to' => $buyerData->email,
            'from' => env('MAIL_FROM_ADDRESS'),
            'fromname' => "Zeed Offer",
            'subject' => "Zeed Offer Rejection",
            'text' => "Moderator has rejected your offer due to following reason:- “" . $this->reason . "”.",
        );

        $this->sendMail($buyerParams);

        //send email to seller
        $sellerParams = array(
            'to' => $sellerData->email,
            'from' => env('MAIL_FROM_ADDRESS'),
            'fromname' => "Zeed Offer",
            'subject' => "Zeed Offer Rejection",
            'text' => "Moderator has rejected your offer due to following reason:-“" . $this->reason . "”.",
        );
        $this->sendMail($sellerParams);


        $message = 'Offer Rejected Successfully.';
        return redirect()->route('offers')->with('message', $message);
    }

    public function storeTransaction($data)
    {
        $transaction = DB::table('wallet_transactions')
            ->where('user_id', $data['user_id'])
            ->where('name', $data['name'])
            ->where('type', $data['type'])
            ->first();

        $now = Carbon::now()->setTimezone('Asia/Kuwait');

        if ($transaction) {
            DB::table('wallet_transactions')
                ->where('user_id', $data['user_id'])
                ->where('name', $data['name'])
                ->where('type', $data['type'])
                ->update(['amount' => $data['amount'], 'updated_at' => $now]);

            return;
        }

        $data['created_at'] = $now;
        $data['updated_at'] = $now;

        DB::table('wallet_transactions')->insert($data);
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
