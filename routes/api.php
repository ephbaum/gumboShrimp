<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
<<<<<<< HEAD
Route::post('/login', 'Api\AuthController@login');
Route::post('/register', 'Api\AuthController@register');
Route::post('/logout', 'Api\AuthController@logout');
Route::resource('items', 'Api\ItemController');

Route::middleware('auth:api')->group(function () {
    
    Route::get('/user', 'Api\UsersController@current');
    Route::get('/users', 'Api\UsersController@index');
    
});
=======

Route::post('/login', 'Api\AuthController@login');
Route::post('/register', 'Api\AuthController@register');
Route::post('/logout', 'Api\AuthController@logout');

Route::resource('items', 'Api\ItemController');

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
>>>>>>> c7135a1546a4ae7f76375929967a618f1dd17318
