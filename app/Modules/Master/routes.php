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
	}
);

$namespace1 = 'App\Modules\Master\Controllers\General';
Route::group(
	['namespace' => $namespace1,'prefix'=>'master','middleware'=>['web']],
	function() {
		Route::get('g001','g001Controller@getIndex');	
		Route::get('g002','g002Controller@getIndex');
		Route::get('g003','g003Controller@getIndex');
		Route::get('g004','g004Controller@getIndex');	
		Route::get('g005','g005Controller@getIndex');
		Route::get('g006','g006Controller@getIndex');
		Route::get('g007','g007Controller@getIndex');			
	}
);


$namespace3 = 'App\Modules\Master\Controllers\Listening';
Route::group(
	['namespace' => $namespace3,'prefix'=>'master','middleware'=>['web']],
	function() {
		Route::get('index','Example1Controller@getIndex');
		Route::get('l001','l001Controller@getIndex');
		Route::get('l002','l002Controller@getIndex');	
	}
);

$namespace4 = 'App\Modules\Master\Controllers\Writing';
Route::group(
	['namespace' => $namespace4,'prefix'=>'master','middleware'=>['web']],
	function() {
		Route::get('index','Example1Controller@getIndex');
		Route::get('w001','w001Controller@getIndex');	
		Route::get('w002','w002Controller@getIndex');
	}
);

$namespace5 = 'App\Modules\Master\Controllers\UserPost';
Route::group(
	['namespace' => $namespace5,'prefix'=>'master','middleware'=>['web']],
	function() {
		Route::get('index','Example1Controller@getIndex');
		Route::get('u001','u001Controller@getIndex');	
		Route::get('u002','u002Controller@getIndex');
	}
);