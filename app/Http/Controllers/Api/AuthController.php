<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        
        // check if user exists
        $user = User::where('email', $request->email)->first();
        
        // if there is no user with that email, respond in kind
        if (!$user)                  
        {
            return response()->json([
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'This email is not registered, please register'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // if password doesn't match, no soup for you
        if (!Hash::check(request('password'), $user->password)) {

            return response()->json([
                'message' => 'Incorrect password',
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
            
        }

        // gather data to get access_token which allows user to login
        // note that Oauth is expecting username instead of email
        $data = [
            'grant_type' => 'password',
            'client_id' => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
            'username' => $request->email,
            'password' => $request->password,
            'scope' => '',
        ];


        // Get access_token
        $request = Request::create('/oauth/token', 'POST', $data);
        
        $response = app()->handle($request);

        // if we get any other response than 200 (SUCCESS!), return that info to user
        if ($response->getStatusCode() != 200) {

            return response()->json([
                'message' => 'Unable to get a token. This is an error with passport.',
                'status' => $response->getStatusCode(),
            ], $response->getStatusCode());
        }
        // unpack the response
        $responseData = json_decode($response->getContent());

        // log the user in
        Auth::login($user);

        // reset user var
        $user = Auth::User();

        // set the token cookie
        $token_cookie = cookie('tokenCookie', $responseData->access_token);

        // set the user cookie
        $user_cookie = cookie('userCookie', $user);

        // queue the cookies...  Heeeeere's the cookies!
        Cookie::queue($token_cookie);
        Cookie::queue($user_cookie);

        // return a JSON response
        return response()->json([
            'user' => $user,
            'token' => $responseData->access_token,
            'expires_in' => $responseData->expires_in,
            'message' => "{$user->name} successfully logged in.",
            'status' => Response::HTTP_OK,
        ]);
    }
}
