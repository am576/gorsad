<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{


    protected $fillable = ['title', 'code', 'description', 'category_id', 'price', 'discount', 'status', 'quantity'];

    public function category() {
        return $this->belongsTo('App\Category');
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
}
