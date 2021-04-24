<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_notifications()
    {
        return $this->hasMany('App\UserNotification', 'user_id','id');
    }

    public function unreadNotifications()
    {
        return $this->user_notifications()
            ->where('status','unread')
            ->get();
    }

    public function companies()
    {
        return $this->hasMany('App\UserCompany', 'user_id','id');
    }

    public function queries()
    {
        $queries = $this->hasMany('App\UserQuery', 'user_id', 'id')->get();
        foreach ($queries as $query) {
            $query->products_count = $query->products_quantity();
        }

        return $queries;
    }

    public function orders()
    {
        $orders = $this->hasMany('App\Order','user_id','id')->get();

        foreach ($orders as $order) {
            $order->products_count = DB::table('orders_products')->where('order_id', $order->id)->count();
        }

        return $orders;
    }

    public function favorites()
    {
        return Product::whereIn('id', DB::table('user_favorites')
            ->select('product_id')
            ->where('user_id', $this->id)
            ->groupBy('product_id'))
            ->with('images')
            ->get();
    }

    public function reviews()
    {
        return $this->hasMany('App\UserReview', 'user_id', 'id');
    }

    public function suggestedReviews()
    {
        $suggested_order_products = DB::table('orders_products')
            ->whereIn('order_id', $this->orders()->pluck('id'))
            ->where('do_not_review', '=',0)
            ->whereNotIn('product_id', $this->reviews()->pluck('product_id'))
            ->get();
        $suggested_products = Product::whereIn('id',$suggested_order_products->pluck('product_id'))->with('images')->get();
        foreach ($suggested_products as $suggested_product) {
            $suggested_product->order_id = $suggested_order_products->pluck('order_id')[0];
        }

        return $suggested_products;
    }
}
