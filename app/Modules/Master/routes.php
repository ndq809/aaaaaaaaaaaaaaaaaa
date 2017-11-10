<?php 
/**
 * @author : dev@gmail.com  
 * @Website : http://ans-asia.com 
 * @version : 1.0
 * @Build by tannq@ans-asia.com
 * @description: Framework building use Laravel 
 * @Created at: 2017-07-27 04:33:24
 */

$namespace = 'App\Modules\Master\Controllers';
Route::group(
	['namespace' => $namespace,'prefix'=>'master','middleware'=>['web']],
	function() {
		Route::get('index','Example1Controller@getIndex');
		Route::get('v001','v001Controller@getIndex');	
		Route::get('v002','v002Controller@getIndex');		
	}
);