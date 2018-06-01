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
	['namespace' => $namespace,'prefix'=>'master/vocabulary','middleware'=>['web']],
	function() {
		Route::get('v001','v001Controller@getIndex');	
		Route::get('v002','v002Controller@getIndex');
	}
);

$namespace1 = 'App\Modules\Master\Controllers\General';
Route::group(
	['namespace' => $namespace1,'prefix'=>'master/general','middleware'=>['web']],
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
	['namespace' => $namespace3,'prefix'=>'master/listening','middleware'=>['web']],
	function() {
		Route::get('l001','l001Controller@getIndex');
		Route::get('l002','l002Controller@getIndex');	
	}
);

$namespace4 = 'App\Modules\Master\Controllers\Writing';
Route::group(
	['namespace' => $namespace4,'prefix'=>'master/writing','middleware'=>['web']],
	function() {
		Route::get('w001','w001Controller@getIndex');	
		Route::get('w002','w002Controller@getIndex');
	}
);

// $namespace5 = 'App\Modules\Master\Controllers\UserPost';
// Route::group(
// 	['namespace' => $namespace5,'prefix'=>'master/','middleware'=>['web']],
// 	function() {
// 		Route::get('u001','u001Controller@getIndex');	
// 		Route::get('u002','u002Controller@getIndex');
// 	}
// );

$namespace6 = 'App\Modules\Master\Controllers\Common';
Route::group(
	['namespace' => $namespace6,'prefix'=>'master/common','middleware'=>['web']],
	function() {
		Route::post('getcomment', 'CommonController@getComment');
		Route::post('changepass', 'CommonController@changePass');
		Route::post('refer', 'CommonController@refer');
		Route::post('upload-image', 'CommonController@postUpload');
		Route::post('crop-image', 'CommonController@postCrop');
		Route::post('checkvalidate', 'CommonController@com_validate');
	}
);

$namespace7 = 'App\Modules\Master\Controllers\MasterData';
Route::group(
	['namespace' => $namespace7,'prefix'=>'master/data','middleware'=>['web']],
	function() {
		Route::get('m001','m001Controller@getIndex');	
		Route::get('m002','m002Controller@getIndex');
		Route::get('m003','m003Controller@getIndex');	
		Route::get('m004','m004Controller@getIndex');
		Route::get('m005','m005Controller@getIndex');	
		Route::get('m006','m006Controller@getIndex');
		Route::get('m007','m007Controller@getIndex');
		Route::post('m004/addnew','m004Controller@m004_addnew');
		Route::post('m004/delete','m004Controller@m004_delete');
		Route::post('m003/list','m003Controller@m003_list');
		Route::post('m003/update','m003Controller@m003_update');
		Route::post('m003/delete','m003Controller@m003_delete');
	}
);

$namespace8 = 'App\Modules\Master\Controllers\System';
Route::group(
	['namespace' => $namespace8,'prefix'=>'master/system','middleware'=>['web']],
	function() {
		Route::get('s001','s001Controller@getIndex');
		Route::get('s002','s002Controller@getIndex');	
		Route::get('s003','s003Controller@getIndex');
		Route::post('s003/addnew','s003Controller@s003_addnew');
		Route::post('s003/delete','s003Controller@s003_delete');
		Route::post('s002/list'  ,'s002Controller@s002_list');
		Route::post('s002/update','s002Controller@s002_update');
		Route::post('s002/delete','s002Controller@s002_delete');
		Route::post('s001/list'  ,'s001Controller@s001_list');
		Route::post('s001/update','s001Controller@s001_update');	
	}
);

$namespace9 = 'App\Modules\Master\Controllers\Popup';
Route::group(
	['namespace' => $namespace9,'prefix'=>'master/popup','middleware'=>['web']],
	function() {
		Route::get('p001','p001Controller@getIndex');
		Route::post('p001','p001Controller@p001_search');
		Route::get('p002','p002Controller@getIndex');
		Route::post('p002','p002Controller@p002_search');	
	}
);

