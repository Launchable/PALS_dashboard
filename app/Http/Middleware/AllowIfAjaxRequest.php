<?php

namespace App\Http\Middleware;

use Closure;

class AllowIfAjaxRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->ajax())  {
            return false;
        }
        
        return $next($request);
    }
}
