<?php

namespace App\Http\Controllers;

use App\User;
use App\UserNotification;
use App\UserReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $user->favorites = $user->favorites();
        $user->suggested_products = $user->suggestedReviews();
        $user->bonuses = $user->bonusesTotal();
        $user->bonuses_history = $user->bonusesHistory();

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

        return  PDF::loadView('frontend.shop.query', compact('query'))->stream();
//        $pdf = PDF::loadView('frontend.shop.query', compact('query'));
//        return $pdf->download('query.pdf');
    }

    public function getOrderPdf(Request $request)
    {
        $user = auth()->user();
        $order = $user->orders()->where('id', $request->id)->first();

        return PDF::loadView('frontend.shop.order', compact('order'))->stream();

//        $pdf = PDF::loadView('frontend.shop.order', compact('order'));
//        return $pdf->download('order.pdf');
    }

    public function setCompanyActive(Request $request)
    {
        $user = auth()->user();
        $user->companies()->update(['is_active' => 0]);
        $user->companies()->where('id', $request->company_id)->update(['is_active' => 1]);
    }

    public function setCompaniesNotActive()
    {
        $user = auth()->user();
        $user->companies()->update(['is_active' => 0]);
    }

    public function getUserFavorites()
    {
        $user = auth()->user();
        return $user->favorites()->pluck('id');
    }

    public function toggleProductFavorite(Request $request)
    {
        $user = auth()->user();
        $product_id = $request->product_id;

        $res = DB::table('user_favorites')
            ->where('user_id', $user->id)
            ->where('product_id', $product_id)
            ->get();

        if(count($res))
        {
            DB::table('user_favorites')
                ->where('user_id', $user->id)
                ->where('product_id', $product_id)
                ->delete();
        }
        else
        {
            DB::table('user_favorites')
                ->insert([
                   'user_id' => $user->id,
                   'product_id' => $product_id
                ]);
        }
    }

    public function postReview(Request $request)
    {
        $user = auth()->user();
        $review = new UserReview([
           'user_id' => $user->id,
           'product_id' => $request->product_id,
           'order_id' => $request->order_id,
           'pluses' => $request->pluses,
           'minuses' => $request->minuses,
           'comment' => $request->comment,
        ]);

        if($review->save())
        {
            $order_product = DB::table('orders_products')
                ->where('order_id', $request->order_id)
                ->where('product_id', $request->product_id)
                ->update([
                    'do_not_review' => 1
                ]);
        }
    }

    public function doNotReview(Request $request)
    {
        $user = auth()->user();
        $product_id = $request->product_id;
        $order_products = DB::table('orders_products')
            ->whereIn('order_id', $user->orders()->pluck('id'))
            ->where('product_id', $product_id)
            ->update([
               'do_not_review' => 1
            ]);
    }
}
