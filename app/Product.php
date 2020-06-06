<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{


    protected $fillable = ['title', 'code', 'description', 'category_id', 'price', 'discount', 'status', 'quantity'];

    public function category() {
        return $this->belongsTo('App\Category','category_id');
    }

    public static function statuses()
    {
        return ['Неактивный', 'Активный'];
    }

    public static function getStatusName($status)
    {
        $statuses = self::statuses();

        return $statuses[$status];
    }

    public function attributes()
    {
        $attributes = DB::table('attributes')->
            whereIn('id', DB::table('products_attributes')->select('attribute_id')->where('id', $this->id))
            ->get();
        dd($attributes);

        $values=
    }
}
