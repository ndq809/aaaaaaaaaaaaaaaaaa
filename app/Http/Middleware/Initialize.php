<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Common;

class Initialize
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
        common::getMessage();
        if(isset(Auth::user()->account_div)){
             $menu = common::getMenu(Auth::user()->account_div);
            \Session::put('menu',$menu);
        }
       
        return $next($request);
    }
}
