<?php
namespace App\Modules\Master\Controllers\General;

use App\Http\Controllers\Controller;
use Auth;
use DAO;
use Illuminate\Http\Request;

class g003Controller extends Controller
{
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $data = Dao::call_stored_procedure('SPC_COM_M999_INQ1', array(7));
        return view('Master::general.g003.index')->with('data_default', $data);
    }

    public function g003_list(Request $request)
    {
        $param = $request->all();
        $data  = Dao::call_stored_procedure('SPC_G003_LST1', $param);
        return view('Master::general.g003.search')
            ->with('data', $data)
            ->with('paging', $data[1][0]);
    }

    public function g003_delete(Request $request)
    {
        $data             = $request->all();
        $param['json']     = json_encode($data);
        $param['user_id'] = Auth::user()->account_id;
        $param['ip']      = $request->ip();
        $result_query     = DAO::call_stored_procedure("SPC_G003_ACT2", $param);
        if ($result_query[0][0]['Id'] == '') {
            $result = array(
                'status'     => 200,
                'statusText' => 'success',
            );
        } else {
            $result = array(
                'status'     => 200,
                'error'      => $result_query[0],
                'statusText' => 'failed',
            );
        }
        return response()->json($result);
    }

    public function g003_update(Request $request)
    {
        $data             = $request->all();
        $param['json']     = json_encode($data);
        $param['user_id'] = Auth::user()->account_id;
        $param['ip']      = $request->ip();
        $result_query     = DAO::call_stored_procedure("SPC_G003_ACT1", $param);
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
        return response()->json($result);
    }

    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return void
     */

}
