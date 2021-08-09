<?php 
namespace App\Modules\User\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\ControllerUser;
use Illuminate\Support\Facades\DB;
use Auth;
use CommonUser;
use DAO;
use Hashids\Hashids;

class HomePageController extends ControllerUser
{
	/**
     * Show the application index.
     * @author mail@ans-asia.com 
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
	public function getIndex(Request $request)
	{
          $data                  = Dao::call_stored_procedure('SPC_HOMEPAGE_LST1');
          $data                  = CommonUser::encodeID($data);
          return view('User::homepage.index')
          ->with('data', $data)
          ->with('paging', $data[1][0]);
		
     }
     
     public function getList(Request $request)
     {
        $param               = $request->all();
        $data                = Dao::call_stored_procedure('SPC_HOMEPAGE_LST1', $param);
        return view('User::homepage.search')
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