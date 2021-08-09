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
        //check blocked account
        if (Auth::guard($guard)->check()&&Auth::guard()->user()!==null&&Auth::guard()->user()->block_div!='') {
            $block_end = Auth::user()->block_end!=''?date("d/m/Y H:m:s", strtotime(Auth::user()->block_end)):'Vĩnh Viễn';
            Auth::guard()->logout();
             $request->session()->invalidate();
             if($request->ajax()){
                return response()->json(['status'      => 205,
                                        'data'   => $block_end,
                                        'statusText'   => 'account blocked']);
             }else{
                return redirect()->back()->with('error', ['status'     => 205,
                                                        'data'   => $block_end,
                                                        'statusText'   => 'account blocked']);
             }
            
        }
        //check multi access
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
        \Session::put('hidden_mission',$data[6][0]);
        return $next($request);
    }
}
