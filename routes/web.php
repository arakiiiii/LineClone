<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/line', 'LineHomeController@index')->name('home');

Route::get('line/logout','LineController@logout');
Route::get('line/users','LineUsersController@users');
Route::get('line/mypage','LineMypageController@mypage');

Route::post('line/edit','LineMypageController@edit');
Route::post('line/befriend','LineUsersController@befriend');
Route::post('line/message','LineHomeController@message');
Route::post('line/show','LineHomeController@show');
