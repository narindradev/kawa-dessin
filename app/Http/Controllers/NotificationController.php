<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function set_as_senn(Request $request)
    {
        if ($request->id) {
            $userUnreadNotification = auth()->user()->notifications()->where('id', $request->id)->orWhere('data->fake_id', $request->id)->first();
            if ($userUnreadNotification) {
                $userUnreadNotification->markAsRead();
            }
            die(json_encode(["success" => true ,"data" => view("notifications.template",["notification" =>$userUnreadNotification])->render()]) );
        }
    }
}
