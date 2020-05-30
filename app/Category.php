<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    protected $fillable = ['title', 'parent_id', 'description'];

    public function products() {
        return $this->hasMany('App\Product','category_id','id');
    }

    public static function getChildrenOnly()
    {
        return Category::where('parent_id', '<>', 0)->get();
    }

    public function parentCategory()
    {
        return Category::find($this->parent_id);
    }

    public function getCategoriesExceptSelf()
    {
        return Category::where('parent_id', '!=', $this->id)
            ->where('id', '!=', $this->id)
            ->get();
    }
}
