<?php
//require 'vendor/autoload.php';
namespace App\Http\Controllers;

use App\Models\Lot;
use Illuminate\Http\Request;
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
        $timestamp = time();

        $signatureData = $this->generateSignature($appId, $serverSecret, $timestamp);
        $signatureNonce = $signatureData['signatureNonce'];
        $signature = $signatureData['signature'];

        $streamId = $productID;
        $lot = Lot::where('id', $streamId)->first();
//        if ($lot) {
//            $lot->is_live = 0;
//            $lot->auction->auction_status = "Closed";
//            $lot->auction->save();
//            $lot->save();
//        }

        return response()->json([
            'signature' => $signature,
            'signatureNonce' => $signatureNonce,
        ], 200);

    }


}
