<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
use App\Models\User;
=======
use App\User;
>>>>>>> c7135a1546a4ae7f76375929967a618f1dd17318
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;

<<<<<<< HEAD
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * register method
     *
     * @param Request $request
     * @return Response
     */
    public function register(Request $request)
    {
        // check if email is in use
        $user = User::where('email', $request->email)->first();
        if ($user) 
        {
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'This email is already registered, please login.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $verifyUser = User::where('email', $user->email)->first();

        if ($verifyUser) {
            return response()->json([
                'user' => $user,
                'message' => "{$user->name} successfully created.",
                'status' => Response::HTTP_CREATED,
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'message' => 'This email is not registered, please register'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * login method
     *
     * @param Request $request
     * @return void
     */
=======
class AuthController extends Controller
{
>>>>>>> c7135a1546a4ae7f76375929967a618f1dd17318
    public function login(Request $request)
    {
        
        // check if user exists
        $user = User::where('email', $request->email)->first();
<<<<<<< HEAD
        Log::debug('[AuthController]-> user check: ' .$user);
        
=======
        
        // if there is no user with that email, respond in kind
>>>>>>> c7135a1546a4ae7f76375929967a618f1dd17318
        if (!$user)                  
        {
            return response()->json([
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'This email is not registered, please register'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

<<<<<<< HEAD
        if (!Hash::check(request('password'), $user->password)) {
            Log::debug("AuthController->login  **failed Hash::check");

            if (Hash::needsRehash($user->password) ){
                $hashed = Hash::make(request('password'));
            }

            return response()->json([
=======
        // if password doesn't match, no soup for you
        if (!Hash::check(request('password'), $user->password)) {

            return response()->json()([
>>>>>>> c7135a1546a4ae7f76375929967a618f1dd17318
                'message' => 'Incorrect email or password',
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
            
<<<<<<< HEAD
        } else {
            Log::info("AuthController->login: hash checked");
        }

        // gather data to get access_token
        $data = [
                'grant_type' => 'password',
                'refresh_token' => 'your_refresh_token',
=======
        }

        // gather data to get access_token which allows user to login
        // note that Oauth is expecting username instead of email
        $data = [
                'grant_type' => 'password',
>>>>>>> c7135a1546a4ae7f76375929967a618f1dd17318
                'client_id' => config('services.passport.client_id'),
                'client_secret' => config('services.passport.client_secret'),
                'username' => $request->email,
                'password' => $request->password,
                'scope' => '',
            ];

<<<<<<< HEAD
        // Get access_token
        $request = Request::create('/oauth/token', 'POST', $data);
        Log::debug("$request");

        $response = app()->handle($request);

        if ($response->getStatusCode() != 200) {
            Log::debug("AuthController - login failed");

            return response()->json([
                'message' => 'Incorrect email or password - maybe both, or at least one(1).',
=======
            Log::debug($request->email);
            Log::debug($request->password);

        // Get access_token
        $request = Request::create('/oauth/token', 'POST', $data);
        Log::debug($request);

         
        $response = app()->handle($request);
        Log::debug($response);


        // if we get any other response than 200 (SUCCESS!), return that info to user
        if ($response->getStatusCode() != 200) {

            return response()->json([
                'message' => 'Unable to get a token. This is an error with passport.',
>>>>>>> c7135a1546a4ae7f76375929967a618f1dd17318
                'status' => $response->getStatusCode(),
            ], $response->getStatusCode());
        }
        // unpack the response
        $responseData = json_decode($response->getContent());

<<<<<<< HEAD
        Auth::login($user);

        // set user
        $user = Auth::User();

        Log::debug("logged in user: ");
        Log::debug($user);

        // set the token cookie
        $token_cookie = cookie(
            'tokenCookie',
            $responseData->access_token,
            null,
            null,
            null,
            true
        );

        // set the user cookie
        $user_cookie = cookie(
            'userCookie',
            $user,
            null,
            null,
            null,
            true
        );

        Cookie::queue($token_cookie);
        Cookie::queue($user_cookie);

=======
        // log the user in
        Auth::login($user);

        // set user var
        $user = Auth::User();

        // set the token cookie
        $token_cookie = cookie('tokenCookie', $responseData->access_token);

        // set the user cookie
        $user_cookie = cookie('userCookie', $user);

        // queue the cookies...  Heeeeere's the cookies!
        Cookie::queue($token_cookie);
        Cookie::queue($user_cookie);

        // return a JSON response
>>>>>>> c7135a1546a4ae7f76375929967a618f1dd17318
        return response()->json([
            'user' => $user,
            'token' => $responseData->access_token,
            'expires_in' => $responseData->expires_in,
            'message' => "{$user->name} successfully logged in.",
            'status' => Response::HTTP_OK,
<<<<<<< HEAD
        ], Response::HTTP_OK);
    }

    public function logout()
    {
        if (Auth::user()) {

            // fetch user's ID
            $accessToken = Auth::user()->token()->id;
            $currentId = DB::table('oauth_access_tokens')->where('id', $accessToken)->first()->user_id;

            // if logged in, delete access token
            if ($currentId) {
                DB::table('oauth_access_tokens')
                    ->where('user_id', $currentId)
                    ->delete();
            }
        }

        // return null
        return response()->json(null, 204);
    }
   
}
=======
        ]);
    }
}
>>>>>>> c7135a1546a4ae7f76375929967a618f1dd17318
