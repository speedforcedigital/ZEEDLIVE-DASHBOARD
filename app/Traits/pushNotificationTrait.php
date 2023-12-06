<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{User, GeneralSettings};
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

trait pushNotificationTrait
{

    public function sendNotification($token, $title, $body)
    {
        $messaging = app('firebase.messaging');
        $message = CloudMessage::withTarget('token', $token)
            ->withNotification(Notification::fromArray([
                'title' => $title,
                'body' => $body['notification_body'],
            ])) // Optional
            ->withData($body); // Optional

        $messaging->send($message);
    }

    public function sendbidNotification($token, $body)
    {
        $title = 'Bid';
        $this->sendNotification($token, $title, $body);
    }
}
