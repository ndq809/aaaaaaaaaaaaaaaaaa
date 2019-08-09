<?php
namespace App\Modules\Master\Controllers\mission;

use App\Http\Controllers\Controller;
use Auth;
use Common;
use DAO;
use File;
use Illuminate\Http\Request;

class mi002Controller extends Controller
{
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $data = Dao::call_stored_procedure('SPC_Mi002_FND1');
        return view('Master::mission.mi002.index')->with('data_default', $data);
    }

    public function mi002_addnew(Request $request)
    {
        $data          = $request->all();
        $validate_data = $data['header_data'];
        switch ($data['header_data']['mission_data_div'] * 1) {
            case 1:
                unset($validate_data['group_nm']);
                break;
            case 3:
                unset($validate_data['catalogue_nm']);
                unset($validate_data['group_nm']);
                break;
            default:
                # code...
                break;
        }
        $validate = common::checkValidate($validate_data);
        if ($validate['result']) {
            $param                = $data['header_data'];
            $param['detail_data'] = json_encode(isset($data['detail_data'])?$data['detail_data']:array());
            $param['user_id']     = Auth::user()->account_id;
            $param['ip']          = $request->ip();

            $data = Dao::call_stored_procedure('SPC_Mi002_ACT1', $param);
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
            $result = array(
                'error'      => $validate['error'],
                'status'     => 201,
                'statusText' => 'validate failed');
        }
        return response()->json($result);
    }

    public function mi002_upgrage(Request $request)
    {
        $data  = $request->all();
        $media = '';
        $name  = '';
        $file  = $request->file('post_audio');
        // var_dump($file);die;

        $validate = common::checkValidate((array) json_decode($data['header_data']));
        if ($validate['result']) {
            $param = (array) json_decode($data['header_data']);
            // var_dump($param);die;
            //upload audio file
            if (!is_null($file)) {
                if ($file->getClientSize() > 20971520) {
                    $result = array(
                        'status'     => 209,
                        'statusText' => 'upload failed');
                    return response()->json($result);
                }
                $name = 'audio_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('/web-content/audio/listeningAudio/'), $name);
                $media = '/web-content/audio/listeningAudio/' . $name;
            }
            $param['post_audio']  = $media;
            $param['json_detail'] = json_encode((array) json_decode($data['detail_body_data']));
            $param['user_id']     = Auth::user()->account_id;
            $param['ip']          = $request->ip();

            $data = Dao::call_stored_procedure('SPC_mi002_ACT3', $param);
            if ($data[0][0]['Data'] == 'Exception' || $data[0][0]['Data'] == 'EXCEPTION') {
                File::delete($media);
                $result = array(
                    'status' => 208,
                    'data'   => $data[0],
                );
            } else if ($data[0][0]['Data'] != '') {
                File::delete($media);
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
            $result = array('error' => $validate['error'],
                'status'                => 201,
                'statusText'            => 'validate failed');
        }
        return response()->json($result);
    }

    public function mi002_delete(Request $request)
    {
        $param            = $request->all();
        $param['user_id'] = Auth::user()->account_id;
        $param['ip']      = $request->ip();
        $result_query     = DAO::call_stored_procedure("SPC_mi002_ACT2", $param);
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

    public function mi002_refer(Request $request)
    {
        $data         = $request->all();
        $result_query = DAO::call_stored_procedure("SPC_Mi002_LST1", $data);
        $view1        = view('Master::mission.mi002.refer')->with('data_default', $result_query)->render();
        if ($result_query[4][0]['catalogue_div']*1 == 1) {
            $view2        = view('Master::mission.mi002.refer_voc')->with('data_voc', $result_query[5])->render();
        }else{
            $view2        = view('Master::mission.mi002.refer_post')->with('data_post', $result_query[5])->render();
        }
        $result       = array(
            'status'     => 200,
            'view1'      => $view1,
            'view2'      => $view2,
            'data'       => $result_query[4][0],
            'statusText' => 'success',
        );
        return response()->json($result);
        // return view('Master::mission.mi002.refer')->with('data', $result_query);
    }

    public function refer_catalogue(Request $request)
    {
        $param = $request->all();
        $data  = Dao::call_stored_procedure('SPC_Mi002_LST2', $param);
        return view('Master::mission.mi002.refer_catalogue')
            ->with('data', $data);
    }

    public function refer_group(Request $request)
    {
        $param = $request->all();
        $data  = Dao::call_stored_procedure('SPC_Mi002_LST3', $param);
        return view('Master::mission.mi002.refer_group')
            ->with('data', $data);
    }

    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return void
     */

}
