<?php

namespace App\Http\Controllers;

use App\User;
use App\UserNotification;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showProfilePage()
    {
        $user = User::where('id',auth()->user()->id)
            ->with(['user_notifications', 'companies'])
            ->first();

        $user->queries = $user->queries();
        return view('frontend/user.profile')->with('user', $user);
    }

    public function readNotification(Request $request)
    {
        if(isset($request->id))
        {
            $notification = UserNotification::findOrFail($request->id);
            if($notification->status == 'unread')
            {
                $notification->status = 'read';
                $notification->save();
            }
        }
    }

    public function readAllNotifications()
    {
        UserNotification::where('user_id',auth()->user()->id)
            ->where('status','unread')
            ->update(['status' => 'read']);
    }
}
