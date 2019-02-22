<?php
namespace App\Modules\User\Controllers;

use App\Http\Controllers\ControllerUser;
use Auth;
use DAO;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Intervention\Image\ImageManager;
use Mail;
use SQLXML;
use Common;

class CommonController extends ControllerUser
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

    public function getComment(Request $request)
    {
        $param            = $request->all();
        $param[2]         = $this->hashids->decode($param[2])[0];
        if(Auth::user()!=null){
            $param['user_id'] = Auth::user()->account_nm;
        }else{
            $param['user_id'] = '';
        }
        $data             = Dao::call_stored_procedure('SPC_COM_GET_PAGE_COMMENT', $param);
        // var_dump($data);die;
        $data             = $this->encodeID($data);
        $view1            = view($param[1]!=8?'comment':'answer')->with('data', $data)->render();
        $view2            = view('paging_content')->with('data', $data)->render();
        $result           = array(
            'status'     => 200,
            'view1'      => $view1,
            'view2'      => $view2,
            'statusText' => 'success',
        );
        return response()->json($result);
    }

    public function changePass(Request $request)
    {
        $input = $request->all();
        try {
            Mail::send('Master::common.changepass', array('username' => $input["username"], 'password' => $this->generatePass())
                , function ($message) {
                    $message->to('ndq809@gmail.com', 'Quy pro')->subject('Hệ Thống Eplus - Đổi Mật Khẩu');
                });
            $result = array(
                'status'     => 200,
                'statusText' => 'success',
            );
        } catch (\Exception $e) {
            $result = array(
                'status'     => 208,
                'statusText' => 'Lỗi hệ thống',
            );
        }

        return response()->json($result);
        // return view('Master::common.changepass');
    }

    public function generatePass()
    {
        $pass      = '';
        $alphabetL = "abcdefghijklmnopqrstuwxyz";
        $alphabetU = "ABCDEFGHIJKLMNOPQRSTUWXYZ";
        $number    = "0123456789";
        $special   = "@%+\/!#$^?:.(){}[]~–_";
        for ($i = 0; $i < 8; $i++) {
            if ($i == 0) {
                $n = substr($alphabetU, rand(0, strlen($alphabetU) - 1), 1);
            } elseif ($i == 4) {
                $n = substr($special, rand(0, strlen($special) - 1), 1);
            } elseif ($i == 7) {
                $n = substr($number, rand(0, strlen($number) - 1), 1);
            } else {
                $n = substr($alphabetL, rand(0, strlen($alphabetL) - 1), 1);
            }
            $pass .= $n;
        }
        return $pass;
    }

    public function getcatalogue(Request $request)
    {
        $data   = $request->all();
        $data   = Dao::call_stored_procedure('SPC_COMMON_CATALORUE', $data);
        $data   = $this->encodeID($data);
        $result = array(
            'status'     => 200,
            'data'       => $data[0],
            'statusText' => 'success',
        );
        return response()->json($result);

    }

    public function getgroup(Request $request)
    {
        $data   = $request->all();
        $data   = $this->hashids->decode($data['data']);
        $data   = Dao::call_stored_procedure('SPC_COMMON_GROUP', $data);
        $data   = $this->encodeID($data);
        $result = array(
            'status'     => 200,
            'data'       => $data[0],
            'statusText' => 'success',
        );
        return response()->json($result);

    }

    public function getGrammarSuggest(Request $request)
    {
        $data   = Dao::call_stored_procedure('SPC_COMMON_GET_SUGGEST');
        $data   = $this->encodeID($data);
        $result = array(
            'status'     => 200,
            'data'       => $data,
            'statusText' => 'success',
        );
        return response()->json($result);

    }

    public function addLesson(Request $request)
    {
        $param            = $request->all();
        $param[1]         = $this->hashids->decode($param[1])[0];
        $param[2]         = $this->hashids->decode($param[2])[0];
        $param['user_id'] = Auth::user()->account_nm;
        $param['ip']      = $request->ip();
        $data             = Dao::call_stored_procedure('SPC_COM_ADD_LESSON', $param);
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
            foreach ($data[1] as $key => $value) {
                $data[1][$key]['id']     = $this->hashids->encode($value['id']);
                $data[1][$key]['item_1'] = $this->hashids->encode($value['item_1']);
                $data[1][$key]['item_2'] = $this->hashids->encode($value['item_2']);
            }
            $result = array(
                'status'     => 200,
                'data'       => $data[1],
                'statusText' => 'success',
            );
        }

        return response()->json($result);
    }

    public function deleteLesson(Request $request)
    {
        $param            = $request->all();
        $param[0]         = $this->hashids->decode($param[0])[0];
        $param['user_id'] = Auth::user()->account_nm;
        $param['ip']      = $request->ip();
        $data             = Dao::call_stored_procedure('SPC_COM_DELETE_LESSON', $param);
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
                'data'       => $data[0],
                'statusText' => 'success',
            );
        }

        return response()->json($result);
    }

    public function remembervoc(Request $request)
    {
        $param            = $request->all();
        $param[3]         = $this->hashids->decode($param[3])[0];
        $param['user_id'] = Auth::user()->account_nm;
        $param['ip']      = $request->ip();
        $data             = Dao::call_stored_procedure('SPC_COM_REMEMBER', $param);
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
                'data'       => $data[0],
                'statusText' => 'success',
            );
        }

        return response()->json($result);
    }

    public function forgetvoc(Request $request)
    {
        $param    = $request->all();
        $param[1] = $this->hashids->decode($param[1])[0];
        $param['user_id'] = Auth::user()->account_nm;
        $data     = Dao::call_stored_procedure('SPC_COM_FORGET', $param);
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
                'data'       => $data,
                'statusText' => 'success',
            );
        }

        return response()->json($result);
    }

    public function getExample(Request $request)
    {
        $param            = $request->all();
        $param[1]         = $this->hashids->decode($param[1])[0];
        if(Auth::user()!=null){
            $param['user_id'] = Auth::user()->account_nm;
        }else{
            $param['user_id'] = '';
        }
        $data             = Dao::call_stored_procedure('SPC_COM_EXAM_LIST', $param);
        $data             = $this->encodeID($data);
        $view1            = view('exam_content')->with('data', $data)->render();
        $view2            = view('paging_content')->with('data', $data)->render();
        $result           = array(
            'status'     => 200,
            'view1'      => $view1,
            'view2'      => $view2,
            'statusText' => 'success',
        );
        return response()->json($result);
    }

    public function addExample(Request $request)
    {
        $param            = $request->all();
        $param[1]         = $this->hashids->decode($param[1])[0];
        $param['user_id'] = Auth::user()->account_nm;
        $param['ip']      = $request->ip();
        $data             = Dao::call_stored_procedure('SPC_COM_ADD_EXAM', $param);
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
                'statusText' => 'success',
            );
        }

        return response()->json($result);
    }

    public function addQuestion(Request $request)
    {
        $param            = $request->all();
        if (common::checkValidate($request->all())['result']) {
            if (isset($param['tag'])) {
                for ($i = 0; $i < count($param['tag']); $i++) {
                    if (isset($param['tag'][$i]['tag_id'])) {
                        $param['tag'][$i]['tag_id'] = $this->hashids->decode($param['tag'][$i]['tag_id'])[0];
                    }
                }
            }
            $xml              = new SQLXML();
            $param['id']         = $param['id']!=''?$this->hashids->decode($param['id'])[0]:'';
            $param['tag'] = $xml->xml(isset($param['tag'])?$param['tag']:array());
            $param['user_id'] = Auth::user()->account_nm;
            $param['ip']      = $request->ip();
            // var_dump($param);die;
            $data             = Dao::call_stored_procedure('SPC_COM_ADD_QUESTION', $param);
            $data             = $this->encodeID($data);
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
                    'data'       => $data[1],
                    'statusText' => 'success',
                );
            }
        } else {
           $result = array('error'    => common::checkValidate($request->all())['error'],
                'status'     => 201,
                'statusText' => 'validate failed');
        }
        return response()->json($result);
    }

    public function addReport(Request $request)
    {
        $param            = $request->all();
        $param[1]         = $this->hashids->decode($param[1])[0];
        $param['user_id'] = Auth::user()->account_nm;
        $param['ip']      = $request->ip();
        $data             = Dao::call_stored_procedure('SPC_COM_ADD_REPORT', $param);
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
                'statusText' => 'success',
            );
        }

        return response()->json($result);
    }

    public function addComment(Request $request)
    {
        $param            = $request->all();
        $param[2]         = $this->hashids->decode($param[2])[0];
        $param[4]         = $param[4]!=''?$this->hashids->decode($param[4])[0]:'';
        $param['user_id'] = Auth::user()->account_nm;
        $param['ip']      = $request->ip();
        $param['cmt_div'] = isset($param[5])?$param[5]:1;
        unset($param[5]);
        $data             = Dao::call_stored_procedure('SPC_COM_ADD_COMMENT', $param);
        if ($data[1][0]['Data'] == 'Exception' || $data[1][0]['Data'] == 'EXCEPTION') {
            $result = array(
                'status' => 208,
                'data'   => $data[1],
            );
        } else if ($data[1][0]['Data'] != '') {
            $result = array(
                'status' => 207,
                'data'   => $data[0],
            );
        } else {
            $data             = $this->encodeID($data);
            $view = view($param[1]!=8?'comment':'answer')->with('data', $data)->with('cmt_div', $data[0][0]['cmt_div'])->render();
            $result = array(
                'status'     => 200,
                'view'       => $view,
                'statusText' => 'success',
            );
        }

        return response()->json($result);
    }

    public function deletePost(Request $request)
    {
        $param            = $request->all();
        $param['post_id'] = $param['post_id'] != '' ? $this->hashids->decode($param['post_id'])[0] : '';
        $param['user_id'] = isset(Auth::user()->account_nm) ? Auth::user()->account_nm : '';
        $param['ip']      = $request->ip();
        $data             = Dao::call_stored_procedure('SPC_COM_DELETE_POST', $param);
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
                'statusText' => 'success',
            );
        }
        return response()->json($result);
    }

    public function loadMoreComment(Request $request)
    {
        $param            = $request->all();
        $param[0]         = $this->hashids->decode($param[0])[0];
        $temp = isset($param[2])?$param[2]:0;
        $param['user_id'] = isset(Auth::user()->account_nm) ? Auth::user()->account_nm : '';
        unset($param[2]);
        $data             = Dao::call_stored_procedure('SPC_COM_GET_MORE_COMMENT', $param);
        if ($data[1][0]['Data'] == 'Exception' || $data[1][0]['Data'] == 'EXCEPTION') {
            $result = array(
                'status' => 208,
                'data'   => $data[1],
            );
        } else if ($data[1][0]['Data'] != '') {
            $result = array(
                'status' => 207,
                'data'   => $data[0],
            );
        } else {
            $data             = $this->encodeID($data);
            $view = view($temp!=8?'comment':'answer')->with('data', $data)->with('cmt_div', $data[0][0]['cmt_div'])->render();
            $result = array(
                'status'     => 200,
                'view'       => $view,
                'data'       => $data[0],
                'statusText' => 'success',
            );
        }

        return response()->json($result);
    }

    public function toggleEffect(Request $request)
    {
        $param            = $request->all();
        $param[1]         = $this->hashids->decode($param[1])[0];
        $param['user_id'] = Auth::user()->account_nm;
        $param['ip']      = $request->ip();
        $data             = Dao::call_stored_procedure('SPC_COM_TOGGLE_EFFECT', $param);
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
                'data'       => $data[1],
                'statusText' => 'success',
            );
        }

        return response()->json($result);
    }

    public function getQuestion(Request $request)
    {
        $param            = $request->all();
        $param[0]         = $this->hashids->decode($param[0])[0];
        $data             = Dao::call_stored_procedure('SPC_COM_QUESTION_LIST', $param);
        $data             = $this->encodeID($data);
        $view1            = view('practice')->with('data', $data[0])->render();
        $result           = array(
            'status'     => 200,
            'view1'      => $view1,
            'data'       => $data[0],
            'statusText' => 'success',
        );
        return response()->json($result);
    }

    public function postUpload()
    {
        $form_data = Input::all();

        // $validator = Validator::make($form_data, Image::$rules, Image::$messages);

        // if ($validator->fails()) {

        //     return Response::json([
        //         'status' => 'error',
        //         'message' => $validator->messages()->first(),
        //     ], 200);

        // }

        $photo = $form_data['img'];
        $original_name = $photo->getClientOriginalName();
        $original_name_without_ext = substr($original_name, 0, strlen($original_name) - 4);

        $filename = $this->sanitize($original_name_without_ext);
        $allowed_filename = $this->createUniqueFilename( $filename );

        $filename_ext = $allowed_filename .'_'.date("Ymd HHmmss").round(microtime(true) * 1000).'.jpg';

        $manager = new ImageManager();
        $image = $manager->make( $photo->getRealPath() )->encode('jpg')->save((public_path('web-content/images/vocabulary')).'/'  . $filename_ext ,100);
        if( !$image) {

            return Response::json([
                'status' => 'error',
                'message' => 'Server error while uploading',
            ], 208);

        }

        // $database_image = new Image;
        // $database_image->filename      = $allowed_filename;
        // $database_image->original_name = $original_name;
        // $database_image->save();
        return Response::json([
            'status'    => 'success',
            'url'       => '/web-content/images/vocabulary/' . $filename_ext,
            'width'     => $image->width(),
            'height'    => $image->height()
        ], 200);
    }


    public function postCrop()
    {
        $form_data = Input::all();
        $image_url = $form_data['imgUrl'];
        // var_dump($form_data);die;
        // resized sizes
        $imgW = $form_data['imgW'];
        $imgH = $form_data['imgH'];
        // offsets
        $imgY1 = $form_data['imgY1'];
        $imgX1 = $form_data['imgX1'];
        // crop box
        $cropW = $form_data['width'];
        $cropH = $form_data['height'];
        // rotation angle
        $angle = $form_data['rotation'];
        $filename_array = explode('/', $image_url);
        $filename = $filename_array[sizeof($filename_array)-1];
        $filename_ext = 'croped_' . uniqid() . '.jpg';
        $manager = new ImageManager();
        if(strpos($image_url,'http')!==false){
            $image = $manager->make($image_url);
        }else{
            $image = $manager->make( public_path($image_url) );
        }   
        $image->resize($imgW, $imgH)
            // ->rotate(-$angle)
            ->crop($cropW, $cropH, $imgX1, $imgY1)
            ->save((public_path('web-content/images/vocabulary')).'/'  . $filename_ext ,100);

        if( !$image) {

            return Response::json([
                'status' => 'error',
                'message' => 'Server error while uploading',
            ], 208);

        }
        if(strpos($image_url,'http')!==false){
            File::delete((public_path('web-content/images/vocabulary/'))  . $filename);
        }
        return Response::json([
            'status' => 'success',
            'url' => '/web-content/images/vocabulary/' . $filename_ext
        ], 200);

    }

    public function postCropDelete(Request $request)
    {
        $data = $request->all();
        File::delete((public_path('web-content/images/vocabulary/'))  . explode('/',$data['image'])[2]);
        return Response::json([
            'status' => 'success',
        ], 200);

    }

    private function sanitize($string, $force_lowercase = true, $anal = false)
    {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;

        return ($force_lowercase) ?
        (function_exists('mb_strtolower')) ?
        mb_strtolower($clean, 'UTF-8') :
        strtolower($clean) :
        $clean;
    }

    private function createUniqueFilename($filename)
    {
        $upload_path     = env('UPLOAD_PATH');
        $full_image_path = $upload_path . $filename . '.jpg';

        if (File::exists($full_image_path)) {
            // Generate token for image
            $image_token = substr(sha1(mt_rand()), 0, 5);
            return $filename . '-' . $image_token;
        }

        return $filename;
    }
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return void
     */

    public static function encodeID($data)
    {
        $hashids = new Hashids();
        foreach ($data as $key => $value) {
            foreach ($value as $key1 => $value1) {
                foreach ($value1 as $key2 => $value2) {
                    if($key2!='row_id' && strpos($key2, 'id')!==false || strpos($key2, 'value')!==false){
                        $data[$key][$key1][$key2] = $hashids->encode($value2);
                    }
                }
                
            }
        }
        return $data;
    }

}
