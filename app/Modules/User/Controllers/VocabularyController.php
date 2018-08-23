<?php 
namespace App\Modules\User\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\ControllerUser;
use Illuminate\Support\Facades\DB;
use DAO;
use Auth;

class VocabularyController extends ControllerUser
{
	/**
     * Show the application index.
     * @author mail@ans-asia.com 
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
	public function getIndex()
	{
        $data = Dao::call_stored_procedure('SPC_VOCABULARY_LST1',array(isset(Auth::user()->account_nm)?Auth::user()->account_nm:''));
		return view('User::vocabulary.index')->with('data_default',$data);;
	}

   public function getData(Request $request)
   {
        $param = $request->all();
        $param['user_id']=isset(Auth::user()->account_nm)?Auth::user()->account_nm:'';
        $data = Dao::call_stored_procedure('SPC_VOCABULARY_LST2',$param);
        // var_dump($data);die;
        $view1 = view('User::vocabulary.right_tab')->with('data', $data[2])->render();
        $view2 = view('User::vocabulary.main_content')->with('data', $data)->render();
        $result = array(
          'status'     => 200,
          'voca_array' => $data[2],
          'view1'      => $view1,
          'view2'      => $view2,
          'statusText' => 'success',
        );
      return response()->json($result);
   }
	/**
     * Show the application index.
     * @author mail@ans-asia.com 
     * @created at 2017-08-16 03:29:46
     * @return void
     */
   
}