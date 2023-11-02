<?php
//require 'vendor/autoload.php';
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use ZEGO\ZegoErrorCodes;
use ZEGO\ZegoServerAssistant;

class Zego extends Controller
{
    public function getToken($productID)
    {
//        dd(auth()->user()->id);
        $appId = 1553886775;
        $userId = '195';
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


}
