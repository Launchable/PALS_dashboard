<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param  string|null              $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        /*if (Auth::guard($guard)->check()) {
            return redirect('/home');
        }*/

        if (Auth::guard($guard)->check() AND Auth::user()->role != 'registered')
            return redirect("/" . Auth::user()->role . "/dashboard");
        else if (Auth::guard($guard)->check() AND Auth::user()->role == 'registered')
            return redirect()->route('registered.home');
        return $next($request);
    }
}





