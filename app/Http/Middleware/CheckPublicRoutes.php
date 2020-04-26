<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPublicRoutes
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
        if(Auth::user() && Auth::user()->type != 'user'){
            $type = Auth::user()->type;
            switch ($type){
                case 'admin':
                    return redirect()->route('displayAdmin');
                    break;
                case 'bgshop':
                    return redirect()->route('vendorPanel');
                    break;
                case 'agent':
                    return redirect()->route('agentPanel');
                    break;
                case 'rider':
                    return redirect()->route('riderPanel');
                    break;
                default:
                    return redirect()->back();
                    break;
            }

        }
        return $next($request);
    }
}
