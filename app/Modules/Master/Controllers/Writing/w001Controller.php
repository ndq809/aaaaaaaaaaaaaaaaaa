<?php 
namespace App\Modules\Master\Controllers\Writing;

use App\Http\Controllers\Controller;
use DAO;
use Auth;
use Illuminate\Http\Request;
use Validator;
use SQLXML;

class w001Controller extends Controller
{
     /**
     * Show the application index.
     * @author mail@ans-asia.com 
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
     public function getIndex()
     {
         $data = Dao::call_stored_procedure('SPC_W001_LST1');
          return view('Master::writing.w001.index')->with('data_default',$data);
     }

      public function w001_list(Request $request)
    {
        $param = $request->all();
        $param['record_div'] = (int)$param['record_div'] - 1;
        $data  = Dao::call_stored_procedure('SPC_W001_LST2', $param);
        return view('Master::writing.w001.search')
            ->with('data', $data)
            ->with('paging', $data[1][0]);
    }

    public function w001_delete(Request $request)
    {
        $data        = $request->all();
        $xml         = new SQLXML();
        $param['xml']    = $xml->xml($data);
        $param['user_id']=Auth::user()->account_id;
        $param['ip']=$request->ip();
        $result_query       = DAO::call_stored_procedure("SPC_W001_ACT1", $param);
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

    public function w001_confirm(Request $request)
    {
        $data        = $request->all();
        $xml         = new SQLXML();
        $param['xml']    = $xml->xml($data);
        $param['user_id']=Auth::user()->account_id;
        $param['ip']=$request->ip();
        $result_query       = DAO::call_stored_procedure("SPC_W001_ACT2", $param);
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

    public function w001_public(Request $request)
    {
        $data        = $request->all();
        $xml         = new SQLXML();
        $param['xml']    = $xml->xml($data);
        $param['user_id']=Auth::user()->account_id;
        $param['ip']=$request->ip();
        $result_query       = DAO::call_stored_procedure("SPC_W001_ACT3", $param);
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

    public function w001_reset(Request $request)
    {
        $data        = $request->all();
        $xml         = new SQLXML();
        $param['xml']    = $xml->xml($data);
        $param['user_id']=Auth::user()->account_id;
        $param['ip']=$request->ip();
        $result_query       = DAO::call_stored_procedure("SPC_W001_ACT4", $param);
       if($result_query[0][0]['Data'] == 'Exception' || $result_query[0][0]['Data'] == 'EXCEPTION'){
            $result = array(
                 'status' => 208,
                'error' => $result_query[0],
                'statusText' => 'failed',
            );
        }else if ($result_query[0][0]['Data'] != '') {
            $result = array(
                'status' => 207,
                'data'   => $result_query[0],
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