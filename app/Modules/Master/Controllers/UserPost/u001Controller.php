<?php 
namespace App\Modules\Master\Controllers\UserPost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class u001Controller extends Controller
{
	/**
     * Show the application index.
     * @author mail@ans-asia.com 
     * @created at 2017-08-16 03:29:46 
     * @return \Illuminate\Http\Response
     */
	public function getIndex()
	{
		return view('Master::userpost.u001');
	}


	/**
     * Show the application index.
     * @author mail@ans-asia.com 
     * @created at 2017-08-16 03:29:46
     * @return void
     */
   
}