<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    public $timestamps = false;

    protected $fillable  = ['name', 'value', 'category_id'];

    public function category()
    {
        return $this->belongsTo('App\Category','category_id');
    }

}
