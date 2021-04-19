<?php

namespace App\Http\Controllers;

use App\User;
use App\UserNotification;
use Illuminate\Http\Request;
use PDF;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showProfilePage(Request $request)
    {
        $user = User::where('id',auth()->user()->id)
            ->with(['user_notifications', 'companies'])
            ->first();

        $user->queries = $user->queries();
        $user->orders = $user->orders();

        $params_with = ['user' => $user];
        if(isset($request->all()['tab']))
        {
            $params_with['tabIndex'] = $request->all()['tab'];
        }

        return view('frontend/user.profile')->with($params_with);
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

    public function getQueryPdf(Request $request)
    {
        $user = auth()->user();
        $query = $user->queries()->where('id', $request->id)->first();

        return PDF::loadView('frontend.shop.query', compact('query'))->stream();

        return $pdf->download('query.pdf');
    }
}
