<?php 
namespace App\Modules\User\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReadingController extends Controller
{
	/**
     * Show the application index.
     * @author mail@ans-asia.com 
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
	public function getIndex()
	{
		return view('User::reading.index');
	}

     public function getData()
     {
          return view('User::reading.index');
     }


	/**
     * Show the application index.
     * @author mail@ans-asia.com 
     * @created at 2017-08-16 03:29:46
     * @return void
     */
   
}