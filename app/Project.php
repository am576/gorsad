<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Project extends Model
{
    protected $guarded = ['id'];

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function plants()
    {
        return Product::select('id', 'title AS text')->whereIn('id', DB::table('project_plants')->select('plant_id')->where('project_id', $this->id))->get();
    }
}
