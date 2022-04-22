<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductsAttribute extends Model
{
    public function values()
    {
        return $this->hasMany(AttributesValue::class,'id','attribute_value_id');
    }
}
