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
        $values =  DB::table('attributes_values')
            ->where('attribute_id', $this->id)
            ->get();
        foreach ($values as $value) {
            $value->image = DB::table('attribute_icons')
                ->where('attribute_value_id', $value->id)
                ->join('images', 'images.id','=','image_id')
                ->select('images.*','attribute_icons.id as icon_id')
                ->first();
        }
        return $values;
    }

    public function icons()
    {
        return DB::table('attribute_icons')
            ->where('attribute_id', $this->id)
            ->join('images', 'images.id','=','image_id')
            ->select('images.*')
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
        $attributes = Attribute::where('use_for_filter',1)
            ->get();

        return self::getAttributesWithValues($attributes);
    }

    public function shopFilterAttributes()
    {
        $attributes_by_group = Attribute::all()
            ->groupBy('group_id');

        $attributes = [];
        foreach ($attributes_by_group as $group_id => $group_attributes) {
            array_push($attributes,
                [
                    'group_id' => $group_id,
                    'group_name' => AttributesGroup::find($group_id)->title,
                    'attributes' => self::getAttributesWithValues($group_attributes)
                ]
            );
        }

        return json_encode($attributes);
    }

    public function icon()
    {
        return $this->morphOne('App\Image', 'imageable');
    }


    private static function getAttributesWithValues($attributes)
    {
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



}
