<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    protected $fillable = ['title', 'parent_id', 'url_title', 'description'];

    public function products() {
        return $this->hasMany('App\Product','category_id','id');
    }

    public function attributes()
    {
        return $this->hasMany('App\Attribute','category_id','id')->get();
    }

    public function attributesWithValues()
    {
        $attributes = Attribute::where('category_id',$this->id)->get();
        foreach ($attributes as $attribute) {
            $attribute['values'] = $attribute->values();
        }

        return $attributes;
    }

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function image()
    {
        return $this->hasOne('App\Image', 'imageable_id', 'id')->first();
    }

    public function additional_fields()
    {
        return (array)json_decode($this->additional_fields);
    }

    public static function getChildrenOnly()
    {
        return Category::where('parent_id', '<>', 0)->get();
    }

    public function parentCategory()
    {
        return Category::find($this->parent_id);
    }

    public function getChildrenCategories()
    {
        return Category::where('parent_id', $this->id)->get();
    }

    public function getCategoriesExceptSelf()
    {
        return Category::where('parent_id', '!=', $this->id)
            ->where('id', '!=', $this->id)
            ->get();
    }
}
