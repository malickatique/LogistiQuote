<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function authenticated(Request $request, $user)
    {
        if(session('pending_task') != "" && session('origin') != "" && session('form_data') != "")
        {
            session()->forget('pending_task');
            return redirect(route('store_pending_form'));
        }
    }
    
    protected function redirectTo()
    {
        if(Auth::user()->role == 'admin')
        {
            return '/admin';
        }
        else if(Auth::user()->role == 'user')
        {
            return '/user';
        }
        else if(Auth::user()->role == 'vendor')
        {
            return '/ven';
        }
    }
}
