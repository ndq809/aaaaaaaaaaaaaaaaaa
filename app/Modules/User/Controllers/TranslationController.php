<?php
namespace App\Modules\User\Controllers;

use App\Http\Controllers\ControllerUser;
use Auth;
use Common;
use CommonUser;
use DAO;
use Hashids\Hashids;
use Illuminate\Http\Request;
use SQLXML;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslationController extends ControllerUser
{
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
    private $hashids, $tr;

    public function __construct()
    {
        $this->hashids = new Hashids();
        $this->tr      = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default
        $this->tr->setSource('en'); // Translate from English
        // $this->$tr->setSource(); // Detect language automatically
        $this->tr->setTarget('vi'); // Translate to Georgian
    }

    public function getIndex(Request $request)
    {
        // var_dump($this->tr->translate('To detect language automatically, just set the source language to null'));die;
        return view('User::translation.index');
    }

    public function getData(Request $request)
    {
        $param            = $request->all();
        $param['post_id'] = isset($param['post_id']) && isset($this->hashids->decode($param['post_id'])[0]) ? $this->hashids->decode($param['post_id'])[0] : '';
        $param['user_id'] = isset(Auth::user()->account_nm) ? Auth::user()->account_nm : '';
        $data             = Dao::call_stored_procedure('SPC_TRANSLATION_LST1', $param);
        $data             = CommonUser::encodeID($data);
        $view1            = view('User::translation.left_tab')->with('data_default', $data)->render();
        $view2            = view('User::translation.main_content')->with('data_default', $data)->render();
        $result           = array(
            'status'     => 200,
            'data'       => $data,
            'view1'      => $view1,
            'view2'      => $view2,
            'statusText' => 'success',
        );
        return response()->json($result);
    }

    public function autoTranslate(Request $request)
    {
        $param = $request->all();
        try {
            $data   = $this->tr->translate($param['text']);
            $result = array(
                'status'     => $data == null ? 211 : 200,
                'data'       => $data == null ? 'Không có bản dịch tham khảo nào' : $data,
                'statusText' => 'success',
            );
        } catch (Exception $e) {
            $result = array(
                'status'     => 210,
                'data'       => 'Hệ thống dịch bị lỗi',
                'statusText' => 'error',
            );
        }
        return response()->json($result);
    }

    public function save(Request $request)
    {
        $param            = $request->all();
        $data1            = [];
        $data1['post_id'] = isset($this->hashids->decode($param['post_id'])[0]) ? $this->hashids->decode($param['post_id'])[0] : '';
        $xml              = new SQLXML();
        if (isset($param['post_tag'])) {
            for ($i = 0; $i < count($param['post_tag']); $i++) {
                if (isset($param['post_tag'][$i]['tag_id'])) {
                    $param['post_tag'][$i]['tag_id'] = $this->hashids->decode($param['post_tag'][$i]['tag_id'])[0];
                }
            }
        }
        $data1['title']      = $param['post_title'];
        $data1['post_tag']   = $xml->xml(isset($param['post_tag']) ? $param['post_tag'] : array());
        $data1['en_text']    = $param['en_text'];
        $data1['vi_text']    = $param['vi_text'];
        $data1['en_array']   = $xml->xml(isset($param['en_array']) ? $param['en_array'] : array());
        $data1['vi_array']   = $xml->xml(isset($param['vi_array']) ? $param['vi_array'] : array());
        $data1['auto_array'] = $xml->xml(isset($param['auto_array']) ? $param['auto_array'] : array());
        $data1['save_mode']  = $param['save_mode'];
        $data1['user_id']    = isset(Auth::user()->account_nm) ? Auth::user()->account_nm : '';
        $data1['ip']         = $request->ip();
        if (common::checkValidate($data1)['result']) {
            $data = Dao::call_stored_procedure('SPC_TRANSLATION_ACT1', $data1);
            if ($data[2][0]['Data'] == 'Exception' || $data[2][0]['Data'] == 'EXCEPTION') {
                $result = array(
                    'status' => 208,
                    'data'   => $data[2],
                );
            } else if ($data[2][0]['Data'] != '') {
                $result = array(
                    'status' => 207,
                    'data'   => $data[2],
                );
            } else {
                $data   = CommonUser::encodeID($data);
                $view1  = view('User::translation.left_tab')->with('data_default', $data)->render();
                $result = array(
                    'status'     => 200,
                    'statusText' => 'success',
                    'view'       => $view1,
                    'data'       => $data,
                );
            }
        } else {
            $result = array('error' => common::checkValidate($data1)['error'],
                'status'                => 201,
                'statusText'            => 'validate failed');
        }

        return response()->json($result);
    }

    public function delete(Request $request)
    {
        $param            = $request->all();
        $param['post_id'] = $param['post_id'] != '' ? $this->hashids->decode($param['post_id'])[0] : '';
        $param['user_id'] = isset(Auth::user()->account_nm) ? Auth::user()->account_nm : '';
        $param['ip']      = $request->ip();
        $data             = Dao::call_stored_procedure('SPC_TRANSLATION_ACT2', $param);
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
