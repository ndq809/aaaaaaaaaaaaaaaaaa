<?php 
namespace App\Modules\Master\Controllers\General;
use App\Http\Controllers\Controller;
use DAO;
use Auth;
use Illuminate\Http\Request;
use Validator;
use Common;
use Hash;

class g006Controller extends Controller
{
	/**
     * Show the application index.
     * @author mail@ans-asia.com 
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
	public function getIndex()
	{
		$data = Dao::call_stored_procedure('SPC_COM_M999_INQ1',array(7));
        return view('Master::general.g006.index')->with('data',$data);
	}

       public function g006_addnew(Request $request)
    {
        $param = $request->all();
        $param['user_id']=Auth::user()->account_id;
        $param['ip']=$request->ip();
        if (common::checkValidate($request->all())['result']) {
            $data = Dao::call_stored_procedure('SPC_G006_ACT1',$param);
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
           $result = array('error'    => common::checkValidate($request->all())['error'],
                'status'     => 201,
                'statusText' => 'validate failed');
        }
        return response()->json($result);
    }

    public function g006_delete(Request $request)
    {
        $data        = $request->all();
        $param['json']    = json_encode($data);
        $param['user_id']=Auth::user()->account_id;
        $param['ip']=$request->ip();
        $result_query       = DAO::call_stored_procedure("SPC_G006_ACT2", $param);
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