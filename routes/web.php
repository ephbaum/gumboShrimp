<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Auth::routes();

<<<<<<< HEAD
Route::get('/{any}', 'SpaController@index')->where('any', '.*');
// Route::get('/', function () {
//     return view('welcome');
// });

// Route::resource('/api/items', 'Api\ItemController');
// Route::get('/home', 'HomeController@index')->name('home');
=======
Route::get('/', 'SpaController@index');
>>>>>>> c7135a1546a4ae7f76375929967a618f1dd17318
