<?php

namespace App\Http\Controllers;

use App\Models\AccountDetail;
use App\Models\Lot;
use App\Models\MyCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function view($id)
    {
        $lot = Lot::where("id", $id)->with("auction")->first();
        if ($lot->image != null) {
            $lot->image = Storage::disk('do')->url($lot->image);
        }
//        dd($lot);
        if ($lot->video != null) {
            $lot->video = Storage::disk('do')->url($lot->video);
        }
        $lot->auction->user->image = AccountDetail::where('user_id', $lot->auction->user->id)->first()->profile_image;
//        dd($lot->auction->user->image);
        $lot->gallery_images = DB::table('product_galleries')->where('product_id', $id)->get();
        if ($lot->gallery_images !=null) {
            foreach ($lot->gallery_images as $key => $value) {
                $lot->gallery_images[$key]->image = Storage::disk('do')->url($value->image);
            }
        }
        return view("products.show", compact('lot'));
    }

    public function convertProduct($productID)
    {
        //
        $lot = Lot::where('id', $productID)->first();
        $CollectionId = $lot->collection_id;
        $collection = MyCollection::find($CollectionId);
        if ($collection) {
            $collection->update(['is_auction' => 0]);
        }
        $offerData = DB::table('offers')->where('collection_id', $CollectionId)->get();
        if (!$offerData->isEmpty()) {
            DB::table('offers')->where('collection_id', $CollectionId)->delete();
        }
        $cart = DB::table('carts')->where('lot_id', $productID)->get();
        if (!$cart->isEmpty()) {
            DB::table('carts')->where('lot_id', $productID)->delete();
        }

        $sellerId = $lot->collection->user_id;
        $user = User::find($sellerId);

        //send email to seller
        $sellerParams = array(
            'to' => $user->email,
            'from' => env('MAIL_FROM_ADDRESS'),
            'fromname' => "ZeedLive",
            'subject' => "Livestream Cancellation",
            'text' => "The moderator has cancelled your livestream.Convert your collection again to sell your product. For any further queries, contact support team.
            Regards,",
        );

        $this->sendMail($sellerParams);

        return response()->json(['message' => 'Product Converted Successfully.'], 200);
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
