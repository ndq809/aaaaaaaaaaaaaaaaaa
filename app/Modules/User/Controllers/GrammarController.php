<?php
namespace App\Modules\User\Controllers;

use App\Http\Controllers\ControllerUser;
use Auth;
use CommonUser;
use DAO;
use Hashids\Hashids;
use Illuminate\Http\Request;

class GrammarController extends ControllerUser
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
        $param['v']            = isset($param['v']) && isset($this->hashids->decode($param['v'])[0]) ? $this->hashids->decode($param['v'])[0] : '';
        $param['user_id']      = isset(Auth::user()->account_id) ? Auth::user()->account_id : '';
        $param['catalogue_id'] = $request->session()->get('catalogue_id');
        $param['group_id']     = $request->session()->get('group_id');
        $data                  = Dao::call_stored_procedure('SPC_GRAMMAR_LST1', $param);
        $data                  = CommonUser::encodeID($data);
        if(!isset($request->all()['v'])||$data[2][0]['target_id']!=''){
            return view('User::grammar.index')->with('data_default', $data);
        }else{
            return view('User::grammar.index')->with('data_default', $data)->with('blank', '1');
        }
    }

    public function getData(Request $request)
    {
        $param            = $request->all();
        $param[0]         = $this->hashids->decode($param[0])[0];
        $param[1]         = $this->hashids->decode($param[1])[0];
        $param['user_id'] = isset(Auth::user()->account_id) ? Auth::user()->account_id : '';
        $data   = Dao::call_stored_procedure('SPC_GRAMMAR_LST2', $param);
        $data   = CommonUser::encodeID($data);
        $view1  = view('User::grammar.right_tab')->with('data', $data[2])->render();
        $view2  = view('User::grammar.main_content')->with('data', $data)->render();
        $result = array(
            'status'     => 200,
            'voca_array' => $data[2],
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
