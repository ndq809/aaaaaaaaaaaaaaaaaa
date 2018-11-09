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
	['namespace' => $namespace,'prefix'=>'master/vocabulary','middleware'=>['web','CheckPermission']],
	function() {
		Route::get('v001','v001Controller@getIndex');	
		Route::get('v002','v002Controller@getIndex');
		Route::post('v002/addnew','v002Controller@v002_addnew');
		Route::post('v002/upgrage','v002Controller@v002_upgrage');
		Route::post('v002/delete','v002Controller@v002_delete');
		Route::post('v002/refer','v002Controller@v002_refer');
		Route::post('v001/list'  ,'v001Controller@v001_list');
		Route::post('v001/update','v001Controller@v001_update');
		Route::post('v001/delete','v001Controller@v001_delete');
	}
);

$namespace1 = 'App\Modules\Master\Controllers\General';
Route::group(
	['namespace' => $namespace1,'prefix'=>'master/general','middleware'=>['web','CheckPermission']],
	function() {
		Route::get('g001','g001Controller@getIndex');	
		Route::get('g002','g002Controller@getIndex');
		Route::get('g003','g003Controller@getIndex');
		Route::get('g004','g004Controller@getIndex');	
		Route::get('g005','g005Controller@getIndex');
		Route::get('g006','g006Controller@getIndex');
		Route::get('g007','g007Controller@getIndex');	
		Route::post('g004/addnew','g004Controller@g004_addnew');
		Route::post('g004/delete','g004Controller@g004_delete');
		Route::post('g003/list'  ,'g003Controller@g003_list');
		Route::post('g003/update','g003Controller@g003_update');
		Route::post('g003/delete','g003Controller@g003_delete');
		Route::post('g006/addnew','g006Controller@g006_addnew');
		Route::post('g006/delete','g006Controller@g006_delete');
		Route::post('g005/list'  ,'g005Controller@g005_list');
		Route::post('g005/update','g005Controller@g005_update');
		Route::post('g005/delete','g005Controller@g005_delete');
	}
);


$namespace3 = 'App\Modules\Master\Controllers\Listening';
Route::group(
	['namespace' => $namespace3,'prefix'=>'master/listening','middleware'=>['web','CheckPermission']],
	function() {
		Route::get('l001','l001Controller@getIndex');
		Route::get('l002','l002Controller@getIndex');	
	}
);

$namespace4 = 'App\Modules\Master\Controllers\Writing';
Route::group(
	['namespace' => $namespace4,'prefix'=>'master/writing','middleware'=>['web','CheckPermission']],
	function() {
		Route::get('w001','w001Controller@getIndex');	
		Route::get('w002','w002Controller@getIndex');
		Route::post('w002/addnew','w002Controller@w002_addnew');
		Route::post('w002/delete','w002Controller@w002_delete');
		Route::post('w002/refer','w002Controller@w002_refer');
		Route::post('w002/getcatalogue','w002Controller@w002_getcatalogue');
		Route::post('w001/list'  ,'w001Controller@w001_list');
		Route::post('w001/update','w001Controller@w001_update');
		Route::post('w001/delete','w001Controller@w001_delete');
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
		Route::post('delete-image', 'CommonController@postCropDelete');
		Route::post('checkvalidate', 'CommonController@com_validate');
		Route::post('getcatalogue', 'CommonController@getcatalogue');
		Route::post('getgroup', 'CommonController@getgroup');
	}
);

$namespace7 = 'App\Modules\Master\Controllers\MasterData';
Route::group(
	['namespace' => $namespace7,'prefix'=>'master/data','middleware'=>['web','CheckPermission']],
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
		Route::post('m007/list','m007Controller@m007_list');
		Route::post('m007/save','m007Controller@m007_save');
		Route::post('m007/add','m007Controller@m007_add');
		Route::post('m007/delete','m007Controller@m007_delete');
	}
);

$namespace8 = 'App\Modules\Master\Controllers\System';
Route::group(
	['namespace' => $namespace8,'prefix'=>'master/system','middleware'=>['web','CheckPermission']],
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
		Route::post('s001/list-user'  ,'s001Controller@s001_listUser');
		Route::post('s001/update','s001Controller@s001_update');
		Route::post('s001/target','s001Controller@s001_target');	
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
		Route::get('p003','p003Controller@getIndex');
		Route::post('p003','p003Controller@p003_search');
		Route::post('p003/load','p003Controller@p003_load');
		Route::post('p003/refer','p003Controller@p003_refer');
		Route::get('p004','p004Controller@getIndex');
		Route::post('p004','p004Controller@p004_search');	
	}
);

