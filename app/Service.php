<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = ['id'];

    public function group()
    {
        return $this->belongsTo('\App\ServiceGroup', 'group_id');
    }
}
