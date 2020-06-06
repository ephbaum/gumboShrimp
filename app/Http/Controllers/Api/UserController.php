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
    private $user;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->user = $request->user;
        // use auth middleware except on the index route
        $this->middleware('auth:api');
    }

    public function index() 
    {
        return new UserResource(User::all());
    }

    /**
     *
     * @return \App\Models\User
    */
    public function current()
    {
        return $this->user;

    }
}
