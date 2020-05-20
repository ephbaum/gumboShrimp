<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class SpaController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
<<<<<<< HEAD
        Log::debug('SpaController->index()');
        return view('spa');
=======
        return view('home');
>>>>>>> c7135a1546a4ae7f76375929967a618f1dd17318
    }

    public function notFound()
    {
<<<<<<< HEAD
        Log::debug('SpaController->notFound()');
        return view('spa');
=======
        return view('home');
>>>>>>> c7135a1546a4ae7f76375929967a618f1dd17318
    }
}
