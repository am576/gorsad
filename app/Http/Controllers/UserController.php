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
            $notification = UserNotification::where('user_id',auth()->user()->id)->where('id', $request->id)->first();
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

    public function getOrderPdf(Request $request)
    {
        $user = auth()->user();
        $order = $user->orders()->where('id', $request->id)->first();

        return PDF::loadView('frontend.shop.order', compact('order'))->stream();

        return $pdf->download('order.pdf');
    }

    public function setCompanyActive(Request $request)
    {
        $user = auth()->user();
        $user->companies()->update(['is_active' => 0]);
        $company = $user->companies()->where('id', $request->company_id)->update(['is_active' => 1]);
    }

    public function setCompaniesNotActive()
    {
        $user = auth()->user();
        $user->companies()->update(['is_active' => 0]);
    }
}
