<?php
namespace App\Modules\Master\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Auth;
use Common;
use DAO;
use Illuminate\Http\Request;
use SQLXML;
use Validator;

class m007Controller extends Controller
{
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $data = Dao::call_stored_procedure('SPC_M007_FND1');
        return view('Master::masterdata.m007.index')->with('data_default', $data);
    }

    public function m007_list(Request $request)
    {
        $data = $request->all();
        $data = Dao::call_stored_procedure('SPC_m007_LST1', $data);
        return view('Master::masterdata.m007.search')
            ->with('data', $data);
    }

     public function m007_add(Request $request)
    {
        $data = $request->all();
        $param['name_div'] = $data['name_div'];
        $param['user_id']  = Auth::user()->account_nm;
        $param['ip']       = $request->ip();
        $validate          = common::checkValidate($request->all());
        if ($validate['result']) {
            $data = Dao::call_stored_procedure('SPC_M007_ACT2', $param);
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
                    'data'       => $data[1],
                    'statusText' => 'success',
                );
            }
        } else {
            $result = array('error' => array_merge(isset($validate['error']) ? $validate['error'] : array()),
                'status'                => 201,
                'statusText'            => 'validate failed');
        }
        return response()->json($result);
    }

     public function m007_delete(Request $request)
    {
        $data = $request->all();
        $param['name_div'] = $data['name_div'];
        $param['user_id']  = Auth::user()->account_nm;
        $param['ip']       = $request->ip();
        $validate          = common::checkValidate($request->all());
        if ($validate['result']) {
            $data = Dao::call_stored_procedure('SPC_M007_ACT3', $param);
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
                    'data'       => $data[1],
                    'statusText' => 'success',
                );
            }
        } else {
            $result = array('error' => array_merge(isset($validate['error']) ? $validate['error'] : array()),
                'status'                => 201,
                'statusText'            => 'validate failed');
        }
        return response()->json($result);
    }

    public function m007_save(Request $request)
    {
        $data = $request->all();
        // var_dump($data);die;
        $param['name_div'] = $data['name_div'];
        $xml               = new SQLXML();
        $param['xml']      = $xml->xml($data[0]);
        $param['user_id']  = Auth::user()->account_nm;
        $param['ip']       = $request->ip();
        $validate          = common::checkValidate($request->all());
        $validateMulti     = $this->checkValidateMulti($data[0]);
        if ($validate['result'] && $validateMulti['result']) {
            $data = Dao::call_stored_procedure('SPC_M007_ACT1', $param);
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
            $result = array('error' => array_merge(isset($validate['error']) ? $validate['error'] : array(), isset($validateMulti['error']) ? $validateMulti['error'] : array()),
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
