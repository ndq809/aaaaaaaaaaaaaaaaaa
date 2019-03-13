<?php
 
namespace App\Http\Controllers;
 
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class GraphController extends Controller
{
    private $api;
    public function __construct(Facebook $fb)
    {
        $this->middleware(function ($request, $next) use ($fb) {
            $fb->setDefaultAccessToken(Auth::user()->social_token);
            $this->api = $fb;
            return $next($request);
        });
    }
 
    public function retrieveUserProfile(){
        try {
 
            $params = "first_name,last_name,age_range,gender";
 
            $user = $this->api->get('/me?fields='.$params)->getGraphUser();
 
            dd($user);
 
        } catch (FacebookSDKException $e) {
 
        }
 
    }

    public function publishToProfile(Request $request){
	    try {
	        $response = $this->api->post('/me/feed', [
	            'message' => $request->message
	        ])->getGraphNode()->asArray();
	        if($response['id']){
	           // post created
	        }
	    } catch (FacebookSDKException $e) {
	        throw new \Exception($e);
	    }
	}
}