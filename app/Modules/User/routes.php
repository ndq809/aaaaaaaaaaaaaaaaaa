<?php 
/**
 * @author : dev@gmail.com  
 * @Website : http://ans-asia.com 
 * @version : 1.0
 * @Build by tannq@ans-asia.com
 * @description: Framework building use Laravel 
 * @Created at: 2017-07-27 04:33:24
 */

$namespace = 'App\Modules\User\Controllers';
Route::group(
	['namespace' => $namespace,'prefix'=>'','middleware'=>['web']],
	function() {
		Route::get('contribute','ContributeController@getIndex');	
		Route::get('','HomePageController@getIndex');
		Route::get('vocabulary','VocabularyController@getIndex');
		Route::any('vocabulary/getData','VocabularyController@getData');
		Route::get('grammar','GrammarController@getIndex');
		Route::any('grammar/getData','GrammarController@getData');
		Route::get('listening','ListeningController@getIndex');
		Route::any('listening/getData','listeningController@getData');
		Route::get('writing','WritingController@getIndex');
		Route::any('writing/getData','WritingController@getData');
		Route::get('social','SocialController@getIndex');
		Route::any('social/getData','SocialController@getData');
		Route::get('relax','RelaxController@getIndex');
		Route::any('relax/getData','RelaxController@getData');
		Route::get('register','RegisterController@getIndex');
		Route::get('profile','ProfileController@getIndex');
		Route::post('upload-image', 'RegisterController@postUpload');
		Route::post('crop-image', 'RegisterController@postCrop');
	}
);
$namespace2 = 'App\Modules\Master\Controllers\Common';
Route::group(
	['namespace' => $namespace2,'prefix'=>'common','middleware'=>['web']],
	function() {
		Route::post('getcomment', 'CommonController@getComment');
		Route::post('changepass', 'CommonController@changePass');
	}
);