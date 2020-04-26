<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CustomAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$userType)
    {
        if(Auth::user() && Auth::user()->type === $userType){
            return $next($request);
        }
        elseif (Auth::user() && Auth::user()->type != $userType){
            return redirect()->back();
        }
        return redirect()->route('login');
    }
}
