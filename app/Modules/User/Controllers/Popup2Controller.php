<?php
namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use CommonUser;
use DAO;
use Hashids\Hashids;
use Illuminate\Http\Request;

class Popup2Controller extends Controller
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
    public function getIndex()
    {
        return view('User::popup.p002.index');
    }

    public function p001_search(Request $request)
    {
        $param = $request->all();
        if (isset($param['selected_list'][0])) {
            for ($i = 0; $i < count($param['selected_list']); $i++) {
                $param['selected_list'][$i]['id'] = $this->hashids->decode($param['selected_list'][$i]['id'])[0];
            }
        }
        $param['selected_list'] = json_encode(isset($param['selected_list'][0]) ? $param['selected_list'] : array());
        $data  = Dao::call_stored_procedure('SPC_USER_P001_LST1', $param);
        $data  = CommonUser::encodeID($data);
        return view('User::popup.p001.search')
            ->with('data', $data)
            ->with('paging', $data[1][0]);
    }

    public function p001_load(Request $request)
    {
        $param = $request->all();
        if (isset($param['voc_array'])) {
            for ($i = 0; $i < count($param['voc_array']); $i++) {
                $param['voc_array'][$i]['id'] = $this->hashids->decode($param['voc_array'][$i]['id'])[0];
            }
        }
        $param['voc_array'] = json_encode(isset($param['voc_array']) ? $param['voc_array'] : array());
        $data               = Dao::call_stored_procedure('SPC_USER_P001_LST2', $param);
        $data               = CommonUser::encodeID($data);
        return view('User::popup.p001.select')
            ->with('data', $data[0]);
    }

    public function p001_refer(Request $request)
    {
        $data = $request->except('row_id_parent');
        if (isset($data)) {
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]['id'] = $this->hashids->decode($data[$i]['id'])[0];
            }
        }
        $param['voc_array'] = json_encode(isset($data) ? $data : array());
        $param['row_id_parent'] = $request->input('row_id_parent');
        $result             = Dao::call_stored_procedure('SPC_USER_P001_LST3', $param);
        $result             = CommonUser::encodeID($result);
        $view               = view('User::writing.add_vocabulary')->with('data', $result[0])->render();
        return response()->json(array(
            'view'       => $view,
            'data'       => $result[0][0],
            'row_id'       => $result[1][0]['row_id'],
            'statusText' => 'success',
        ));
    }
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return void
     */

}
