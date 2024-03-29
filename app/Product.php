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
        $pa = ProductsAttribute::where('product_id',$this->id)
            ->select('attribute_value_id')
            ->get()
            ->map(function($item) {
                return $item['attribute_value_id'];
            })->toArray();

        $a = Attribute::with(['values' => function($query) use ($pa){
            $query->whereIn('id',$pa);
        }, 'values.icon.image:icon,id'])
            ->get()
            ->reject(function($attribute) {
                return count($attribute->relations['values']) == 0;
            });

        return array_values($a->toArray());
    }

    public function variants()
    {
        return $this->hasMany('App\ProductVariant');
    }

    public function productAttributes()
    {
        $pa = ProductsAttribute::where('product_id',$this->id)
            ->select('attribute_value_id')
            ->get()
            ->map(function($item) {
                return $item['attribute_value_id'];
            })->toArray();

        $a = Attribute::with(['values' => function($query) use ($pa){
            $query->whereIn('id',$pa);
        }, 'values.icon.image:icon,id'])
            ->with('attribute_values.icon.image:icon,id')
            ->get()
            ->reject(function($attribute) {
                return count($attribute->relations['values']) == 0;
            });

        return json_encode(array_values($a->toArray()));
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

    public function image()
    {
        return $this->morphOne('App\Image','imageable')->withDefault(function() {
            return new Image([
                'icon' => config('product.noimage.path').config('product.noimage.icon'),
                'small' => config('product.noimage.path').config('product.noimage.small'),
                'medium' => config('product.noimage.path').config('product.noimage.medium'),
                'large' => config('product.noimage.path').config('product.noimage.large'),
            ]);
        });
    }

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function reviews()
    {
        return $this->hasMany('App\UserReview', 'product_id','id')->with('user');
    }

    public static function usedAttributeValues()
    {
        return ProductsAttribute::select('attribute_value_id')->groupBy('attribute_value_id')->get()->pluck('attribute_value_id')->toArray();
    }

    public static function getAndPaginateActiveProducts()
    {
        return Product::with('image')
            ->where('status', '=', 1)
            ->paginate(config('shop.paginate'));
    }
}
