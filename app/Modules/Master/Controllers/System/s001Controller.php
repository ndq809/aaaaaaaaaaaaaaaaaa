<?php
namespace App\Modules\Master\Controllers\System;

use App\Http\Controllers\Controller;
use Auth;
use DAO;
use Illuminate\Http\Request;
use SQLXML;
use Common;

class s001Controller extends Controller
{
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $data = Dao::call_stored_procedure('SPC_S001_FND1');
        return view('Master::system.s001.index')->with('data_default', $data);
    }

    public function s001_list(Request $request)
    {
        $param = $request->all();
        $data  = Dao::call_stored_procedure('SPC_S001_LST1', $param);
        // var_dump($data);die;
        return view('Master::system.s001.search')
            ->with('data', $data);
    }

    public function s001_update(Request $request)
    {
        
         if (common::checkValidate($request)['result']) {
            $permission           = $request->except('account_div');
            $xml                  = new SQLXML();
            $param['account_div'] = $request->only('account_div')['account_div'];
            $param['xml']         = $xml->xml($permission['data']);
            $param['user_id']     = Auth::user()->account_nm;
            $param['ip']          = $request->ip();
            $data = Dao::call_stored_procedure('SPC_S001_ACT1',$param);
            if ($data[0][0]['Data'] == 'Exception' || $data[0][0]['Data'] == 'EXCEPTION') {
                $result = array(
                    'status' => 208,
                    'data' => $data[0],
                );
            } else if ($data[0][0]['Data'] != '') {
                $result = array(
                    'status' => 207,
                    'data' => $data[0],
                );
            } else {
                $result = array(
                    'status' => 200,
                    'statusText' => 'success',
                );
            }
        } else {
           $result = array('error'    => common::checkValidate($request)['error'],
                'status'     => 201,
                'statusText' => 'validate failed');
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
