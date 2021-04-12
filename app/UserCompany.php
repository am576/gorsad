<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCompany extends Model
{
    protected $fillable = ['name', 'inn', 'kpp', 'address', 'user_id'];
}
