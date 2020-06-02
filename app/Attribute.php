<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Attribute extends Model
{
    public $timestamps = false;

    protected $fillable  = ['name', 'value', 'category_id'];

    public function category()
    {
        return $this->belongsTo('App\Category','category_id');
    }

    public function values()
    {
        return DB::table('attributes_values')
            ->select('value')
            ->where('attribute_id', $this->id)
            ->get();
    }

}
