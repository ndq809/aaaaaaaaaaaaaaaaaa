<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\ControllerUser;
use Auth;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;

class GraphController extends ControllerUser
{

    private $api;
    public function __construct()
    {
        $config = config('services.facebook');
            $fb= new Facebook([
                'app_id' => $config['client_id'],
                'app_secret' => $config['client_secret'],
                'default_graph_version' => 'v2.6',
            ]);
        $this->middleware(function ($request, $next) use ($fb) {
            $fb->setDefaultAccessToken(Auth::user()->social_token);
            $this->api = $fb;
            return $next($request);
        });
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
            var_dump($e->getmessage()); // handle exception
        }
    }
}
