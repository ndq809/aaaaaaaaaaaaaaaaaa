<?php 
/**
 * @author : dev@gmail.com  
 * @Website : http://ans-asia.com 
 * @version : 1.0
 * @Build by tannq@ans-asia.com
 * @description: Framework building use Laravel 
 * @Created at: 2017-07-27 04:33:24
 */

$namespace = 'App\Modules\Master\Controllers\Vocabulary';
Route::group(
	['namespace' => $namespace,'prefix'=>'master','middleware'=>['web']],
	function() {
		Route::get('index','Example1Controller@getIndex');
		Route::get('v001','v001Controller@getIndex');	
		Route::get('v002','v002Controller@getIndex');
		Route::get('v003','v003Controller@getIndex');
		Route::get('v004','v004Controller@getIndex');
		Route::get('v005','v005Controller@getIndex');
		Route::get('v006','v006Controller@getIndex');
	}
);

$namespace1 = 'App\Modules\Master\Controllers\General';
Route::group(
	['namespace' => $namespace1,'prefix'=>'master','middleware'=>['web']],
	function() {
		Route::get('g001','g001Controller@getIndex');	
		Route::get('g002','g002Controller@getIndex');
		Route::get('g003','g003Controller@getIndex');		
	}
);