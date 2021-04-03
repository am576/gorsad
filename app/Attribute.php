<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Attribute extends Model
{
    public $timestamps = false;

    protected $fillable  = ['name', 'value', 'category_id', 'group_id', 'type'];


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
        return DB::table('attributes_values')
            ->where('attribute_id', $this->id)
            ->get();
    }

    public function icons()
    {
        return DB::table('attribute_icons')
            ->where('attribute_id', $this->id)
            ->get();
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
        $attributes = Attribute::where('use_for_filter',1)
            ->get();

        foreach ($attributes as $attribute) {
            $values = [];
            foreach ($attribute->values() as $i => $value) {
                array_push($values , [
                    'id' => $value->id,
                    'value' => $value->value
                ]);
                if($attribute->type == 'icon')
                {
                    $image_id = DB::table('attribute_icons')
                        ->where('attribute_value_id', $value->id)->get()->pluck('image_id');
                    $image = Image::find($image_id)->first();
                    $values[$i]['icon'] = $image->icon;

                }
            }
            $attribute->values = $values;
        }

        return $attributes;
    }

    public function icon()
    {
        return $this->morphOne('App\Image', 'imageable');
    }

}
