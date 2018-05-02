<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Checksession
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
        if (Auth::guard($guard)->check()&&Auth::guard()->user()!==null&&\Session::getId()!==Auth::guard()->user()->session_id) {
            Auth::guard()->logout();
             $request->session()->invalidate();
            return redirect()->back()->with('error', ['status'       => 206,
                                                      'statusText'   => 'account duplicate']);
        }

        return $next($request);
    }
}
