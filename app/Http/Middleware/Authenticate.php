<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if(!Auth::check() OR Auth::guest() OR !Auth::user()->hasRole($role)) {
            flash('Please login.', 'danger');

            return redirect()->to('/login');
        }

        if($role == 'all') {
            return $next($request);
        }

        return $next($request);
    }
}
