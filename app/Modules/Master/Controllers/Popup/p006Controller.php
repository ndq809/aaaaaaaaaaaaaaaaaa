<?php
namespace App\Modules\Master\Controllers\Popup;

use App\Http\Controllers\Controller;
use DAO;
use Illuminate\Http\Request;
use Validator;

class p006Controller extends Controller
{
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
        $data = Dao::call_stored_procedure('SPC_P006_INQ1');
        return view('Master::popup.p006.index')->with('data_default',$data);
    }

    public function p006_search(Request $request)
    {
        $param = $request->all();
        $param['selected_list']= json_encode(isset($param['selected_list'])&&$param['selected_list']!=''?$param['selected_list']:array());
        $data  = Dao::call_stored_procedure('SPC_P006_LST1', $param);
        return view('Master::popup.p006.search')
            ->with('data', $data)
            ->with('paging', $data[1][0]);
    }

    public function p006_load(Request $request)
    {
        $param = $request->all();
        $param['user_array']= json_encode(isset($param['user_array'])&&is_array($param['user_array'])?$param['user_array']:array());
        $data  = Dao::call_stored_procedure('SPC_P006_LST2', $param);
        return view('Master::popup.p006.select')
            ->with('data', $data[0]);
    }

    public function p006_refer(Request $request)
    {
        $data = $request->all();
        $data['user_list']= json_encode(isset($data['user_list'])?$data['user_list']:array());
        $result  = Dao::call_stored_procedure('SPC_P006_LST3', $data);
        return view('Master::mission.mi002.refer_user')->with('data_user', $result[0])->render();
    }
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return void
     */

}
