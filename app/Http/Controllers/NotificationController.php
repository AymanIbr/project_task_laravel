<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request){

        //عشان يخلي التنبيهات مقروءة عند الضغط عليها
        $request->user()->notifications->markAsRead();


        $notifications = $request->user()->notifications;
        return response()->view('store.notifications.index',compact('notifications'));
    }
}
