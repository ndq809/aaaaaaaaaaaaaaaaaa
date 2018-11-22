<?php
namespace App\Modules\User\Controllers;

use App\Http\Controllers\ControllerUser;
use Auth;
use CommonUser;
use DAO;
use Hashids\Hashids;
use Illuminate\Http\Request;
use SQLXML;

class WritingController extends ControllerUser
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
        $param                 = $request->all();
        $param['v']            = isset($param['v']) && isset($this->hashids->decode($param['v'])[0]) ? $this->hashids->decode($param['v'])[0] : '';
        $param['user_id']      = isset(Auth::user()->account_nm) ? Auth::user()->account_nm : '';
        $param['catalogue_id'] = $request->session()->get('catalogue_id');
        $param['group_id']     = $request->session()->get('group_id');
        $data                  = Dao::call_stored_procedure('SPC_WRITING_LST1', $param);
        $data                  = CommonUser::encodeID($data);
        return view('User::writing.index')->with('data_default', $data);
    }

    public function getData(Request $request)
    {
        $param            = $request->all();
        $param[0]         = $this->hashids->decode($param[0])[0];
        $param[1]         = $this->hashids->decode($param[1])[0];
        $param['user_id'] = isset(Auth::user()->account_nm) ? Auth::user()->account_nm : '';
        $data             = Dao::call_stored_procedure('SPC_WRITING_LST2', $param);
        $data             = CommonUser::encodeID($data);
        $view1            = view('User::writing.right_tab')->with('data', $data[2])->render();
        $view2            = view('User::writing.right_tab1')->with('data', $data[2])->render();
        $view3            = view('User::writing.tab_custom1')->with('data', $data)->render();
        $view4            = view('User::writing.tab_custom2')->with('data', $data)->render();
        $view5            = view('User::writing.main_content')->with('data', $data)->render();
        $result           = array(
            'status'        => 200,
            'writing_array' => $data[2],
            'voc_array'     => $data[4],
            'answer_array'  => $data[5],
            'mytag_array'   => $data[6],
            'view1'         => $view1,
            'view2'         => $view2,
            'view3'         => $view3,
            'view4'         => $view4,
            'view5'         => $view5,
            'statusText'    => 'success',
        );
        $request->session()->put('catalogue_id', $param[0]);
        $request->session()->put('group_id', $param[1]);
        return response()->json($result);
    }

    public function save(Request $request)
    {
        $param            = $request->all();
        $param['post_id'] = $param['post_id'] != '' ? $this->hashids->decode($param['post_id'])[0] : '';
        $xml              = new SQLXML();
        if (isset($param['post_tag'])) {
            for ($i = 0; $i < count($param['post_tag']); $i++) {
                if (isset($param['post_tag'][$i]['tag_id'])) {
                    $param['post_tag'][$i]['tag_id'] = $this->hashids->decode($param['post_tag'][$i]['tag_id'])[0];
                }
            }
        }
        $param['post_tag'] = $xml->xml(isset($param['post_tag'])?$param['post_tag']:array());
        if (isset($param['voc_array'])) {
            for ($i = 0; $i < count($param['voc_array']); $i++) {
                $param['voc_array'][$i]['id'] = $this->hashids->decode($param['voc_array'][$i]['id'])[0];
            }
        }
        $param['voc_array'] = $xml->xml(isset($param['voc_array'])?$param['voc_array']:array());
        $param['user_id']   = isset(Auth::user()->account_nm) ? Auth::user()->account_nm : '';
        $param['ip']        = $request->ip();
        $data               = Dao::call_stored_procedure('SPC_WRITING_ACT1', $param);
        // var_dump($data);die;
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
            $data   = CommonUser::encodeID($data);
            $view1  = view('User::writing.add_vocabulary')->with('data', $data[2])->render();
            $result = array(
                'status'        => 200,
                'writing_array' => $data[1],
                'voc_array'     => $data[2],
                'mytag_array'   => $data[3],
                'row_id'        => $data[4][0]['row_id'],
                'view'          => $view1,
                'statusText'    => 'success',
            );
        }
        return response()->json($result);
    }

    public function delete(Request $request)
    {
        $param            = $request->all();
        $param['post_id'] = $param['post_id'] != '' ? $this->hashids->decode($param['post_id'])[0] : '';
        $param['user_id'] = isset(Auth::user()->account_nm) ? Auth::user()->account_nm : '';
        $param['ip']      = $request->ip();
        $data             = Dao::call_stored_procedure('SPC_WRITING_ACT2', $param);
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

    public function share(Request $request)
    {
        $param            = $request->all();
        $param['post_id'] = $param['post_id'] != '' ? $this->hashids->decode($param['post_id'])[0] : '';
        $param['user_id'] = isset(Auth::user()->account_nm) ? Auth::user()->account_nm : '';
        $param['ip']      = $request->ip();
        $data             = Dao::call_stored_procedure('SPC_WRITING_ACT3', $param);
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
