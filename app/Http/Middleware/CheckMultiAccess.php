<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Common;
use CommonUser;
use DAO;
use Illuminate\Support\Facades\View;

class CheckMultiAccess
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
             if($request->ajax()){
                return response()->json(['status'       => 206,
                                 'statusText'   => 'account duplicate']);
             }else{
                return redirect()->back()->with('error', ['status'       => 206,
                                                      'statusText'   => 'account duplicate']);
             }
            
        }
        $data = Dao::call_stored_procedure('SPC_COM_DATA',array(Auth::user()!=NULL?Auth::user()->account_id:'',Auth::user()!=NULL?Auth::user()->account_div:'',Auth::user()!=NULL?Auth::user()->system_div:''));
        // var_dump($data);die;
        $data = CommonUser::encodeID($data);
        View::share('raw_data', $data);
        return $next($request);
    }
}
