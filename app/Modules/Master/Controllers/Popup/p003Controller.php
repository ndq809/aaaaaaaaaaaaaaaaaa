<?php
namespace App\Modules\Master\Controllers\Popup;

use App\Http\Controllers\Controller;
use DAO;
use Illuminate\Http\Request;
use Validator;

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
        $data  = Dao::call_stored_procedure('SPC_p003_LST1', $param);
        return view('Master::popup.p003.search')
            ->with('data', $data)
            ->with('paging', $data[1][0]);
    }

    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return void
     */

}
