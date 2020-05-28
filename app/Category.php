<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    protected $fillable = ['title', 'parent_id', 'description'];

    public function products() {
        return $this->hasMany('App\Product');
    }

    public static function getChildrenOnly()
    {
        return Category::where('parent_id', '<>', 0)->get();
    }

    public function parentCategory()
    {
        return Category::find($this->parent_id);
    }
}
