<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserQuery extends Model
{
    protected $fillable = ['user_id', 'status', 'quote_file_link'];

    public function products()
    {
        $products = Product::whereIn('id', DB::table('queries_products')
            ->select('product_id')
            ->where('query_id', $this->id))
            ->get();

        foreach ($products as $product) {
            $product->variants =  DB::table('product_variants')
                ->join('queries_products','product_variants.id','=','queries_products.variant_id')
                ->select('product_variants.*', DB::raw('count(*) as quantity'))
                ->where('query_id', $this->id)
                ->where('product_variants.product_id', $product->id)
                ->groupBy('product_variants.id')
                ->get();
        }

        return $products;
    }

    public function products_quantity()
    {
        return DB::table('queries_products')
            ->where('query_id', $this->id)
            ->count();
    }

    public function user()
    {
        return User::where('id',$this->user_id)->first();
    }

    public function sumTotal()
    {
        $total = 0;

        $products = $this->products();

        foreach ($products as $product) {
            $price = 0;
            foreach ($product->variants as $variant) {
                $price += ($variant->price * $variant->quantity);
            }
            $total+= $price;
        }

        return $total;
    }
}
