<?php
namespace App\Modules\Master\Controllers\Writing;

use App\Http\Controllers\Controller;
use Auth;
use Common;
use DAO;
use File;
use Illuminate\Http\Request;

class w002Controller extends Controller
{
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $data = Dao::call_stored_procedure('SPC_W002_FND1');
        return view('Master::writing.w002.index')->with('data', $data);
    }

    public function w002_addnew(Request $request)
    {
        $data      = $request->all();
        $media     = '';
        $media_div = 0;
        $name      = '';
        $file      = $request->file('post_media');
        $param     = [];
        $validate  = common::checkValidate((array) json_decode($data['header_data']));
        if ($validate['result']) {
            $param_temp = (array) json_decode($data['header_data']);
            //upload audio file
            if ($param_temp['catalogue_div'] == '3' && !is_null($file)) {
                if ($file->getClientSize() > 20971520) {
                    $result = array(
                        'status'     => 209,
                        'statusText' => 'upload failed');
                    return response()->json($result);
                }
                $name = 'audio_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('/web-content/audio/listeningAudio/'), $name);
                $media     = '/web-content/audio/listeningAudio/' . $name;
                $media_div = 1;
            }
            //upload image file
            if ($param_temp['catalogue_div'] == '7' && !is_null($file)) {
                if ($file->getClientSize() > 20971520) {
                    $result = array(
                        'status'     => 209,
                        'statusText' => 'upload failed');
                    return response()->json($result);
                }
                $name = 'image_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('/web-content/images/relax_image/'), $name);
                $media     = '/web-content/images/relax_image/' . $name;
                $media_div = 2;
            }
            if ($param_temp['catalogue_div'] == '8') {
                $media = (!isset($param_temp['post_media']) || $param_temp['post_media'] == 'no-data' ? '' : $param_temp['post_media']);
                if (strpos($media, 'youtube') !== false) {
                    $media_div = 3;
                } elseif (strpos($media, 'facebook') !== false) {
                    $media_div = 4;
                } else {
                    $media_div = 5;
                }

            }
            $param['post_id']        = $param_temp['post_id'];
            $param['catalogue_div']  = $param_temp['catalogue_div'];
            $param['catalogue_nm']   = isset($param_temp['catalogue_nm']) ? $param_temp['catalogue_nm'] : '';
            $param['group_nm']       = isset($param_temp['group_nm']) ? $param_temp['group_nm'] : '';
            $param['post_title']     = isset($param_temp['post_title']) ? $param_temp['post_title'] : '';
            $param['post_tag']       = json_encode(json_decode($data['header_data'], true)['post_tag']);
            $param['post_content']   = isset($param_temp['post_content']) ? $param_temp['post_content'] : '';
            $param['post_media']     = (!isset($param_temp['post_media']) || $param_temp['post_media'] == 'no-data' ? '' : $media);
            $param['post_media_nm']  = $name;
            $param['post_media_div'] = $media_div;
            $param['json_detail']     = json_encode((array) json_decode($data['detail_data']));
            $param['json_detail1']    = json_encode((array) json_decode($data['detail_body_data']));
            $param['json_detail2']    = json_encode((array) json_decode($data['pra_body_data']));
            $param['user_id']        = Auth::user()->account_id;
            $param['ip']             = $request->ip();
            // var_dump($param);die;
            $data = Dao::call_stored_procedure('SPC_w002_ACT1', $param);
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

    public function w002_delete(Request $request)
    {
        $param            = $request->all();
        $param['user_id'] = Auth::user()->account_id;
        $param['ip']      = $request->ip();
        $result_query     = DAO::call_stored_procedure("SPC_w002_ACT2", $param);
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

    public function w002_refer(Request $request)
    {
        $data         = $request->all();
        $result_query = DAO::call_stored_procedure("SPC_W002_LST1", $data);
        $view1        = view('Master::writing.w002.refer_voc')->with('data_voc', $result_query[2])->render();
        $view2        = view('Master::writing.w002.refer_exa')->with('data', $result_query)->render();
        $view3        = view('Master::writing.w002.refer_pra')->with('data', $result_query)->render();
        $result       = array(
            'status'     => 200,
            'data'       => $result_query,
            'table_voc'  => $view1,
            'table_exa'  => $view2,
            'table_pra'  => $view3,
            'statusText' => 'success',
        );
        return response()->json($result);
    }

    public function w002_getcatalogue(Request $request)
    {
        $data         = $request->all();
        $result_query = DAO::call_stored_procedure("SPC_W002_LST2", $data);
        $result       = array(
            'status'     => 200,
            'data'       => $result_query,
            'statusText' => 'success',
        );
        return response()->json($result);
    }

    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return void
     */

}
