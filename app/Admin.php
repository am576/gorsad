<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected  $guard = 'admin';

    protected $fillable = [
        'login', 'password'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];
}
