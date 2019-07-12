<?php
namespace App\Modules\User\Controllers;

use App\Http\Controllers\ControllerUser;
use Auth;
use CommonUser;
use DAO;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Session;
use App\User;
use Hash;

class RegisterController extends ControllerUser
{

    protected $facebook_info;
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
    private $hashids;

    public function __construct()
    {
        $this->hashids = new Hashids();
    }

    public function getIndex(Request $request)
    {
        if(isset(Auth::user()->account_nm)){
            return redirect('/');
        }
        $this->facebook_info = (array) Session::get('accepted_data');
        $data = Dao::call_stored_procedure('SPC_REGISTER_LST1');
        $data = CommonUser::encodeID($data);
        if (isset($this->facebook_info['id'])) {
            $this->facebook_info['last_nm']  = substr($this->facebook_info['name'], strrpos($this->facebook_info['name'], ' '));
            $this->facebook_info['first_nm'] = substr($this->facebook_info['name'], 0, strpos($this->facebook_info['name'], ' '));
            return view('User::register.index')->with('default_data', $this->facebook_info)->with('data', $data);
        } else {
            return view('User::register.index')->with('data', $data);
        }
    }

    public function getData()
    {
        return view('User::register.index');
    }
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return void
     */

    public function create(Request $request)
    {
        $param                   = $request->all();
        $this->facebook_info = (array) Session::get('accepted_data');
        $param['post_tag'] = json_encode(is_array($param['post_tag']) ? $param['post_tag'] : array());
        $param['facebook_id']    = isset($this->facebook_info['id']) ? $this->facebook_info['id'] : '';
        $param['facebook_token'] = isset($this->facebook_info['token']) ? $this->facebook_info['token'] : '';
        $param['ip']             = $request->ip();
        if (CommonUser::checkValidate($request->all())['result']) {
            unset($param['password_confirm']);
            $param['password_create'] = Hash::make($param['password_create']);
            // var_dump($param);die;
            $data = Dao::call_stored_procedure('SPC_REGISTER_ACT1', $param);
            if ($data[0][0]['Data'] == 'Exception' || $data[0][0]['Data'] == 'EXCEPTION') {
                $result = array(
                    'status' => 208,
                    'data'   => $data[0],
                );
            } else if ($data[0][0]['Data'] != '') {
                $result = array(
                    'status' => 207,
                    'data'   => $data[0],
                );
            } else {
                $authUser = User::where('account_nm', $data[1][0]['account_nm'])->first();
                $remember_me = true;
                $year = time() + 31536000;
                $data   = Dao::call_stored_procedure('SPC_COMMON_ACCOUNT', array($authUser->user_id,$authUser->system_div));
                Session::put('logined_data',$data[0]);
                Session::put('social_token',$authUser->social_token);
                Auth::login($authUser, true);
                $authUser->session_id = \Session::getId();
                $authUser->save();
                Session::forget('accepted_data');
                $result = array(
                    'status'     => 200,
                    'statusText' => 'success',
                );
            }
        } else {
            $result = array('error' => CommonUser::checkValidate($request->all())['error'],
                'status'                => 201,
                'statusText'            => 'validate failed');
        }
        return response()->json($result);
    }

}
