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

// 下記は削除する
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'App\Http\Controllers\ItemController@index');
Route::get('/item/{item}', 'App\Http\Controllers\ItemController@show');
Route::post('/cartitem', 'App\Http\Controllers\CartItemController@store');
Route::get('/cartitem', 'App\Http\Controllers\CartItemController@index');
Route::delete('/cartitem/{cartItem}', 'App\Http\Controllers\CartItemController@destroy');
Route::put('/cartitem/{cartItem}', 'App\Http\Controllers\CartItemController@update');

Route::get('/buy', 'App\Http\Controllers\BuyController@index');
Route::post('/buy', 'App\Http\Controllers\BuyController@store');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');