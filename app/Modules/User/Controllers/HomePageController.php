<?php 
namespace App\Modules\User\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\ControllerUser;
use Illuminate\Support\Facades\DB;

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
          $data = $request-> except('_token');
          if(isset($data['user'])){
               return view('User::homepage.index')->with('user',$data['user']);
          }else{
               return view('User::homepage.index');
          }
		
	}


	/**
     * Show the application index.
     * @author mail@ans-asia.com 
     * @created at 2017-08-16 03:29:46
     * @return void
     */
   
}