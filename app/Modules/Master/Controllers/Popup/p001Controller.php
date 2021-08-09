<?php
namespace App\Modules\Master\Controllers\Popup;

use App\Http\Controllers\Controller;
use DAO;
use Illuminate\Http\Request;
use Validator;

class p001Controller extends Controller
{
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return view('Master::popup.p001.index');
    }

    public function p001_search(Request $request)
    {
        $param = $request->all();
        $data  = Dao::call_stored_procedure('SPC_P001_LST1', $param);
        return view('Master::popup.p001.search')
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
