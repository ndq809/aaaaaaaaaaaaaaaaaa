<?php
namespace App\Modules\Master\Controllers\Writing;

use App\Http\Controllers\Controller;
use Auth;
use Common;
use DAO;
use File;
use Illuminate\Http\Request;

class w003Controller extends Controller
{
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $data = Dao::call_stored_procedure('SPC_W003_LST1');
        return view('Master::writing.w003.index')->with('data', $data);
    }

    public function w003_read(Request $request)
    {
        $file_upload = $request->file('post_file');
        if (!is_null($file_upload)) {
            if ($file_upload->getClientSize() > 20971520) {
                $result = array(
                    'status'     => 209,
                    'statusText' => 'upload failed');
                return response()->json($result);
            }
            $name = 'file_' . uniqid() . '.' . $file_upload->getClientOriginalExtension();
            $file_upload->move(public_path('/web-content/file/temp/'), $name);
            $media = '/web-content/file/temp/' . $name;
        }
        $file = fopen(public_path($media), "r");
        $data = [];
        while (!feof($file)) {
            array_push($data, fgets($file));
        }
        fclose($file);
        File::delete(public_path($media));
        $result = array(
            'status'     => 200,
            'data'       => $data,
            'statusText' => 'success',
        );
        return response()->json($result);
    }

    public function w003_save(Request $request)
    {
        $param    = $request->except('detail');
        $detail   = $request->input('detail');
        $validate = common::checkValidate($param);
        if ($validate['result']) {
            $param['json_detail'] = json_encode($detail);
            $param['user_id']     = Auth::user()->account_id;
            $param['ip']          = $request->ip();

            $data = Dao::call_stored_procedure('SPC_W003_ACT1', $param);
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
                    'post_id'    => $data[1][0]['post_id'],
                    'statusText' => 'success',
                );
            }
        } else {
            $result = array('error' => $validate['error'],
                'status'                => 201,
                'statusText'            => 'validate failed');
        }
        return response()->json($result);
    }

    public function w003_refer(Request $request)
    {
        $data         = $request->all();
        $result_query = DAO::call_stored_procedure("SPC_w003_LST1", $data);
        // var_dump($result_query[1][0]['writing_div']);die;
        return view('Master::writing.w003.refer')->with('data', $result_query);
    }

    public function w003_getAutocomplete(Request $request)
    {
        $param = $request->all();
        $data  = Dao::call_stored_procedure('SPC_W003_LST2', $param);
        return response()->json($data[0]);
    }

    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return void
     */

}
