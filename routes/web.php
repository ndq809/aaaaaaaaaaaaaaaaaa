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
Route::get('master/', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('master/checkLogin', 'Auth\LoginController@login');
Route::post('master/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('master/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('keep-token-alive', function() {
    return 'Token must have been valid, and the session expiration has been extended.'; //https://stackoverflow.com/q/31449434/470749
});
Route::get('auth/facebook', 'Auth\FacebookAuthController@redirectToProvider')->name('facebook.login') ;
Route::get('auth/facebook/callback', 'Auth\FacebookAuthController@handleProviderCallback');



