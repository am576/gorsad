<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{


    protected $fillable = ['title', 'code', 'description', 'category_id', 'price', 'discount', 'status', 'quantity', 'additional_info'];

    public function category() {
        return $this->belongsTo('App\Category','category_id');
    }

    public static function statuses()
    {
        return ['Неактивный', 'Активный'];
    }

    public static function getStatusName($status)
    {
        $statuses = self::statuses();

        return $statuses[$status];
    }

    public function attributes()
    {
         return DB::table('attributes')
             ->whereIn('attributes.id', DB::table('products_attributes')->select('attribute_id')->where('product_id', $this->id))
             ->join('products_attributes','attributes.id','=','products_attributes.attribute_id')
             ->select('attributes.*', 'products_attributes.attribute_value_id as value_id', 'products_attributes.id as saved_id', 'products_attributes.attribute_id')
             ->where('products_attributes.product_id', '=',$this->id)
             ->get();
    }

    public function savedAttributes()
    {
        $attributes = DB::table('attributes')
            ->whereIn('attributes.id', DB::table('products_attributes')->select('attribute_id')->where('product_id', $this->id))
            ->join('products_attributes','products_attributes.attribute_id','=','attributes.id')
            ->join('attributes_values','attributes_values.attribute_id','=','products_attributes.attribute_id')
            ->select(DB::raw('group_concat(attributes_values.id) as `values`'),'attributes.*','products_attributes.attribute_id', 'products_attributes.id as saved_id')
            ->where('products_attributes.product_id', '=',$this->id)
            ->groupBy('products_attributes.attribute_id')->get();

        $attrs = DB::table('attributes_values')
            ->join('products_attributes','products_attributes.attribute_value_id','=','attributes_values.id')
            ->select('attributes_values.id', 'attributes_values.value', 'attributes_values.attribute_id')
            ->get();

        $selected_values = [];
        foreach ($attrs as $key => $value) {
            $selected_values[$value->attribute_id][] = [
              'attribute_id' => $value->attribute_id,
              'id' => $value->id,
              'value' => $value->value
            ];
        }
        foreach ($attributes as $index => $attribute) {
            $attribute->values = array_values(array_unique(explode(',',$attribute->values)));
            $attribute->selected_values = $selected_values[$attribute->id];
            if($attribute->type == 'icon')
            {
                $icon_id = DB::table('attribute_icons')
                    ->where('attribute_value_id','=', $selected_values[$attribute->id][0]['id'])
                    ->pluck('attribute_icons.id');
                $attribute->selected_values[0]['icon_id'] = $icon_id[0];

            }
        }
        return ($attributes);
    }

    public function saved_attributes()
    {
        return DB::table('products_attributes')
            ->where('product_id', $this->id)
            ->get();
    }

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }
}
