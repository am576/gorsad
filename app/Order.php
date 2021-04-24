<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $guarded = ['id'];

    public function products()
    {
        $products =  Product::whereIn('id',
            DB::table('orders_products')->select('product_id')->where('order_id', $this->id))
            ->get();

        foreach ($products as $product) {
            $product->quantity = DB::table('orders_products')
                ->where('order_id', $this->id)
                ->where('product_id', $product->id)
                ->count();
            $product->custom_name = DB::table('orders_products')
                ->where('product_id', $product->id)
                ->get()
                ->pluck('custom_name')[0];
        }

        return $products;
    }

    public function sumTotal()
    {
        $total = 0;

        $products = $this->products();

        foreach ($products as $product) {
            $total += ($product->price * $product->quantity);
        }

        return $total;
    }

    public function user()
    {
        return User::where('id',$this->user_id)->first();
    }
}
