<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCompany extends Model
{
    protected $fillable = ['name', 'inn', 'kpp', 'address', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function queries()
    {
        
    }

    public function orders()
    {
        
    }

    public function notifications()
    {
        
    }

    public function favorites()
    {
        
    }
}
