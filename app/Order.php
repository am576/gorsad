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
            $product->custom_price = DB::table('orders_products')
                ->where('product_id', $product->id)
                ->get()
                ->pluck('custom_price')[0];

            $product->variants =  DB::table('product_variants')
                ->join('orders_products','product_variants.id','=','orders_products.variant_id')
                ->select('product_variants.*', DB::raw('count(*) as quantity'))
                ->where('order_id', $this->id)
                ->where('product_variants.product_id', $product->id)
                ->groupBy('product_variants.id')
                ->get();
        }

        return $products;
    }

    public function sumTotal()
    {
        $total = 0;

        $products = $this->products();
        $bonuses = UserQuery::where('id', $this->query_id)->first()->bonuses;

        foreach ($products as $product) {
            $price = 0;
            foreach ($product->variants as $variant) {
                $price += ($variant->price * $variant->quantity);
            }
            $total+= $price;
        }

        return $this->calcTotalWithBonuses($total, $bonuses);
    }


    public function user()
    {
        return User::where('id',$this->user_id)->first();
    }

    private function calcTotalWithBonuses($total, $bonuses)
    {
        return $total - intdiv($bonuses, 10);
    }
}
