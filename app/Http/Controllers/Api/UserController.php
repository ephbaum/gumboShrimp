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
        
        $currentUser = Auth::user();

        return new UserResource($currentUser);

    }
}
