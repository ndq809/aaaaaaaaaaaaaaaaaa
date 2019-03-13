<?php
namespace App\Modules\Master\Controllers\Vocabulary;
use App\Http\Controllers\Controller;
use Auth;
use Common;
use DAO;
use Illuminate\Http\Request;
use SQLXML;
use File;

class v002Controller extends Controller
{
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $data = Dao::call_stored_procedure('SPC_V002_FND1');
        return view('Master::vocabulary.v002.index')->with('data', $data);
    }

    public function v002_addnew(Request $request)
    {
        $data  = $request->all();
        $media = '';
        $name = '';
        $xml   = new SQLXML();
        $file = $request->file('post_audio');
        // var_dump($file);die;

        $validate = common::checkValidate((array) json_decode($data['header_data']));
        if ($validate['result']) {
            $param               = (array) json_decode($data['header_data']);
            // var_dump($param);die;
            //upload audio file
           if(!is_null($file)){
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
            $param['post_audio'] = $media;
            $param['xml_detail'] = $xml->xml((array) json_decode($data['detail_body_data']));
            $param['user_id']    = Auth::user()->account_id;
            $param['ip']         = $request->ip();

            $data = Dao::call_stored_procedure('SPC_V002_ACT1', $param);
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

    public function v002_upgrage(Request $request)
    {
        $data  = $request->all();
        $media = '';
        $name = '';
        $xml   = new SQLXML();
        $file = $request->file('post_audio');
        // var_dump($file);die;

        $validate = common::checkValidate((array) json_decode($data['header_data']));
        if ($validate['result']) {
            $param               = (array) json_decode($data['header_data']);
            // var_dump($param);die;
            //upload audio file
           if(!is_null($file)){
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
            $param['post_audio'] = $media;
            $param['xml_detail'] = $xml->xml((array) json_decode($data['detail_body_data']));
            $param['user_id']    = Auth::user()->account_id;
            $param['ip']         = $request->ip();

            $data = Dao::call_stored_procedure('SPC_V002_ACT3', $param);
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

    public function v002_delete(Request $request)
    {
        $param             = $request->all();
        $param['user_id'] = Auth::user()->account_id;
        $param['ip']      = $request->ip();
        $result_query     = DAO::call_stored_procedure("SPC_V002_ACT2", $param);
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

    public function v002_refer(Request $request)
    {
        $data             = $request->all();
        $result_query     = DAO::call_stored_procedure("SPC_v002_LST1", $data);
        // var_dump($result_query[1][0]['vocabulary_div']);die;
        return view('Master::vocabulary.v002.refer')->with('data', $result_query);
    }

    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return void
     */

}
