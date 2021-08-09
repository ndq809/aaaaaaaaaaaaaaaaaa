<?php
namespace App\Modules\Master\Controllers\Denounce;

use App\Http\Controllers\Controller;
use Auth;
use DAO;
use Illuminate\Http\Request;
use Validator;

class d001Controller extends Controller
{
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $data = Dao::call_stored_procedure('SPC_D001_FND1');
        return view('Master::denounce.d001.index')->with('data_default', $data);
    }

    public function d001_list(Request $request)
    {
        $param = $request->all();
        $param['user_id'] = Auth::user()->account_id;
        $param['ip']      = $request->ip();
        $data  = Dao::call_stored_procedure('SPC_D001_LST1', $param);
        return view('Master::denounce.d001.search')
            ->with('data', $data)
            ->with('paging', $data[2][0]);
    }

    public function d001_delete(Request $request)
    {
        $data             = $request->all();
        $param['json']     = json_encode($data);
        $param['user_id'] = Auth::user()->account_id;
        $param['ip']      = $request->ip();
        $result_query     = DAO::call_stored_procedure("SPC_D001_ACT2", $param);
        if ($result_query[0][0]['Data'] == 'Exception' || $result_query[0][0]['Data'] == 'EXCEPTION') {
            $result = array(
                'status'     => 208,
                'error'      => $result_query[0],
                'statusText' => 'failed',
            );
        } else {
            $result = array(
                'status'     => 200,
                'statusText' => 'success',
            );
        }
        return response()->json($result);
    }

    public function d001_update(Request $request)
    {
        $data             = $request->all();
        $param['header']     = json_encode($data['data_header']);
        $param['detail']     = json_encode($data['data_detail']);
        $param['user_id'] = Auth::user()->account_id;
        $param['ip']      = $request->ip();
        $result_query     = DAO::call_stored_procedure("SPC_D001_ACT1", $param);
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

    public function checkValidateMulti($data)
    {
        if ($data == '') {
            return array('result' => true);
        }
        $validator = Validator::make($data, [
            '*.do_denounce'  => 'required|distinct',
            '*.num_remark1'  => 'nullable|digits_between:0,15',
            '*.num_remark2'  => 'nullable|digits_between:0,15',
            '*.num_remark3'  => 'nullable|digits_between:0,15',
            '*.text_remark1' => 'max:50',
            '*.text_remark2' => 'max:50',
            '*.text_remark3' => 'max:50']);
        if (!$validator->passes()) {
            return array('result' => false, 'error' => $validator->errors()->all());
        } else {
            return array('result' => true);
        }
    }

    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return void
     */

}
