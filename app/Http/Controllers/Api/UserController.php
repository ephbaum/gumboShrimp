<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class UserController extends Controller
{
    /** @var mixed */
    private $user;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->user = $request->user;
        
        $this->middleware('auth:api');
    }

    /**
     * display users
     *
     * @return \App\Models\User
     */
    public function index() 
    {
        return new UserResource(User::all());
    }

    /**
     * return the current user
     * 
     * @return \App\Models\User
    */
    public function current()
    {
        return $this->user;
    }
}
