<?php 
namespace App\Modules\User\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\ControllerUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Auth;
use CommonUser;
use DAO;
class RegisterController extends ControllerUser
{
	/**
     * Show the application index.
     * @author mail@ans-asia.com 
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
	public function getIndex(Request $request)
	{
          $param                 = $request->all();
          $data                  = Dao::call_stored_procedure('SPC_REGISTER_LST1');
          $data                  = CommonUser::encodeID($data);
          if(isset($param['default_data'])){
               $param['default_data']['last_nm'] = substr($param['default_data']['name'],strrpos($param['default_data']['name'],' '));
               $param['default_data']['first_nm'] = substr($param['default_data']['name'],0,strpos($param['default_data']['name'],' '));
               $param['default_data']['first_nm'] = substr($param['default_data']['name'],0,strpos($param['default_data']['name'],' '));
               return view('User::register.index')->with('default_data',$param['default_data'])->with('data',$data);
          }else{
               return view('User::register.index')->with('data',$data);
          }
	}

     public function getData()
     {
          return view('User::register.index');
     }
	/**
     * Show the application index.
     * @author mail@ans-asia.com 
     * @created at 2017-08-16 03:29:46
     * @return void
     */
   
}