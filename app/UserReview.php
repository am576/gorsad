<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReview extends Model
{
    protected $fillable = ['user_id', 'product_id', 'order_product_id', 'pluses', 'minuses', 'comment', 'rating'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
