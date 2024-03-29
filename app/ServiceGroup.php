<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceGroup extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function services()
    {
        return $this->hasMany('App\Service', 'group_id');
    }
}
