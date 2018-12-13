<?php
namespace App\Modules\User\Controllers;

use App\Http\Controllers\ControllerUser;
use Auth;
use CommonUser;
use DAO;
use Hashids\Hashids;
use Illuminate\Http\Request;

class DictionaryController extends ControllerUser
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
        $param['v']            = isset($param['v'])&&isset($this->hashids->decode($param['v'])[0])?$this->hashids->decode($param['v'])[0] : '';
        $param['user_id']      = isset(Auth::user()->account_nm) ? Auth::user()->account_nm : '';
        $data                  = Dao::call_stored_procedure('SPC_DICTIONARY_LST1', $param);
        $data                  = CommonUser::encodeID($data);
        return view('User::dictionary.index')->with('data_default', $data[0])->with('search_history', $data[1]);;
    }

    public function getData(Request $request)
    {
        $param            = $request->all();
        $param['user_id'] = isset(Auth::user()->account_nm) ? Auth::user()->account_nm : '';
        $param['ip']=$request->ip();
        $data   = Dao::call_stored_procedure('SPC_DICTIONARY_LST2', $param);
        if (isset($data[0][0]['Data'])&&($data[0][0]['Data'] == 'Exception' || $data[0][0]['Data'] == 'EXCEPTION')) {
            $result = array(
                'status' => 208,
                'data'   => $data[0],
            );
        } else if (isset($data[0][0]['Data'])&&$data[0][0]['Data'] != '') {
            $result = array(
                'status' => 207,
                'data'   => $data[0],
            );
        } else {
            $data   = CommonUser::encodeID($data);
            $view1  = view('User::dictionary.right_tab')->with('data', $data[2])->render();
            $view2  = view('User::dictionary.main_content')->with('data', $data)->render();
            $view3  = view('User::dictionary.search_history')->with('search_history', $data[5])->render();
            $result = array(
                'status'     => 200,
                'voca_array' => $data[2],
                'selected_id'=> $data[4][0],
                'view1'      => $view1,
                'view2'      => $view2,
                'view3'      => $view3,
                'statusText' => 'success',
            );
        }
        
        return response()->json($result);
    }

    public function getAutocomplete(Request $request)
    {
        $param            = $request->all();
        $data   = Dao::call_stored_procedure('SPC_DICTIONARY_LST3', $param);
        return response()->json($data[0]);
    }
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return void
     */

}
