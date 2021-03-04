<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Common;
use DAO;
use Cookie;
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
    
    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            ['account_nm' => $request->account_nm, 'password' => $request->password, 'del_flg' => 0], $request->filled('remember')
        );
    } 

    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);
        if(Auth::user()->block_div!=''){
            $block_end = Auth::user()->block_end!=''?date("d/m/Y H:m:s", strtotime(Auth::user()->block_end)):'Vĩnh Viễn';
            $this->guard()->logout();
            $request->session()->invalidate();
            return response()->json(['status'      => 205,
                                    'block_time'   => $block_end,
                                    'statusText'   => 'account_blocked',
                                    ]);
        }else{
            $request->session()->regenerate();
            $this->authenticated($request, $this->guard()->user());
            return response()->json(['status'   => 200,
                                 'statusText'   => 'login success',
                                 ]);
        }
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
        $year = 527040; //1 year per minutes
        $data   = Dao::call_stored_procedure('SPC_COMMON_ACCOUNT', array(Auth::user()->user_id,Auth::user()->system_div));
        Session::put('logined_data',$data[0]);
        if ($remember_me == 'true') {
            Cookie::queue(Cookie::make('remember_me', $remember_me, $year));
            Cookie::queue(Cookie::make('account_nm', $request->account_nm, $year));
            Cookie::queue(Cookie::make('password', $request->password, $year));
        } else {
            Cookie::queue(Cookie::make('remember_me', NULL, $year));
            Cookie::queue(Cookie::make('account_nm', $request->account_nm, $year));
            Cookie::queue(Cookie::make('password', '', $year));
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

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );
        $message = \Lang::get('auth.throttle', ['seconds' => $seconds]);

       $errors = [$this->username() => $message];

       if ($request->expectsJson()) {
           return response()->json([   'seconds'    => $seconds,
                                       'status'   => 203,
                                       'statusText'   => 'locked']);
       }

       return redirect()->back()
           ->withInput($request->only($this->username(), 'remember'))
           ->withErrors($errors);
        throw ValidationException::withMessages([
            $this->username() => [Lang::get('auth.throttle', ['seconds' => $seconds])],
        ])->status(429);
    }

}
