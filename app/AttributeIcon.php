<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeIcon extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    public function image()
    {
        return $this->hasOne('App\Image','id','image_id');
    }
}
