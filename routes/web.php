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



Route::get('/template', function () {
    return view('welcome');
});

Route::get('master/', 'Auth\AccessController@getLogin');
Route::post('master/checkLogin', 'Auth\AccessController@checkLogin');
