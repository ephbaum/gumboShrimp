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

Route::post('/login', 'Api\AuthController@login');
Route::post('/register', 'Api\AuthController@register');
Route::post('/logout', 'Api\AuthController@logout');

Route::get('/user', 'Api\UserController@current');

Route::resource('items', 'Api\ItemController');
Route::resource('orders', 'Api\OrderController');

Route::get('/orders', 'Api\OrderController@index');
Route::delete('/orders/{id}', 'Api\OrderController@destroy');
Route::post('/purchase', 'Api\OrderController@purchase');

Route::middleware('auth:api')->group(function () {
    Route::get('/user', 'Api\UserController@current');
});