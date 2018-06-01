<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Common;
use URL;

class CheckPermission
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
        if ($request->isMethod('get')) {
            $permission = common::getPermission(Auth::user()->account_div);
            \Session::put('permission',$permission);

            //check permission to access screen
            if($permission['access_per']==0){
                $screen_id= explode("/",URL::previous());
                $screen_id=$screen_id[Count($screen_id)-1];
                if($screen_id=='master'){
                    return redirect('/');
                }else
                return redirect()->back()->with('error', ['status'       => 209,
                                                          'statusText'   => 'access denied']);
            }
        }
        return $next($request);
    }
}
