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
		Route::get('','HomePageController@getIndex')->name('home');
		Route::get('vocabulary','VocabularyController@getIndex');
		Route::any('vocabulary/getData','VocabularyController@getData');
		Route::any('dictionary/getAutocomplete','DictionaryController@getAutocomplete');
		Route::get('dictionary','DictionaryController@getIndex');
		Route::any('dictionary/getData','DictionaryController@getData');
		Route::any('dictionary/vote-word','DictionaryController@voteWord');
		Route::get('grammar','GrammarController@getIndex');
		Route::any('grammar/getData','GrammarController@getData');
		Route::get('listening','ListeningController@getIndex');
		Route::any('listening/getData','listeningController@getData');
		Route::get('writing','WritingController@getIndex');
		Route::any('writing/getData','WritingController@getData');
		Route::any('writing/save','WritingController@save');
		Route::any('writing/share','WritingController@share');
		Route::get('social','SocialController@getIndex');
		Route::any('social/getData','SocialController@getData');
		Route::any('social/vote','SocialController@vote');
		Route::any('social/view','SocialController@view');
		Route::get('relax','RelaxController@getIndex');
		Route::any('relax/getData','RelaxController@getData');
		Route::any('relax/vote','RelaxController@vote');
		Route::any('relax/view','RelaxController@view');
		Route::any('relax/save','RelaxController@save');
		Route::get('reading','ReadingController@getIndex');
		Route::any('reading/getData','ReadingController@getData');
		Route::get('discuss','DiscussController@getIndex');
		Route::any('discuss/getData','DiscussController@getData');
		Route::any('discuss/vote','DiscussController@vote');
		Route::any('discuss/vote-cmt','DiscussController@voteCmt');
		Route::any('discuss/view','DiscussController@view');
		Route::get('translation','TranslationController@getIndex');
		Route::any('translation/getData','TranslationController@getData');
		Route::any('translation/autoTranslate','TranslationController@autoTranslate');
		Route::any('translation/save','TranslationController@save');
		Route::any('translation/delete','TranslationController@delete');
		Route::any('register','RegisterController@getIndex')->name('register');
		Route::any('register/create','RegisterController@create');
		Route::get('profile','ProfileController@getIndex');
		Route::any('profile/updateinfor','ProfileController@updateInfor');
		Route::any('profile/updatepass','ProfileController@updatePass');
		
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
		Route::post('delete-image', 'CommonController@postCropDelete');
		Route::any('addLesson','CommonController@addLesson');
		Route::any('deleteLesson','CommonController@deleteLesson');
		Route::any('remembervoc','CommonController@remembervoc');
		Route::any('forgetvoc','CommonController@forgetvoc');
		Route::any('getExample','CommonController@getExample');
		Route::any('addExample','CommonController@addExample');
		Route::any('addQuestion','CommonController@addQuestion');
		Route::any('addcomment','CommonController@addComment');
		Route::any('toggleEffect','CommonController@toggleEffect');
		Route::post('getcatalogue', 'CommonController@getcatalogue');
		Route::post('getgroup', 'CommonController@getgroup');
		Route::any('getQuestion','CommonController@getQuestion');
		Route::any('getMission','CommonController@getMission');
		Route::any('acceptMission','CommonController@acceptMission');
		Route::any('refuseMission','CommonController@refuseMission');
		Route::any('doMission','CommonController@doMission');
		Route::any('cancelMission','CommonController@cancelMission');
		Route::any('completeMission','CommonController@completeMission');
		Route::any('getMissionQuestion','CommonController@getMissionQuestion');
		Route::any('loadMoreComment','CommonController@loadMoreComment');
		Route::post('getGrammarSuggest', 'CommonController@getGrammarSuggest');
		Route::any('delete','CommonController@deletePost');
	}
);

$namespace3 = 'App\Modules\User\Controllers';
Route::group(
	['namespace' => $namespace3,'prefix'=>'popup','middleware'=>['web']],
	function() {
		Route::get('p001','Popup1Controller@getIndex');
		Route::post('p001','Popup1Controller@p001_search');
		Route::post('p001/load','Popup1Controller@p001_load');
		Route::post('p001/refer','Popup1Controller@p001_refer');
		Route::get('p002','Popup2Controller@getIndex');
	}
);