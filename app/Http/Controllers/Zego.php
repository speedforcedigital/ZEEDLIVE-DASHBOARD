<?php
//require 'vendor/autoload.php';
namespace App\Http\Controllers;

use App\Models\Lot;
use App\Models\MyCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use ZEGO\ZegoErrorCodes;
use ZEGO\ZegoServerAssistant;

class Zego extends Controller
{
    private $currentProductId;

    public function getToken($productID)
    {
        $this->currentProductId = 123;
        $appId = 1553886775;
        $userId = (string)auth()->user()->id;
        $secret = 'bf3920cbebff1db853578528c76f16aa';
        $payload = '';
        $token = ZegoServerAssistant::generateToken04($appId, $userId, $secret, 3600, $payload);
        if ($token->code == ZegoErrorCodes::success) {
            $generatedToken = $token->token;
        } else {
            $generatedToken = $token->code;
        }
        $roomID = $productID;
        $userName = auth()->user()->name;
        $data = [
            'token' => $generatedToken,
            'roomID' => $roomID,
            'userID' => $userId,
            'appID' => $appId,
            'userName' => $userName,
        ];
        return response()->json($data);
    }


    function generateSignature($appId, $serverSecret, $timestamp)
    {
        $signatureNonce = Str::random(16); // Generate a random string of 16 characters

        $str = $appId . $signatureNonce . $serverSecret . $timestamp;
        $signature = md5($str);
        return [
            'signatureNonce' => $signatureNonce,
            'signature' => $signature,
        ];
    }


    public function getSignature($productID)
    {

        $appId = 1553886775;
        $serverSecret = "bf3920cbebff1db853578528c76f16aa";
        $timestamp = now()->setTimezone('Asia/Kuwait')->timestamp;
//        dd($timestamp);

        $signatureData = $this->generateSignature($appId, $serverSecret, $timestamp);
        $signatureNonce = $signatureData['signatureNonce'];
        $signature = $signatureData['signature'];

        $streamId = $productID;
        $lot = Lot::where('id', $streamId)->first();
        if ($lot) {
            $lot->is_live = 0;
            $lot->auction->auction_status = "Closed";
            $lot->auction->save();
            $lot->save();
        }


        $CollectionId = $lot->collection_id;
        $collection = MyCollection::find($CollectionId);
        if ($collection) {
            $collection->update(['is_auction' => 0]);
        }
        $offerData = DB::table('offers')->where('collection_id', $CollectionId)->get();
        if (!$offerData->isEmpty()) {
            DB::table('offers')->where('collection_id', $CollectionId)->delete();
        }
        $cart = DB::table('carts')->where('lot_id', $lot->id)->get();
        if (!$cart->isEmpty()) {
            DB::table('carts')->where('lot_id', $lot->id)->delete();
        }

        $sellerId = $lot->auction->user_id;
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


        return response()->json([
            'signature' => $signature,
            'signatureNonce' => $signatureNonce,
            'timestamp' => $timestamp,
        ], 200);

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
