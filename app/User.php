<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_notifications()
    {
        return $this->hasMany('App\UserNotification', 'user_id','id');
    }

    public function unreadNotifications()
    {
        return $this->user_notifications()
            ->where('status','unread')
            ->get();
    }

    public function companies()
    {
        return $this->hasMany('App\UserCompany', 'user_id','id');
    }

    public function queries()
    {
        return $this->hasMany('App\UserQuery', 'user_id', 'id');
    }
}
