<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    protected $guarded = ['id'];

    public function service()
    {
        return $this->hasOne('App\Service', 'id', 'service_id');
    }
}
