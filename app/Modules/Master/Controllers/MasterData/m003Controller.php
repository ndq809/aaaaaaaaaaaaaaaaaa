<?php
namespace App\Modules\Master\Controllers\MasterData;

use App\Http\Controllers\Controller;
use DAO;
use Auth;
use Illuminate\Http\Request;
use Validator;
use SQLXML;

class m003Controller extends Controller
{
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $data = Dao::call_stored_procedure('SPC_M003_FND1');
        return view('Master::masterdata.m003.index')->with('data_default', $data);
    }

    public function m003_list(Request $request)
    {
        $param = $request->all();
        $data  = Dao::call_stored_procedure('SPC_M003_LST1', $param);
        return view('Master::masterdata.m003.search')
            ->with('data', $data)
            ->with('paging', $data[1][0]);
    }

    public function m003_delete(Request $request)
    {
        $data        = $request->all();
        $xml         = new SQLXML();
        $param['xml']    = $xml->xml($data);
        $param['user_id']=Auth::user()->account_nm;
        $param['ip']=$request->ip();
        $result_query       = DAO::call_stored_procedure("SPC_M003_ACT2", $param);
       if($result_query[0][0]['Data'] == 'Exception' || $result_query[0][0]['Data'] == 'EXCEPTION'){
            $result = array(
                 'status' => 208,
                'error' => $result_query[0],
                'statusText' => 'failed',
            );
        }else{
            $result = array(
                'status' => 200,
                'statusText' => 'success',
            );
        }
        return response()->json($result);
    }

    public function m003_update(Request $request)
    {
        $data        = $request->all();
        $xml         = new SQLXML();
        $param['xml']    = $xml->xml($data);
        $param['user_id']=Auth::user()->account_nm;
        $param['ip']=$request->ip();
        $result_query       = DAO::call_stored_procedure("SPC_M003_ACT1", $param);
       if($result_query[0][0]['Data'] == 'Exception' || $result_query[0][0]['Data'] == 'EXCEPTION'){
            $result = array(
                 'status' => 208,
                'error' => $result_query[0],
                'statusText' => 'failed',
            );
        }else{
            $result = array(
                'status' => 200,
                'statusText' => 'success',
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
