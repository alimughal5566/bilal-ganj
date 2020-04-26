<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserTypeCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $userType, $secondUser = null)
    {
        if (Auth::user()) {
            $check = Auth::user()->type;
            if ($secondUser != null) {
                if ($check == $userType || $check == $secondUser) {
                    return $next($request);
                }
            } else {
                if ($check == $userType) {
                    return $next($request);
                }
            }
        }
        return redirect()->back();
    }
}
