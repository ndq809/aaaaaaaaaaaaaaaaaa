<?php
namespace App\Modules\User\Controllers;

use App\Http\Controllers\ControllerUser;
use Auth;
use CommonUser;
use DAO;
use Hashids\Hashids;
use Illuminate\Http\Request;
use SQLXML;

class SocialController extends ControllerUser
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
        $data             = Dao::call_stored_procedure('SPC_SOCIAL_LST1', $param);
        $data             = CommonUser::encodeID($data);
        return view('User::Social.index')->with('data_default', $data);
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
        $data              = Dao::call_stored_procedure('SPC_SOCIAL_LST2', $param);
        $data              = CommonUser::encodeID($data);
        $view1             = view('User::Social.right_tab')->with('data', $data[2])->render();
        $view2             = view('User::Social.main_content')->with('data', $data)->render();
        $result            = array(
            'status'       => 200,
            'voca_array'   => $data[2],
            'answer_array' => $data[5],
            'mytag_array'  => $data[6],
            'view1'        => $view1,
            'view2'        => $view2,
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
        $data             = Dao::call_stored_procedure('SPC_SOCIAL_ACT1', $param);
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

    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return void
     */

}
