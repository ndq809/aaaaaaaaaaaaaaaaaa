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
		Route::post('v002/getAutocomplete','v002Controller@v002_getAutocomplete');
		Route::post('v001/list'  ,'v001Controller@v001_list');
		Route::post('v001/update','v001Controller@v001_update');
		Route::post('v001/delete','v001Controller@v001_delete');
		Route::post('v001/confirm','v001Controller@v001_confirm');
		Route::post('v001/public','v001Controller@v001_public');
		Route::post('v001/reset','v001Controller@v001_reset');
		Route::get('v003','v003Controller@getIndex');
		Route::post('v003/excute','v003Controller@v003_read');
		Route::post('v003/save','v003Controller@v003_save');

	}
);

$namespace1 = 'App\Modules\Master\Controllers\General';
Route::group(
	['namespace' => $namespace1,'prefix'=>'master/general','middleware'=>['web','CheckPermission']],
	function() {
		Route::get('g001','g001Controller@getIndex');	
		Route::post('g001/updateprofile','g001Controller@g001_updateProfile');
		Route::post('g001/statistic','g001Controller@g001_statistic');
		Route::post('g001/changepass','g001Controller@g001_changepass');
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
		Route::post('w001/delete','w001Controller@w001_delete');
		Route::post('w001/confirm','w001Controller@w001_confirm');
		Route::post('w001/public','w001Controller@w001_public');
		Route::post('w001/reset','w001Controller@w001_reset');
		Route::get('w003','w003Controller@getIndex');
		Route::post('w003/excute','w003Controller@w003_read');
		Route::post('w003/save','w003Controller@w003_save');
		Route::post('w003/readFile','w003Controller@w003_read');
		Route::post('w003/getAutocomplete','w003Controller@w003_getAutocomplete');
		Route::get('w004','w004Controller@getIndex');
		Route::post('w004/excute','w004Controller@w004_read');
		Route::post('w004/save','w004Controller@w004_save');
		Route::post('w004/readFile','w004Controller@w004_read');
		Route::post('w004/getAutocomplete','w004Controller@w004_getAutocomplete');
		Route::post('w004/getPost','w004Controller@w004_getPost');
		Route::post('w004/getcatalogue','w004Controller@w004_getcatalogue');
		Route::post('w004/autoTranslate','w004Controller@autoTranslate');
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
		Route::post('m004/addnew','m004Controller@m004_addnew');
		Route::post('m004/delete','m004Controller@m004_delete');
		Route::post('m003/list','m003Controller@m003_list');
		Route::post('m003/update','m003Controller@m003_update');
		Route::post('m003/delete','m003Controller@m003_delete');
		Route::get('m007','m007Controller@getIndex');
		Route::post('m007/list','m007Controller@m007_list');
		Route::post('m007/save','m007Controller@m007_save');
		Route::post('m007/add','m007Controller@m007_add');
		Route::post('m007/delete','m007Controller@m007_delete');
		Route::get('m008','m008Controller@getIndex');
		Route::post('m008/list','m008Controller@m008_list');
		Route::post('m008/save','m008Controller@m008_save');
		Route::post('m008/add','m008Controller@m008_add');
		Route::post('m008/delete','m008Controller@m008_delete');
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
		Route::post('p003/getAutocomplete','p003Controller@p003_getAutocomplete');
		Route::get('p005','p005Controller@getIndex');
		Route::post('p005','p005Controller@p005_search');
		Route::post('p005/load','p005Controller@p005_load');
		Route::post('p005/refer','p005Controller@p005_refer');
		Route::get('p006','p006Controller@getIndex');
		Route::post('p006','p006Controller@p006_search');
		Route::post('p006/load','p006Controller@p006_load');
		Route::post('p006/refer','p006Controller@p006_refer');
		Route::get('p004','p004Controller@getIndex');
		Route::post('p004','p004Controller@p004_search');	
	}
);

$namespace = 'App\Modules\Master\Controllers\Mission';
Route::group(
	['namespace' => $namespace,'prefix'=>'master/mission','middleware'=>['web','CheckPermission']],
	function() {
		Route::get('mi001','mi001Controller@getIndex');	
		Route::get('mi002','mi002Controller@getIndex');
		Route::post('mi002/addnew','mi002Controller@mi002_addnew');
		Route::post('mi002/upgrage','mi002Controller@mi002_upgrage');
		Route::post('mi002/delete','mi002Controller@mi002_delete');
		Route::post('mi002/refer','mi002Controller@mi002_refer');
		Route::post('mi002/refer_catalogue','mi002Controller@refer_catalogue');
		Route::post('mi002/refer_group','mi002Controller@refer_group');
		Route::post('mi002/getAutocomplete','mi002Controller@mi002_getAutocomplete');
		Route::post('mi001/list'  ,'mi001Controller@mi001_list');
		Route::post('mi001/update','mi001Controller@mi001_update');
		Route::post('mi001/delete','mi001Controller@mi001_delete');
		Route::post('mi001/confirm','mi001Controller@mi001_confirm');
		Route::post('mi001/public','mi001Controller@mi001_public');
		Route::post('mi001/reset','mi001Controller@mi001_reset');

	}
);

$namespace10 = 'App\Modules\Master\Controllers\Denounce';
Route::group(
	['namespace' => $namespace10,'prefix'=>'master/denounce','middleware'=>['web','CheckPermission']],
	function() {
		Route::get('d001','d001Controller@getIndex');
		Route::post('d001/list'  ,'d001Controller@d001_list');
		Route::post('d001/list-user'  ,'d001Controller@d001_listUser');
		Route::post('d001/update','d001Controller@d001_update');
		Route::post('d001/target','d001Controller@d001_target');	
	}
);

