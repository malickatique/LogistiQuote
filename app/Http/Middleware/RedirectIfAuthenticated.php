<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // if (Auth::guard($guard)->check()) {
        //     return redirect(RouteServiceProvider::HOME);
        // }

        if (Auth::guard($guard)->check()) 
        {
            if(session('intended_url') != "" && session('origin') != "" )
                return redirect(url('get_quote_step2'));
                
            if(Auth::user()->role == 'admin')
            {
                return redirect('/admin');
            }
            else if(Auth::user()->role == 'user')
            {
                return redirect();
            }
            else if(Auth::user()->role == 'vendor')
            {
                return redirect('/ven');
            }
        }
        return $next($request);
    }
}
