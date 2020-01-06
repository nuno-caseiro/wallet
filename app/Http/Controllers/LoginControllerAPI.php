<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
define('YOUR_SERVER_URL', env('APP_URL'));
// Check "oauth_clients" table for next 2 values:
define('CLIENT_ID', env('CT_ID'));
define('CLIENT_SECRET',env('PASSPORT_SECRET'));

class LoginControllerAPI extends Controller
{
    public function login(Request $request)
    {
        $http = new \GuzzleHttp\Client;
        $user = User::where('email', '=', $request->email)->firstOrFail();
        if($user->active===1){
            // try {
                $response = $http->post(YOUR_SERVER_URL.'/oauth/token', [
                    'form_params' => [
                        'grant_type' => 'password',
                        'client_id' => CLIENT_ID,
                        'client_secret' => CLIENT_SECRET,
                        'username' => $request->email,
                        'password' => $request->password,
                        'scope' => ''
                    ],
                    'exceptions' => false,
                ]);     
        $errorCode= $response->getStatusCode();
        if ($errorCode=='200') {
            return json_decode((string) $response->getBody(), true);
        } else {
            return response()->json(
                ['msg'=>'User credentials are invalid'], $errorCode);
        }
     
    }else{
        return response()->json(['error' => 'You are currently deactivated.'], 401);
    }
    }

    public function logout()
    {
      /*  dd(auth());
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return response()->json('Logged out successfully', 200);*/
        \Auth::guard('api')->user()->token()->revoke();
        \Auth::guard('api')->user()->token()->delete();
        return response()->json(['msg'=>'Token revoked'], 200);
    }





}
