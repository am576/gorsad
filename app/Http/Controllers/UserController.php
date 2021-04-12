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
        $user = User::where('id',auth()->user()->id)->with(['user_notifications', 'companies'])->first();

        return view('frontend/user.profile')->with('user', $user);
    }
}
