<?php
namespace App\Modules\Master\Controllers\Popup;

use App\Http\Controllers\Controller;
use DAO;
use Illuminate\Http\Request;
use Validator;

class p005Controller extends Controller
{
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
        $param = [];
        $param['catalogue_div'] = $request->input('catalogue_div');
        $data = Dao::call_stored_procedure('SPC_P005_INQ1',$param);
        return view('Master::popup.p005.index')->with('data_default',$data);
    }

    public function p005_search(Request $request)
    {
        $param = $request->all();
        $param['selected_list']= json_encode(isset($param['selected_list'])&&$param['selected_list']!=''?$param['selected_list']:array());
        $data  = Dao::call_stored_procedure('SPC_P005_LST1', $param);
        return view('Master::popup.p005.search')
            ->with('data', $data)
            ->with('paging', $data[1][0]);
    }

    public function p005_load(Request $request)
    {
        $param = $request->all();
        $param['post_array']= json_encode(isset($param['post_array'])&&is_array($param['post_array'])?$param['post_array']:array());
        $data  = Dao::call_stored_procedure('SPC_P005_LST2', $param);
        return view('Master::popup.p005.select')
            ->with('data', $data[0]);
    }

    public function p005_refer(Request $request)
    {
        $data = $request->all();
        $data['post_list']= json_encode(isset($data['post_list'])?$data['post_list']:array());
        $result  = Dao::call_stored_procedure('SPC_P005_LST3', $data);
        return view('Master::mission.mi002.refer_post')->with('data_post', $result[0])->render();
    }
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return void
     */

}
