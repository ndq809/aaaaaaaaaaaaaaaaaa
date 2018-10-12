<?php 
namespace App\Modules\User\Controllers;
use App\Http\Controllers\ControllerUser;
use Auth;
use CommonUser;
use DAO;
use Hashids\Hashids;
use Illuminate\Http\Request;

class WritingController extends ControllerUser
{
	/**
     * Show the application index.
     * @author mail@ans-asia.com 
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
	private $hashids;

    public function __construct()
    {
        $this->hashids = new Hashids();
    }

    public function getIndex(Request $request)
    {
        $param                 = $request->all();
        $param['v']            = isset($param['v'])&&isset($this->hashids->decode($param['v'])[0]) ? $this->hashids->decode($param['v'])[0] : '';
        $param['user_id']      = isset(Auth::user()->account_nm) ? Auth::user()->account_nm : '';
        $param['catalogue_id'] = $request->session()->get('catalogue_id');
        $param['group_id']     = $request->session()->get('group_id');
        $data                  = Dao::call_stored_procedure('SPC_WRITING_LST1', $param);
        $data                  = CommonUser::encodeID($data);
        return view('User::writing.index')->with('data_default', $data);
    }

    public function getData(Request $request)
    {
        $param            = $request->all();
        $param[0]         = $this->hashids->decode($param[0])[0];
        $param[1]         = $this->hashids->decode($param[1])[0];
        $param['user_id'] = isset(Auth::user()->account_nm) ? Auth::user()->account_nm : '';
        $data   = Dao::call_stored_procedure('SPC_WRITING_LST2', $param);
        $data   = CommonUser::encodeID($data);
        $view1  = view('User::writing.right_tab')->with('data', $data[2])->render();
        $view2  = view('User::writing.main_content')->with('data', $data)->render();
        $result = array(
            'status'     => 200,
            'voca_array' => $data[2],
            'answer_array' => $data[5],
            'view1'      => $view1,
            'view2'      => $view2,
            'statusText' => 'success',
        );
        $request->session()->put('catalogue_id', $param[0]);
        $request->session()->put('group_id', $param[1]);
        return response()->json($result);
    }

	/**
     * Show the application index.
     * @author mail@ans-asia.com 
     * @created at 2017-08-16 03:29:46
     * @return void
     */
   
}