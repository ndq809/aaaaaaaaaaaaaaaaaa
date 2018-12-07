<?php
namespace App\Modules\User\Controllers;

use App\Http\Controllers\ControllerUser;
use Auth;
use CommonUser;
use DAO;
use Hashids\Hashids;
use Illuminate\Http\Request;
use SQLXML;

class RelaxController extends ControllerUser
{
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
    private $hashids;

    public function __construct()
    {
        $this->hashids = new Hashids();
    }

    public function getIndex(Request $request)
    {
        $param            = $request->all();
        $param['v']       = isset($param['v']) && isset($this->hashids->decode($param['v'])[0]) ? $this->hashids->decode($param['v'])[0] : '';
        $param['user_id'] = isset(Auth::user()->account_nm) ? Auth::user()->account_nm : '';
        $data             = Dao::call_stored_procedure('SPC_RELAX_LST1', $param);
        $data             = CommonUser::encodeID($data);
        return view('User::Relax.index')->with('data_default', $data);
    }

    public function getData(Request $request)
    {
        $param            = $request->all();
        $param['post_id'] = $param['post_id'] != '' ? $this->hashids->decode($param['post_id'])[0] : '';
        if (isset($param['post_tag'])) {
            for ($i = 0; $i < count($param['post_tag']); $i++) {
                $param['post_tag'][$i]['tag_id'] = $this->hashids->decode($param['post_tag'][$i]['tag_id'])[0];
            }
        }
        $xml              = new SQLXML();
        $param['post_tag'] = $xml->xml(isset($param['post_tag']) ? $param['post_tag'] : array());
        $param['user_id']  = isset(Auth::user()->account_nm) ? Auth::user()->account_nm : '';
        $data              = Dao::call_stored_procedure('SPC_RELAX_LST2', $param);
        $data              = CommonUser::encodeID($data);
        $view1             = view('User::Relax.right_tab')->with('data', $data[2])->with('is_end', $data[7])->render();
        $view2            = view('User::Relax.tab_custom1')->with('data', $data)->render();
        $view3            = view('User::Relax.tab_custom2')->with('data', $data)->render();
        $view4            = view('User::Relax.main_content')->with('data', $data)->render();
        $result            = array(
            'status'       => 200,
            'voca_array'   => $data[2],
            'answer_array' => $data[5],
            'mytag_array'  => $data[6],
            'view1'        => $view1,
            'view2'        => $view2,
            'view3'        => $view3,
            'view4'        => $view4,
            'statusText'   => 'success',
        );
        return response()->json($result);
    }

    public function vote(Request $request)
    {
        $param            = $request->all();
        $param['post_id'] = $param['post_id'] != '' ? $this->hashids->decode($param['post_id'])[0] : '';
        $param['user_id'] = isset(Auth::user()->account_nm) ? Auth::user()->account_nm : '';
        $param['ip']      = $request->ip();
        $data             = Dao::call_stored_procedure('SPC_RELAX_ACT1', $param);
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
                'average_rating'   => $data[1][0]['average_rating'],
                'statusText' => 'success',
            );
        }
        return response()->json($result);
    }

    public function view(Request $request)
    {
        $param            = $request->all();
        $param['post_id'] = $param['post_id'] != '' ? $this->hashids->decode($param['post_id'])[0] : '';
        $param['user_id'] = isset(Auth::user()->account_nm) ? Auth::user()->account_nm : '';
        $param['ip']      = $request->ip();
        $data             = Dao::call_stored_procedure('SPC_RELAX_ACT2', $param);
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
                'post_view'   => $data[1][0]['post_view'],
                'statusText' => 'success',
            );
        }
        return response()->json($result);
    }

    public function save(Request $request)
    {
        $data  = $request->all();
        $media = '';
        $media_div = 0;
        $name = '';
        $xml   = new SQLXML();
        $file = $request->file('post_media');
        $param = [];
        $param_temp               = json_decode($data['header_data'],true);
        //upload image file
        if ($param_temp['post_div'] == '4' && !is_null($file)) {

            if ($file->getClientSize() > 20971520) {
                $result = array(
                    'status'     => 209,
                    'statusText' => 'upload failed');
                return response()->json($result);
            }
            $name = 'image_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/web-content/images/relax_image/'), $name);
            $media = '/web-content/images/relax_image/' . $name;
            $media_div = 2;
        }
        if ($param_temp['post_div'] == '5') {
            $media = (!isset($param_temp['post_media'])?'':$param_temp['post_media']);
            if (strpos($media, 'youtube') !== false) {
                $media_div = 3;
            }elseif (strpos($media, 'facebook') !== false) {
                $media_div = 4;
            }else
            $media_div = 5;
        }
        if (isset($param_temp['post_tag'])) {
            for ($i = 0; $i < count($param_temp['post_tag']); $i++) {
                if (isset($param_temp['post_tag'][$i]['tag_id'])) {
                    $param_temp['post_tag'][$i]['tag_id'] = $this->hashids->decode($param_temp['post_tag'][$i]['tag_id'])[0];
                }
            }
        }

        $param['post_div'] = isset($param_temp['post_div'])?$param_temp['post_div'] + 3 :'';
        $param['post_title'] = isset($param_temp['post_title'])?$param_temp['post_title']:'';
        $param['post_tag'] = $xml->xml($param_temp['post_tag']);
        $param['post_content'] = isset($param_temp['post_content'])?$param_temp['post_content']:'';
        $param['post_media'] = $media;
        $param['post_media_nm'] = $name;
        $param['post_media_div'] = $media_div;
        $param['user_id']    = Auth::user()->account_nm;
        $param['ip']         = $request->ip();
        
        // $param['post_tag'] = $xml->xml(isset($param['post_tag'])?$param['post_tag']:array());

        // var_dump($param);die;
        $data             = Dao::call_stored_procedure('SPC_RELAX_ACT3', $param);
        $data             = CommonUser::encodeID($data);
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
                'post_info'   => $data[1][0],
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
