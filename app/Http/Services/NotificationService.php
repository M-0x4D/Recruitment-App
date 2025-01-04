<?php

namespace App\Http\Services;

use App\Models\Notification;

class NotificationService{
    static function createNotification($user,$message, $params = array()){
        Notification::create([
            'message' => $message,
            'user_id'=> $user->id,
        ]);
    }
}
