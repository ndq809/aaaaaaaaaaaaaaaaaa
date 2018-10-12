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
	['namespace' => $namespace,'prefix'=>'','middleware'=>['web','CheckMultiAccess']],
	function() {
		Route::get('contribute','ContributeController@getIndex');	
		Route::get('','HomePageController@getIndex');
		Route::get('vocabulary','VocabularyController@getIndex');
		Route::any('vocabulary/getData','VocabularyController@getData');
		Route::any('translate/getAutocomplete','TranslateController@getAutocomplete');
		Route::get('translate','TranslateController@getIndex');
		Route::any('translate/getData','TranslateController@getData');
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
		Route::get('reading','ReadingController@getIndex');
		Route::any('reading/getData','ReadingController@getData');
		Route::get('register','RegisterController@getIndex');
		Route::get('profile','ProfileController@getIndex');
		
	}
);
$namespace2 = 'App\Modules\User\Controllers';
Route::group(
	['namespace' => $namespace2,'prefix'=>'common','middleware'=>['web','CheckMultiAccess']],
	function() {
		Route::post('getcomment', 'CommonController@getComment');
		Route::post('changepass', 'CommonController@changePass');
		Route::post('upload-image', 'CommonController@postUpload');
		Route::post('crop-image', 'CommonController@postCrop');
		Route::any('addLesson','CommonController@addLesson');
		Route::any('deleteLesson','CommonController@deleteLesson');
		Route::any('remembervoc','CommonController@remembervoc');
		Route::any('forgetvoc','CommonController@forgetvoc');
		Route::any('getExample','CommonController@getExample');
		Route::any('addExample','CommonController@addExample');
		Route::any('addcomment','CommonController@addComment');
		Route::any('toggleEffect','CommonController@toggleEffect');
		Route::post('getcatalogue', 'CommonController@getcatalogue');
		Route::post('getgroup', 'CommonController@getgroup');
		Route::any('getQuestion','CommonController@getQuestion');
		Route::any('loadMoreComment','CommonController@loadMoreComment');

	}
);