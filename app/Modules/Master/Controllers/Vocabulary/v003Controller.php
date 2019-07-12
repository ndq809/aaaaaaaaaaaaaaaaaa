<?php
namespace App\Modules\Master\Controllers\Vocabulary;

use App\Http\Controllers\Controller;
use Auth;
use Common;
use DAO;
use File;
use Illuminate\Http\Request;
use Illuminate\Cookie\CookieJar;

class v003Controller extends Controller
{
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $filename = public_path('/web-content/dictonary/en_vi.txt');
        try
        {
            $file     = fopen($filename, "r");
            fclose($file);
            return view('Master::vocabulary.v003.index');
        } catch (Illuminate\Contracts\Filesystem\FileNotFoundException $exception) {
            return view('Master::vocabulary.v003.index')->with('condition', 'File không tồn tại');
            // die("The file doesn't exist");
        }
    }

    public function v003_read(Request $request)
    {
        $page     = $request->input('page');
        $count    = 0;
        $filename = public_path('/web-content/dictonary/en_vi.txt');
        $file     = fopen($filename, "r");
        $data= [];
        while (!feof($file)) {
            if($count<$page * 10){
                $count++;
                fgets($file);
                continue;
            }
            if ($count < ($page * 10) + 10) {
                array_push($data,fgets($file));

            } else {
                break;
            }
            $count++;
        }
        fclose($file);
        $result = array(
                    'status'     => 200,
                    'data'       => $data,
                    'statusText' => 'success',
                );
        return response()->json($result);
    }

    public function v003_save(Request $request)
    {
        $data  = $request->except('page');
        $page = $request->input('page');
        $validate = common::checkValidate($data);
        if ($validate['result']) {
            $param['json_detail'] = json_encode($data);
            $param['user_id']    = Auth::user()->account_id;
            $param['ip']         = $request->ip();

            $data = Dao::call_stored_procedure('SPC_v003_ACT1', $param);
            if ($data[0][0]['Data'] == 'Exception' || $data[0][0]['Data'] == 'EXCEPTION') {
                $result = array(
                    'status' => 208,
                    'data'   => $data[0],
                );
            } else if ($data[0][0]['Data'] != '') {
                $result = array(
                    'status' => 207,
                    'data'   => $data[0],
                );
            } else {
                $year = time() + 31536000;
                setcookie('page_readed', $page+1, $year);
                $result = array(
                    'status'     => 200,
                    'statusText' => 'success',
                );
            }
        } else {
            $result = array('error' => $validate['error'],
                'status'                => 201,
                'statusText'            => 'validate failed');
        }
        return response()->json($result);
    }

    public function v003_refer(Request $request)
    {
        $data         = $request->all();
        $result_query = DAO::call_stored_procedure("SPC_v003_LST1", $data);
        // var_dump($result_query[1][0]['vocabulary_div']);die;
        return view('Master::vocabulary.v003.refer')->with('data', $result_query);
    }

    public function v003_getAutocomplete(Request $request)
    {
        $param = $request->all();
        $data  = Dao::call_stored_procedure('SPC_v003_LST2', $param);
        return response()->json($data[0]);
    }

    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return void
     */

}
