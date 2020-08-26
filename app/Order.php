<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $guarded = ['id'];

    public function products()
    {
        return Product::whereIn('id',
            DB::table('orders_products')->select('product_id')->where('order_id', $this->id))
            ->get();
    }
}
