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
   		Route::resource('interviews', 'InterviewController');
   		
   		
    });
   /*
    * Tools
    */
    Route::group(['prefix' => 'recruitments', 'namespace' => 'Recruitments', 'middleware' => ['auth']], function() {
    	Route::get('cv/{filename}', [
    			'as' => 'getUploadedResume', 'uses' => 'CandidateController@getUploadedResumeFile']);
    	
    	Route::get('applicants/{candidate_id}/available',[
    			'as' => 'recruitments.candidates.applications', 'uses'=> 'JobController@getAvailableApplications']);
    	
    	Route::get('applicants/{candidate_id}/applied',[
    			'as' => 'recruitments.candidates.involve', 'uses'=> 'JobController@getInvolvedApplications']);
    	
    	Route::post('application', [
    			'as' => 'recruitments.candidate.application.create', 'uses' => 'CandidateController@createNewApplication']);
    	
    	Route::get('/schedules',['as'=>'recruitments.schedules',
    			'uses'=>'InterviewController@getAllInterviewsByPeriod']);
    	
    });
    
    Route::group(['prefix' => 'recruitments', 'namespace' => 'Database', 'middleware' => ['auth']], function() {
    	
    	Route::get('master/skills/{term}',[
    			'as' => 'recruitments.master.skills', 'uses'=> 'MasterController@getMasterSkills']);
    	
    	Route::get('master/interview_results/', ['as' =>  'recruitments.master.interview_results',
    			'uses'=> 'MasterController@getMasterInterviewResults'    			
    	]);    	 
    });
    Route::get('images/{filename}', ['as' => 'getUploadedAvatar', function ($filename)
    {
    	return Image::make(sprintf(storage_path().'/app/avatar/%s', $filename))->response();
    }]);
    
    
});
