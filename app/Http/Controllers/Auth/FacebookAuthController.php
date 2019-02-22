<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\ControllerUser;
use App\User;
use Socialite;
use Auth;
use DAO;
use Session;

class FacebookAuthController extends ControllerUser
{
    public function redirectToProvider()
    {
    	// var_dump(1);die;
        return Socialite::driver('facebook')->redirect();
    }
 
    /**
     * Obtain the user information from facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('facebook')->scopes([
            "publish_actions, manage_pages", "publish_pages"])->user();
        $authUser = $this->findOrCreateUser($user);
        if(isset($authUser->user_id)){
            $remember_me = true;
            $year = time() + 31536000;
            $data   = Dao::call_stored_procedure('SPC_COMMON_ACCOUNT', array($authUser->user_id,$authUser->system_div));
            Session::put('logined_data',$data[0]);
            Auth::login($authUser, true);
            $authUser->session_id = \Session::getId();
            $authUser->save();
            return redirect(url()->previous());
        }else{
            return redirect()->action(
                '\App\Modules\User\Controllers\RegisterController@getIndex', ['default_data' => $authUser]
            );
        }
    }
 
    private function findOrCreateUser($facebookUser){
        $authUser = User::where('social_id', $facebookUser->id)->first();
 
        if($authUser){
            return $authUser;
        }
 
        return $facebookUser;
    }
}
