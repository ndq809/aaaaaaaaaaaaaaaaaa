<?php

namespace App\Http\Middleware;

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
        if (Auth::guard($guard)->check()) {
            if($request->ajax()){
                return response()->json(['status'       => 200,
                                     'statusText'   => 'login success']);
            }else{
                return redirect()->intended('/master/general/g001');
            }
            
        }
        return $next($request);
    }
}
