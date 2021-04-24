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
            $product->quantity = DB::table('queries_products')
                ->where('query_id', $this->id)
                ->where('product_id', $product->id)
                ->count();;
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
            $total += ($product->price * $product->quantity);
        }

        return $total;
    }
}
