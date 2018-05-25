<?php
namespace App\Modules\User\Controllers;

use App\Http\Controllers\ControllerUser;
use Illuminate\Http\Request;
use Mail;
use DAO;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\File;

class CommonController extends ControllerUser
{
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return \Illuminate\Http\Response
     */
    

    public function getComment()
    {
        // try {
        //     $temp=DAO::call_stored_procedure('getData1');
        // } catch (\Exception $e) {
        //     echo($e->getMessage());
            
        // }
        return view('comment');
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
        $image = $manager->make( $photo )->encode('jpg')->save((public_path('uploads')).'/'  . $filename_ext );
        // var_dump(public_path('uploads'));die;
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
            'url'       => 'uploads/' . $filename_ext,
            'width'     => $image->width(),
            'height'    => $image->height()
        ], 200);
    }


    public function postCrop()
    {
        $form_data = Input::all();
        $image_url = $form_data['imgUrl'];

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

        $manager = new ImageManager();
        $image = $manager->make( $image_url );
        $image->resize($imgW, $imgH)
            ->rotate(-$angle)
            ->crop($cropW, $cropH, $imgX1, $imgY1)
            ->save((public_path('uploads')).'/cropped-'  . $filename);

        if( !$image) {

            return Response::json([
                'status' => 'error',
                'message' => 'Server error while uploading',
            ], 208);

        }

        return Response::json([
            'status' => 'success',
            'url' => env('URL') . 'uploads/cropped-' . $filename
        ], 200);

    }


    private function sanitize($string, $force_lowercase = true, $anal = false)
    {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;

        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }


    private function createUniqueFilename( $filename )
    {
        $upload_path = env('UPLOAD_PATH');
        $full_image_path = $upload_path . $filename . '.jpg';

        if ( File::exists( $full_image_path ) )
        {
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

}
