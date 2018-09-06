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
            $permission = common::getPermission(Auth::user()->account_div,Auth::user()->system_div,URL::current());
            \Session::put('permission',$permission);

            //check permission to access screen
            if($permission['access_per']==0){
                $screen_id= explode("/",URL::current());
                $screen_id=$screen_id[Count($screen_id)-1];
                if($screen_id=='g001'){
                    return redirect('master/logout');
                }else{
                    $permission = common::getPermission(Auth::user()->account_div,Auth::user()->system_div,URL::previous());
                    if($permission['access_per']==0){
                        return redirect('master/general/g001')->with('error', ['status'       => 209,
                                                          'statusText'   => 'access denied']);
                    }
                }
                return redirect()->back()->with('error', ['status'       => 209,
                                                          'statusText'   => 'access denied']);
            }
        }
        return $next($request);
    }
}
