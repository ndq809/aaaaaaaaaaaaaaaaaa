<?php
namespace App\Modules\Master\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Auth;
use Common;
use DAO;
use Illuminate\Http\Request;
use Validator;

class m008Controller extends Controller
{
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $data = Dao::call_stored_procedure('SPC_COM_M999_INQ1',array(19));
        return view('Master::masterdata.m008.index')->with('data_default', $data);
    }

    public function m008_list(Request $request)
    {
        $param = $request->all();
        $data = Dao::call_stored_procedure('SPC_M008_LST1', $param);
        return view('Master::masterdata.m008.search')
            ->with('data', $data);
    }

    public function m008_save(Request $request)
    {
        $data = $request->all();
        // var_dump($data);die;
        $param['name_div'] = $data['name_div'];
        $param['json']      = json_encode($data[0]);
        $param['user_id']  = Auth::user()->account_id;
        $param['ip']       = $request->ip();
        $validate          = common::checkValidate($request->all());
        if ($validate['result']) {
            $data = Dao::call_stored_procedure('SPC_M008_ACT1', $param);
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
                $result = array(
                    'status'     => 200,
                    'data'       => $data[0],
                    'statusText' => 'success',
                );
            }
        } else {
            $result = array('error' => isset($validate['error']) ? $validate['error'] : array(),
                'status'                => 201,
                'statusText'            => 'validate failed');
        }
        return response()->json($result);
    }

    public function checkValidateMulti($data)
    {
        if ($data == '') {
            return array('result' => true);
        }
        $validator = Validator::make($data, [
            '*.number_id'    => 'required|distinct',
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
