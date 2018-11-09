<?php
namespace App\Modules\Master\Controllers\Popup;

use App\Http\Controllers\Controller;
use DAO;
use Illuminate\Http\Request;
use Validator;
use SQLXML;

class p003Controller extends Controller
{
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $data = Dao::call_stored_procedure('SPC_COM_M999_INQ1',array(8));
        return view('Master::popup.p003.index')->with('data_default',$data);
    }

    public function p003_search(Request $request)
    {
        $param = $request->all();
        $xml   = new SQLXML();
        $param['selected_list']= $xml->xml(isset($param['selected_list'])?$param['selected_list']:array());
        $data  = Dao::call_stored_procedure('SPC_p003_LST1', $param);
        return view('Master::popup.p003.search')
            ->with('data', $data)
            ->with('paging', $data[1][0]);
    }

    public function p003_load(Request $request)
    {
        $param = $request->all();
        $xml   = new SQLXML();
        $param['voc_array']= $xml->xml(isset($param['voc_array'])?$param['voc_array']:array());
        $data  = Dao::call_stored_procedure('SPC_p003_LST2', $param);
        return view('Master::popup.p003.select')
            ->with('data', $data[0]);
    }

    public function p003_refer(Request $request)
    {
        $data = $request->all();
        $xml   = new SQLXML();
        $param['voc_array']= $xml->xml(isset($data)?$data:array());
        $result  = Dao::call_stored_procedure('SPC_p003_LST3', $param);
        return view('Master::writing.w002.refer_voc')->with('data_voc', $result[0])->render();
    }
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return void
     */

}
