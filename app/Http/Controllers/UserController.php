<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showProfilePage()
    {
        $user =  User::find(auth()->user()->id)->first()->with('user_notifications');
        return dd($user);
        return dd($user->with('user_notifications')->user_notifications());
    }
}
