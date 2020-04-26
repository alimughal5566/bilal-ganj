<?php

namespace App\Http\Middleware;

use Closure;
use const http\Client\Curl\AUTH_ANY;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
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
        if(Auth::user() && Auth::user()->type==='user'){
            return $next($request);
        }
        return redirect()->back();
    }
}
