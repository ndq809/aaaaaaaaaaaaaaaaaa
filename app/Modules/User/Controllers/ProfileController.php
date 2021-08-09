<?php
namespace App\Modules\User\Controllers;

use App\Http\Controllers\ControllerUser;
use App\User;
use Auth;
use CommonUser;
use DAO;
use Hash;
use Illuminate\Http\Request;
use Session;

class ProfileController extends ControllerUser
{
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        if (!isset(Auth::User()->account_nm)) {
            Session::put('show_login', 1);
            return redirect()->route('home');
        }
        $data = Dao::call_stored_procedure('SPC_PROFILE_LST1', array(Auth::User()->account_id));
        $data = CommonUser::encodeID($data);
        return view('User::profile.index')->with('data', $data);
    }

    public function getData()
    {
        return view('User::profile.index');
    }

    public function updateInfor(Request $request)
    {
        $param                   = $request->all();
        $this->facebook_info     = (array) Session::get('accepted_data');
        $param['post_tag']       = json_encode(is_array($param['post_tag']) ? $param['post_tag'] : array());
        $param['facebook_id']    = isset($this->facebook_info['id']) ? $this->facebook_info['id'] : Auth::user()->social_id;
        $param['facebook_token'] = isset($this->facebook_info['token']) ? $this->facebook_info['token'] : Auth::user()->social_token;
        $param['user_id']        = isset(Auth::user()->account_id) ? Auth::user()->account_id : '';
        $param['ip']             = $request->ip();
        if (CommonUser::checkValidate($request->all())['result']) {
            $data = Dao::call_stored_procedure('SPC_PROFILE_ACT1', $param);
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
                Session::forget('accepted_data');
                $data = Dao::call_stored_procedure('SPC_COMMON_ACCOUNT', array(Auth::user()->user_id, Auth::user()->system_div));
                Session::put('logined_data', $data[0]);
                $result = array(
                    'status'     => 200,
                    'statusText' => 'success',
                    'avarta'     => $data[0][0]['avarta'],
                );
            }
        } else {
            $result = array('error' => CommonUser::checkValidate($request->all())['error'],
                'status'                => 201,
                'statusText'            => 'validate failed');
        }
        return response()->json($result);
    }

    public function updatePass(Request $request)
    {
        $param = $request->all();
        if (CommonUser::checkValidate($request->all())['result'] && Hash::check($param['old_password'], Auth::user()->password)) {
            unset($param['password_reconfirm']);
            unset($param['old_password']);
            $param['password_recreate'] = Hash::make($param['password_recreate']);
            $param['user_id']         = isset(Auth::user()->account_id) ? Auth::user()->account_id : '';
            $param['ip']              = $request->ip();
            $data                     = Dao::call_stored_procedure('SPC_PROFILE_ACT2', $param);
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

    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return void
     */

}
