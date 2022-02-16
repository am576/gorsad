<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = ['id'];

    public function group()
    {
        return $this->hasOne('App\ServiceGroup', 'id', 'group_id')->first();
    }

    public function setViewAttribute($value)
    {
        $this->attributes['view'] = 'admin.services.static.' . $value;
    }
}
