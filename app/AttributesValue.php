<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributesValue extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    public function icon()
    {
        return $this->hasOne('App\AttributeIcon', 'attribute_value_id');
    }
}
