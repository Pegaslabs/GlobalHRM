<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::group(['prefix' => 'recruitments', 'namespace' => 'Recruitments', 'middleware' => ['auth']], function() {
   		Route::resource('jobs', 'JobController');
   		Route::resource('candidates', 'CandidateController'); 		 
    });
    Route::get('cv/{filename}', [
    			'as' => 'getUploadedResume', 'uses' => 'CandidateController@getUploadedResumeFile']);
    Route::get('images/{filename}', ['as' => 'getUploadedAvatar', function ($filename)
    {
    	return Image::make(sprintf(storage_path().'/app/avatar/%s', $filename))->response();
    }]);
});
