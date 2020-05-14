<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{

    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {

        // Validate the form data
        $this->validate($request, [
            'login'   => 'required',
            'password' => 'required'
        ]);

        // Attempt to log the user in
        if (Auth::guard('admin')->attempt(['login' => $request->login, 'password' => $request->password], $request->remember)) {
            // if successful, then redirect to their intended location
            return redirect()->intended(route('admin.dashboard'));
        }
        // if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('login', 'remember'));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }
}
