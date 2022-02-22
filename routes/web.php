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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');