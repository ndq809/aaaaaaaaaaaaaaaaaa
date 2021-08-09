<?php
namespace App\Modules\Master\Controllers\General;

use App\Http\Controllers\Controller;
use Auth;
use common;
use DAO;
use Hash;
use Illuminate\Http\Request;
use Session;

class g001Controller extends Controller
{
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $data = Dao::call_stored_procedure('SPC_G001_LST1', array('account_id'=>Auth::user()->account_id,'account_div'=>Auth::user()->account_div));
        return view('Master::general.g001.index')->with('data', $data);
    }

    public function g001_updateProfile(Request $request)
    {
        $param            = $request->all();
        $param['user_id'] = Auth::user()->account_id;
        $param['ip']      = $request->ip();
        $result_query     = DAO::call_stored_procedure("SPC_G001_ACT1", $param);
        if ($result_query[0][0]['Data'] == 'Exception' || $result_query[0][0]['Data'] == 'EXCEPTION') {
            $result = array(
                'status'     => 208,
                'error'      => $result_query[0],
                'statusText' => 'failed',
            );
        } else if ($result_query[0][0]['Data'] != '') {
            $result = array(
                'status' => 207,
                'data'   => $result_query[0],
            );
        } else {
            $data = Dao::call_stored_procedure('SPC_COMMON_ACCOUNT', array(Auth::user()->user_id, Auth::user()->system_div));
            Session::put('logined_data', $data[0]);
            $result = array(
                'status'     => 200,
                'statusText' => 'success',
                'avarta'     => $data[0][0]['avarta'],
            );
        }
        return response()->json($result);
    }

    public function g001_changepass(Request $request)
    {
        $param            = $request->all();
        $param['user_id'] = Auth::user()->account_id;
        $param['ip']      = $request->ip();
        if (common::checkValidate($request->all())['result']) {
            unset($param['old_password']);
            unset($param['password_confirm']);
            $param['password'] = Hash::make($param['password']);
            $result_query      = DAO::call_stored_procedure("SPC_G001_ACT2", $param);
            if ($result_query[0][0]['Data'] == 'Exception' || $result_query[0][0]['Data'] == 'EXCEPTION') {
                $result = array(
                    'status'     => 208,
                    'error'      => $result_query[0],
                    'statusText' => 'failed',
                );
            } else if ($result_query[0][0]['Data'] != '') {
                $result = array(
                    'status' => 207,
                    'data'   => $result_query[0],
                );
            } else {
                $result = array(
                    'status'     => 200,
                    'statusText' => 'success',
                );
            }
        } else {
            $result = array('error' => common::checkValidate($request->all())['error'],
                'status'                => 201,
                'statusText'            => 'validate failed');
        }
        return response()->json($result);
    }

    public function g001_statistic(Request $request)
    {
        $param            = $request->all();
        $param['user_id'] = Auth::user()->account_id;
        $param['user_div'] = Auth::user()->account_div;
        $result_query     = DAO::call_stored_procedure("SPC_G001_LST2", $param);
        return view('Master::general.g001.search')
            ->with('data', $result_query[0]);
    }

    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return void
     */

}
