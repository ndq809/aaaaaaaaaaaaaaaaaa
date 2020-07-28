<?php
namespace App\Modules\Master\Controllers\Writing;

use App\Http\Controllers\Controller;
use Auth;
use Common;
use DAO;
use File;
use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;

class w004Controller extends Controller
{
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */

    private $tr;

    public function __construct()
    {
        $this->tr      = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default
        $this->tr->setSource('en'); // Translate from English
        // $this->$tr->setSource(); // Detect language automatically
        $this->tr->setTarget('vi'); // Translate to Georgian
    }

    public function getIndex()
    {
        $data = Dao::call_stored_procedure('SPC_W004_LST1');
        return view('Master::writing.w004.index')->with('data', $data);
    }

    public function w004_read(Request $request)
    {
        $file_upload = $request->file('post_file');
        if (!is_null($file_upload)) {
            if ($file_upload->getClientSize() > 20971520) {
                $result = array(
                    'status'     => 209,
                    'statusText' => 'upload failed');
                return response()->json($result);
            }
            $name = 'file_' . uniqid() . '.' . $file_upload->getClientOriginalExtension();
            $file_upload->move(public_path('/web-content/file/temp/'), $name);
            $media = '/web-content/file/temp/' . $name;
        }
        $file = fopen(public_path($media), "r");
        $data = [];
        $temp=[];
        $text='';
        while (!feof($file)) {
            $value = trim(fgets($file));
            switch (substr($value, 0,3)) {
                case '###':
                    $temp['title']=str_replace('|||','',$text);
                    $text='';
                    break;
                case '&&&':
                    $temp['en_content']=str_replace('|||','',$text);
                    $text='';
                    break;
                case '$$$':
                    if(isset($temp['en_content'])){
                        $temp['vi_content']=str_replace('|||','',$text);
                    }else{
                        $temp['en_content']=str_replace('|||','',$text);
                    }
                    $text='';
                    break;
                case '***':
                    $vocalArray=explode('|||',$text);
                    $vocalTemp1=[];
                    $temp['vocabulary']=[];
                    for ($i=1; $i <count($vocalArray) ; $i++) { 
                        $vocalTemp1['vocal_en']=trim(substr($vocalArray[$i], strpos($vocalArray[$i], '.')+1,(strpos($vocalArray[$i], '(')?strpos($vocalArray[$i], '('):strpos($vocalArray[$i], ':'))-strpos($vocalArray[$i], '.')-1));
                        $vocalTemp1['vocal_vi']=trim(substr($vocalArray[$i], strpos($vocalArray[$i], ':')+1));
                        array_push($temp['vocabulary'], $vocalTemp1);
                    }
                    array_push($data, $temp);
                    $text='';
                    $temp=[];
                    break;
                default:
                    $text=$text.'|||'.$value;
                    break;
            }
        }
        fclose($file);
        File::delete(public_path($media));
        $data_default = Dao::call_stored_procedure('SPC_W004_LST1');
        $view        = view('Master::writing.w004.refer')->with('result', $data[0])->with('data', $data_default)->with('index', 1)->render();
        $result = array(
            'status'     => 200,
            'data'       => $data,
            'view'       => $view,
            'statusText' => 'success',
        );
        return response()->json($result);
    }

    public function autoTranslate(Request $request)
    {
        $param = $request->all();
        try {
            $title  = $this->tr->translate($param['title']);
            $text   = $this->tr->translate($param['text']);
            $result = array(
                'status'     => $text == null ? 211 : 200,
                'title'      => $title == null ? 'Không có bản dịch tham khảo nào' : $title,
                'text'       => $text == null ? 'Không có bản dịch tham khảo nào' : $text,
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

    public function w004_save(Request $request)
    {
        $param    = $request->except('detail');
        $detail   = $request->input('detail');
        $validate = common::checkValidate($param);
        if ($validate['result']) {
            $param['json_detail'] = json_encode($detail);
            $param['user_id']     = Auth::user()->account_id;
            $param['ip']          = $request->ip();

            $data = Dao::call_stored_procedure('SPC_W004_ACT1', $param);
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
                $result = array(
                    'status'     => 200,
                    'post_id'    => $data[1][0]['post_id'],
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

    public function w004_refer(Request $request)
    {
        $data         = $request->all();
        $result_query = DAO::call_stored_procedure("SPC_w004_LST1", $data);
        // var_dump($result_query[1][0]['writing_div']);die;
        return view('Master::writing.w004.refer')->with('data', $result_query);
    }

    public function w004_getAutocomplete(Request $request)
    {
        $param = $request->all();
        $data  = Dao::call_stored_procedure('SPC_W004_LST2', $param);
        return response()->json($data[0]);
    }

    public function w004_getPost(Request $request)
    {
        $param = $request->all();
        $data_default = Dao::call_stored_procedure('SPC_W004_LST1');
        return view('Master::writing.w004.refer')->with('result', $param['data'])->with('data', $data_default)->with('index', $param['index']);
        // $result = array(
        //     'status'     => 200,
        //     'data'       => $data,
        //     'view'       => $view,
        //     'statusText' => 'success',
        // );
        // return response()->json($result);
    }

    public function w004_getcatalogue(Request $request)
    {
        $data         = $request->all();
        $result_query = Dao::call_stored_procedure('SPC_W004_LST1');
        $result       = array(
            'status'     => 200,
            'data'       => $result_query,
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
