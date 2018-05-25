<?php 
namespace App\Modules\User\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\ControllerUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class RegisterController extends ControllerUser
{
	/**
     * Show the application index.
     * @author mail@ans-asia.com 
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
	public function getIndex()
	{
		return view('User::register.index');
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