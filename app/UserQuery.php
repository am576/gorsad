<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserQuery extends Model
{
    protected $fillable = ['user_id', 'status', 'quote_file_link'];

    public function products()
    {
        return DB::table('queries_products')
            ->where('query_id', $this->id)
            ->groupBy('product_id')
            ->get();
    }

    public function products_quantity()
    {
        return DB::table('queries_products')
            ->where('query_id', $this->id)
            ->count();
    }
}
