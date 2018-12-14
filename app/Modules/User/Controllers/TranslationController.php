<?php
namespace App\Modules\User\Controllers;

use App\Http\Controllers\ControllerUser;
use Auth;
use CommonUser;
use DAO;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslationController extends ControllerUser
{
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
    private $hashids,$tr;

    public function __construct()
    {
        $this->hashids = new Hashids();
        $this->tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default
        $this->tr->setSource('en'); // Translate from English
        // $this->$tr->setSource(); // Detect language automatically
        $this->tr->setTarget('vi'); // Translate to Georgian
    }

    public function getIndex(Request $request)
    {
        // $param                 = $request->all();
        // $param['v']            = isset($param['v'])&&isset($this->hashids->decode($param['v'])[0]) ? $this->hashids->decode($param['v'])[0] : '';
        // $param['user_id']      = isset(Auth::user()->account_nm) ? Auth::user()->account_nm : '';
        // $param['catalogue_id'] = $request->session()->get('catalogue_id');
        // $param['group_id']     = $request->session()->get('group_id');
        // $data                  = Dao::call_stored_procedure('SPC_TRANSLATION_LST1', $param);
        // $data                  = CommonUser::encodeID($data);
        // var_dump($this->tr->translate('To detect language automatically, just set the source language to null'));die;
        return view('User::translation.index');
    }

    public function getData(Request $request)
    {
        $param            = $request->all();
        $param[0]         = $this->hashids->decode($param[0])[0];
        $param[1]         = $this->hashids->decode($param[1])[0];
        $param['user_id'] = isset(Auth::user()->account_nm) ? Auth::user()->account_nm : '';
        $data   = Dao::call_stored_procedure('SPC_TRANSLATION_LST2', $param);
        $data   = CommonUser::encodeID($data);
        $view1  = view('User::translation.right_tab')->with('data', $data[2])->render();
        $view2  = view('User::translation.main_content')->with('data', $data)->render();
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

    public function autoTranslate(Request $request)
    {
        $param            = $request->all();
        try {
            $data = $this->tr->translate($param['text']);
            $result = array(
                'status'     => $data==null?211:200,
                'data'       => $data==null?'Không có bản dịch tham khảo nào':$data,
                'statusText' => 'success',
            );
        } catch (Exception $e) {
            $result = array(
                'status'     => 210,
                'data'       => 'Hệ thống dịch bị lỗi',
                'statusText' => 'error',
            );
        }
        return response()->json($result);
    }
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return void
     */

}
