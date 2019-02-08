<?php
namespace App\Modules\User\Controllers;

use App\Http\Controllers\ControllerUser;
use Auth;
use CommonUser;
use DAO;
use Hashids\Hashids;
use Illuminate\Http\Request;
use SQLXML;

class DiscussController extends ControllerUser
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
        $data             = Dao::call_stored_procedure('SPC_DISCUSS_LST1', $param);
        $data             = CommonUser::encodeID($data);
        if(!isset($request->all()['v'])||$data[2][0]['target_id']!=''){
            return view('User::discuss.index')->with('data_default', $data);
        }else{
            return view('User::discuss.index')->with('data_default', $data)->with('blank', '1');
        }
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
        $xml               = new SQLXML();
        $param['post_tag'] = $xml->xml(isset($param['post_tag']) ? $param['post_tag'] : array());
        $param['user_id']  = isset(Auth::user()->account_nm) ? Auth::user()->account_nm : '';
        $data              = Dao::call_stored_procedure('SPC_DISCUSS_LST2', $param);
        // var_dump($data);die;
        $data   = CommonUser::encodeID($data);
        $view1  = view('User::Discuss.right_tab')->with('data', $data[2])->with('is_end', $data[7])->render();
        $view2  = view('User::Discuss.tab_custom1')->with('data', $data)->render();
        $view3  = view('User::Discuss.tab_custom2')->with('data', $data)->render();
        $view4  = view('User::Discuss.main_content')->with('data', $data)->render();
        $result = array(
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
        $data             = Dao::call_stored_procedure('SPC_DISCUSS_ACT1', $param);
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
                'data'       => $data[1][0],
                'statusText' => 'success',
            );
        }
        return response()->json($result);
    }

    public function voteCmt(Request $request)
    {
        $param            = $request->all();
        $param[0]         = $param[0] != '' ? $this->hashids->decode($param[0])[0] : '';
        $param['user_id'] = isset(Auth::user()->account_nm) ? Auth::user()->account_nm : '';
        $param['ip']      = $request->ip();
        $data             = Dao::call_stored_procedure('SPC_DISCUSS_ACT3', $param);
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
                'data'       => $data[1][0],
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
        $data             = Dao::call_stored_procedure('SPC_DISCUSS_ACT2', $param);
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
                'post_view'  => $data[1][0]['post_view'],
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