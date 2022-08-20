<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $guarded = [];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function deleteImages()
    {
        if (Storage::disk('images')->exists($this->icon)) {
            Storage::disk('images')->delete($this->icon);
        }
        if (Storage::disk('images')->exists($this->small)) {
            Storage::disk('images')->delete($this->small);
        }
        if (Storage::disk('images')->exists($this->medium)) {
            Storage::disk('images')->delete($this->medium);
        }
    }
}
