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
         return DB::table('attributes')
             ->whereIn('attributes.id', DB::table('products_attributes')->select('attribute_id')->where('product_id', $this->id))
             ->join('products_attributes','attributes.id','=','products_attributes.attribute_id')
             ->select('attributes.*', 'products_attributes.attribute_value_id as value_id', 'products_attributes.id as saved_id')
             ->get();
    }

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }
}
