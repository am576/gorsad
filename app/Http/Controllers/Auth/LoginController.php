<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        if(!session()->has('url.intended'))
        {
            session(['url.intended' => url()->previous()]);
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            $arrValid = [
                'email' => 'required',
                'password' => 'required',
            ];
            $request->validate($arrValid,
                [
                    'email.required' => 'Пожалуйста, укажите Email',
                    'password.required' => 'Пожалуйста, укажите пароль',
                ]
            );

            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $arrResponse = array(
                    'msg' => 'OK',
                    'user' => $user,
                    'statusCode' => 200,
                );
                $code = 200;
            }
            else {
                $arrResponse = array(
                    'errors' => [
                       'login' => ['Неверно указаны данные для входа'],
                        'statusCode' => 401
                    ]
                );
                $code = 200;
            }
        }
        catch (\Illuminate\Validation\ValidationException $e )
        {
            $arrResponse = array(
                'errors' => $e->errors(),
                'statusCode' => $e->status,
            );
            $code = 200;
        }
        catch (\Exception $ex) {

            $arrResponse = array(
                'result' => 0,
                'reason' => $ex->getMessage(),
                'data' => array(),
                'statusCode' => $ex->status,
            );
            $code = 200;

        } finally {

            return response()->json($arrResponse, $code);

        }
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        Session::flush();
        return redirect()->back();
    }

}
