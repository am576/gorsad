<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Attribute extends Model
{
    public $timestamps = false;

    protected $fillable  = ['name', 'value', 'ext_value', 'category_id', 'group_id', 'type'];


    public function category()
    {
        return $this->belongsTo('App\Category','category_id');
    }

    public function group()
    {
        return $this->belongsTo('App\AttributesGroup', 'group_id');
    }

    public function values()
    {
        return $this->hasMany('App\AttributesValue');
    }

    public function icons()
    {
        /*return DB::table('attribute_icons')
            ->where('attribute_id', $this->id)
            ->join('images', 'images.id','=','image_id')
            ->select('images.*')
            ->get();*/

        return DB::table('attributes_values')
            ->where('attributes_values.attribute_id', $this->id)
            ->join('attribute_icons', 'attributes_values.id','=','attribute_icons.attribute_value_id')
            ->join('images', 'images.id','=','image_id')
            ->select('images.icon','attributes_values.value','attributes_values.id as id', 'attribute_icons.id as attribute_icon_id', 'images.id as image_id')
            ->get();
    }

    public function iconValues()
    {
        return DB::table('attributes_values')
            ->where('attributes_values.attribute_id', $this->id)
            ->join('attribute_icons', 'attributes_values.id','=','attribute_icons.attribute_value_id')
            ->join('images', 'images.id','=','image_id')
            ->select('images.icon','attributes_values.value','attributes_values.id')
            ->get();
    }

    public function iconset()
    {
        return DB::table('attribute_icons')
            ->where('attribute_id', $this->id)
            ->first()->iconset_id;
    }

    public function valuesLabels()
    {
        $labels = [];

        foreach ($this->values() as $value) {
            array_push($labels, $value->value);
        }

        return $labels;
    }

    public static function smallFilterAttributes()
    {
        return Attribute::where('use_for_filter',1)
            ->with('values')
            ->get();
    }

    public function icon()
    {
        return $this->morphOne('App\Image', 'imageable');
    }
}
