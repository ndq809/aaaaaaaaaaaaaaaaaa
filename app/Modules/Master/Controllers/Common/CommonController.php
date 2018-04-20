<?php
namespace App\Modules\Master\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use DAO;

class CommonController extends Controller
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
                'status'     => 201,
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
    /**
     * Show the application index.
     * @author mail@ans-asia.com
     * @created at 2017-08-16 03:29:46
     * @return void
     */

}
