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
        if($authUser->block_div!=''){
            return redirect()->back()->with('error', ['status'       => 205,
                                                      'statusText'   => 'account blocked']);
        }
        if(isset($authUser->user_id)){
            $remember_me = true;
            $year = time() + 31536000;
            $data   = Dao::call_stored_procedure('SPC_COMMON_ACCOUNT', array($authUser->user_id,$authUser->system_div));
            Session::put('logined_data',$data[0]);
            Session::put('social_token',$authUser->token);
            Auth::login($authUser, true);
            $authUser->session_id = \Session::getId();
            $authUser->save();
            return redirect(url()->previous());
        }else{
            Session::put('accepted_data',$authUser);
            return redirect()->route('register');
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
