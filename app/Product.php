<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{


    protected $fillable = ['title', 'title_lat', 'code', 'description', 'category_id', 'price', 'discount', 'status', 'quantity', 'additional_info'];

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

    public function variants()
    {
        return $this->hasMany('App\ProductVariant');
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

        $selected_values = DB::table('attributes_values')
            ->join('products_attributes','products_attributes.attribute_value_id','=','attributes_values.id')
            ->where('products_attributes.product_id','=', $this->id)
            ->select(DB::raw('group_concat(attributes_values.id) as svalues'), 'attributes_values.attribute_id')
            ->groupBy('attributes_values.attribute_id')
            ->get();


        $product_attributes = DB::table('products_attributes')
            ->select('attribute_value_id')
            ->where('product_id',$this->id)
            ->get()->toArray();

        $icon_id=0;
        foreach ($attributes as $index => $attribute) {
            $attribute->values = array_values(array_unique(explode(',',$attribute->values)));
            foreach ($selected_values as $i => $values) {
                if($values->attribute_id == $attribute->id)
                {
                    $attribute->selected_values = explode(',',$values->svalues);
                }
            }
            if($attribute->type == 'icon')
            {
                $icon_id = DB::table('products_attributes')
                    ->select('attribute_value_id as value_id')
                    ->where('product_id',$this->id)
                    ->where('attribute_id',$attribute->id)
                    ->get()->pluck('value_id');
                $attribute->selected_values = $icon_id;

            }
        }
        return $attributes;
    }

    public function saved_attributes()
    {
        return DB::table('products_attributes')
            ->where('product_id', $this->id)
            ->get();
    }

    public function image()
    {
        return $this->MorphOne('App\Image','imageable');
    }

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function frontendAttributes()
    {
        return DB::table('products_attributes')
            ->join('attributes_values','attributes_values.attribute_id','=','products_attributes.attribute_id')
            ->join('attributes','attributes.id','=','products_attributes.attribute_id')
            ->select('attributes.name',DB::raw('group_concat(attributes_values.value)'))
            ->where('product_id',$this->id)
            ->groupBy('attributes_values.attribute_id')
            ->get();
    }

    public function height()
    {
        $height = DB::table('products_attributes')
            ->where('products_attributes.product_id',$this->id)
            ->join('attributes_values','products_attributes.attribute_value_id','=','attributes_values.id')
            ->where('attributes_values.attribute_id','=',42)
            ->get()->pluck('value')->toArray();

        return json_encode($height);
    }

    public function soil()
    {
        $height = DB::table('products_attributes')
            ->where('products_attributes.product_id',$this->id)
            ->join('attributes_values','products_attributes.attribute_value_id','=','attributes_values.id')
            ->where('attributes_values.attribute_id','=',46)
            ->get()->pluck('value')->toArray();

        return json_encode($height);
    }

    public function speed()
    {
        $speed = DB::table('products_attributes')
            ->where('products_attributes.product_id',$this->id)
            ->join('attributes_values','products_attributes.attribute_value_id','=','attributes_values.id')
            ->where('attributes_values.attribute_id','=',50)
            ->get()->pluck('value')->toArray();

        return json_encode($speed);
    }

    public function leafColor()
    {
        $leafColor = DB::table('products_attributes')
            ->where('products_attributes.product_id',$this->id)
            ->join('attributes_values','products_attributes.attribute_value_id','=','attributes_values.id')
            ->where('attributes_values.attribute_id','=',45)
            ->get()->pluck('value')->toArray();

        return json_encode($leafColor);
    }

    public function isFavorite()
    {
        $user = auth()->user();

        $fav = DB::table('user_favorites')
            ->where('user_id', $user->id)
            ->where('product->id', $this->id)
            ->select('id')
            ->first();
    }

    public function reviews()
    {
        return $this->hasMany('App\UserReview', 'product_id','id')->with('user');
    }

}
