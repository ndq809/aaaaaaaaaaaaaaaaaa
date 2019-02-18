<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Common;
use DAO;
use Illuminate\Cookie\CookieJar;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/master/general/g001';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'account_nm';
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        if(!session()->has('url.intended'))
        {
            session(['url.intended' => url()->previous()]);
        }
        return view('login');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        // $this->validator = common::checkValidate($request->all());
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
        $this->authenticated($request, $this->guard()->user());
        return response()->json(['status'       => 200,
                                 'statusText'   => 'login success',
                                 ]);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(\Illuminate\Http\Request $request,$user)
    {
        Auth::user()->session_id = \Session::getId();
        Auth::user()->save();
        $remember_me = $request->remember;
        $year = time() + 31536000;
        $data   = Dao::call_stored_procedure('SPC_COMMON_ACCOUNT', array(Auth::user()->user_id,Auth::user()->system_div));
        Session::put('logined_data',$data[0]);
        if ($remember_me == 'true') {
            setcookie('remember_me', $remember_me, $year);
            setcookie('account_nm', $request->account_nm, $year);
            setcookie('password', $request->password, $year);
        } else {
            setcookie('remember_me', NULL, $year);
            setcookie('account_nm', '', $year);
            setcookie('password', '', $year);
        }       
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        if (!common::checkValidate($request->all())['result']) {
            return response()->json(['error'        => common::checkValidate($request->all())['error'],
                                     'status'       => 201,
                                     'statusText'   => 'validate failed']);
        }
        return response()->json(['status'       => 202,
                                 'statusText'   => 'account do not matched']);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();
        if($request->ajax()){
            return response()->json(['status'       => 200,
                                 'statusText'   => 'logout success']);
        }else{
            return redirect('/master')->with('error', ['status'       => 210,
                                                          'statusText'   => 'access denied']);
        }
        
    }

}
