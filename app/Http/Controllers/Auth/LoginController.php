<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $creadentials = $request->only('email', 'password');

        if(! auth()->attempt($creadentials)){
            return redirect()->route('login')->with('error', 'Email-Address and Password Are Wrong');
        }

        if (auth()->user()->position == 1) {
            return redirect()->route('admin.home');
        }
        elseif (auth()->user()->position == 2) {
            return redirect()->route('front-desk.home');
        }
        elseif (auth()->user()->position == 3) {
            return redirect()->route('housekeeper.home');
        }

        return redirect()->route('home');
    }
}
