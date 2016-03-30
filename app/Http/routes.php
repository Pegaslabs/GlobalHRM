<?php

/*
 * |--------------------------------------------------------------------------
 * | Routes File
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you will register all of the routes in an application.
 * | It's a breeze. Simply tell Laravel the URIs it should respond to
 * | and give it the controller to call when that URI is requested.
 * |
 */
Route::get ( '/', function () {
	return view ( 'welcome' );
} );
Route::get ( '/demo', function () {
	
	$demo_seeder = new \Kordy\Ticketit\Seeds\TicketitTableSeeder ();
	$demo_seeder->email_domain = '@example.com'; // the email domain name for demo accounts. Ex. user1@example.com
	$demo_seeder->agents_qty = 3; // number of demo agents accounts
	$demo_seeder->agents_per_category = 2; // number of demo agents per category (must be lower than $agents_qty)
	$demo_seeder->users_qty = 10; // number of demo users accounts
	$demo_seeder->tickets_per_user_min = 1; // Minimum number of generated tickets per user
	$demo_seeder->tickets_per_user_max = 5; // Maximum number of generated tickets per user
	$demo_seeder->comments_per_ticket_min = 0; // Minimum number of generated comments per ticket
	$demo_seeder->comments_per_ticket_max = 3; // Maximum number of generated comments per ticket
	$demo_seeder->default_agent_password = 'demo'; // default demo agents accounts paasword
	$demo_seeder->default_user_password = 'demo'; // default demo users accounts paasword
	$demo_seeder->tickets_date_period = 70; // to go to past (in days) and start creating tickets since
	$demo_seeder->tickets_open = 20; // To-do number of remaining open tickets
	$demo_seeder->tickets_min_close_period = 3; // minimum days to close tickets
	$demo_seeder->tickets_max_close_period = 5; // maximum days to close tickets
	$demo_seeder->default_closed_status_id = 2; // default status id for closed tickets
	$demo_seeder->categories = [ 
			'Technical' => '#0014f4',
			'Billing' => '#2b9900',
			'Customer Services' => '#7e0099' 
	];
	$demo_seeder->statuses = [ 
			'Pending' => '#e69900',
			'Solved' => '#15a000',
			'Bug' => '#f40700' 
	];
	$demo_seeder->priorities = [ 
			'Low' => '#069900',
			'Normal' => '#e1d200',
			'Critical' => '#e10000' 
	];
	
	$demo_seeder->run ();
	
	return 'done';
} );

/*
 * |--------------------------------------------------------------------------
 * | Application Routes
 * |--------------------------------------------------------------------------
 * |
 * | This route group applies the "web" middleware group to every route
 * | it contains. The "web" middleware group is defined in your HTTP
 * | kernel and includes session state, CSRF protection, and more.
 * |
 */

Route::group ( [ 
		'middleware' => [ 
				'web' 
		] 
], function () {
	Route::group ( [ 
			'prefix' => 'recruitments',
			'namespace' => 'Recruitments',
			'middleware' => [ 
					'auth' 
			] 
	], function () {
		Route::resource ( 'jobs', 'JobController' );
		
		Route::post ( '/search/jobs/', [ 
				'as' => 'recruitments.search.jobs',
				'uses' => 'JobController@getJobsInfo' 
		] );
		
		Route::resource ( 'candidates', 'CandidateController' );
		
		Route::resource ( 'interviews', 'InterviewController' );
		
		// Route::resource('resumes', 'ResumeController');
		
		Route::get ( 'resumes', [ 
				'as' => 'recruitments.resumes.index',
				'uses' => 'ResumeController@index' 
		] );
		Route::get ( 'resumes/{resumes}', [ 
				'as' => 'recruitments.resumes.show',
				'uses' => 'ResumeController@show' 
		] );
		Route::get ( 'resumes/{resumes}/download', [ 
				'as' => 'recruitments.resumes.download',
				'uses' => 'ResumeController@download' 
		] );
		Route::delete ( 'resumes/{resumes}', [ 
				'as' => 'recruitments.resumes.destroy',
				'uses' => 'ResumeController@destroy' 
		]
		 );
		Route::post ( '/search/resumes/', [ 
				'as' => 'recruitments.search.resumes',
				'uses' => 'ResumeController@getResumesInfo' 
		] );
	} );
	/*
	 * Tools
	 */
	Route::group ( [ 
			'prefix' => 'recruitments',
			'namespace' => 'Recruitments',
			'middleware' => [ 
					'auth' 
			] 
	], function () {
		Route::get ( 'cv/{filename}', [ 
				'as' => 'getUploadedResume',
				'uses' => 'CandidateController@getUploadedResumeFile' 
		] );
		
		Route::get ( 'applicants/{candidate_id}/available', [ 
				'as' => 'recruitments.candidates.applications',
				'uses' => 'JobController@getAvailableApplications' 
		] );
		
		Route::get ( 'applicants/{candidate_id}/applied', [ 
				'as' => 'recruitments.candidates.involve',
				'uses' => 'JobController@getInvolvedApplications' 
		] );
		
		Route::post ( 'application', [ 
				'as' => 'recruitments.candidate.application.create',
				'uses' => 'CandidateController@createNewApplication' 
		] );
		
		Route::get ( '/schedules', [ 
				'as' => 'recruitments.schedules',
				'uses' => 'InterviewController@getAllInterviewsByPeriod' 
		] );
	} );
	
	Route::group ( [ 
			'prefix' => 'recruitments',
			'namespace' => 'Database',
			'middleware' => [ 
					'auth' 
			] 
	], function () {
		
		Route::get ( 'master/skills/{term}', [ 
				'as' => 'recruitments.master.skills',
				'uses' => 'MasterController@getMasterSkills' 
		] );
		
		Route::get ( 'master/interview_results/', [ 
				'as' => 'recruitments.master.interview_results',
				'uses' => 'MasterController@getMasterInterviewResults' 
		] );
	} );
	Route::get ( 'images/{filename}', [ 
			'as' => 'getUploadedAvatar',
			function ($filename) {
				return Image::make ( sprintf ( storage_path () . '/app/avatar/%s', $filename ) )->response ();
			} 
	] );
} );
