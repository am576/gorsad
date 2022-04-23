<?php


namespace App\Utils;


use Illuminate\Support\Facades\Auth;

class User
{
    public static function getAuthUser()
    {
        if(Auth::check())
        {
            $user = \App\User::where('id', Auth::id())->with('companies','user_notifications')->first();
            $active_company = $user->active_company();
            $favorites = $user->favorites();
            $user->favorites = is_null($favorites) ? [] : $favorites;
            $user->active_company = is_null($active_company) ? [] : $active_company;

            return $user;
        }

        return null;
    }
}
