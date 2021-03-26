<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IconSet extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }
}
