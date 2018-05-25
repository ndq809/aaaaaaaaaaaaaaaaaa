<?php
namespace App\Modules\Master\Controllers\MasterData;

use App\Http\Controllers\Controller;
use DAO;
use Auth;
use Illuminate\Http\Request;
use Validator;
use SQLXML;
use Common;

class m004Controller extends Controller
{
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $data = Dao::call_stored_procedure('SPC_M004_FND1');
        return view('Master::masterdata.m004.index')->with('data',$data);
    }

    public function m004_addnew(Request $request)
    {
        $param = $request->all();
        $param['user_id']=Auth::user()->account_nm;
        $param['ip']=$request->ip();
        // var_dump($param);die;
        if (common::checkValidate($request)['result']) {
            $data = Dao::call_stored_procedure('SPC_M004_ACT1',$param);
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
                    'data' => $data[1],
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

    public function m004_delete(Request $request)
    {
        $data        = $request->all();
        $xml         = new SQLXML();
        $param['xml']    = $xml->xml($data);
        $param['user_id']=Auth::user()->account_nm;
        $param['ip']=$request->ip();
        $result_query       = DAO::call_stored_procedure("SPC_M004_ACT2", $param);
        if($result_query[0][0]['Id']==''){
            $result = array(
                'status' => 200,
                'statusText' => 'success',
            );
        }else{
            $result = array(
                'status' => 200,
                'error' => $result_query[0],
                'statusText' => 'failed',
            );
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
