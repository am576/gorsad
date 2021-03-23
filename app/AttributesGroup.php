<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributesGroup extends Model
{
    public $timestamps = false;

    protected $fillable = ['title'];

    public function attributes() {
        return $this->hasMany('App\Attribute','group_id','id');
    }
}
