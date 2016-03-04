<?php

namespace App\Http\Controllers\Recruitments;

use App\Http\Controllers\Controller;
use View, DB, Validator, Input,Redirect;

use App\Models\Recruitments\Job;
use App\Models\Recruitments\JobTitle;
use App\Models\Recruitments\EmploymentType;
use App\Models\Recruitments\EmploymentLevel;
use App\Models\Recruitments\JobStatus;


use App\Models\Organization\Department;
use App\Models\Organization\Country;


class JobController extends Controller
{
/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$jobs = DB::table('tblJobs')
					->leftjoin('tblJobStatus','tblJobs.status_id', '=', 'tblJobStatus.id')
					->leftjoin('tblJobTitles','tblJobs.title_id', '=', 'tblJobTitles.id')
					->leftjoin('tblDepartments','tblJobs.department_id', '=', 'tblDepartments.id')	
					->leftjoin('tblEmploymentTypes','tblJobs.employment_type_id', '=', 'tblEmploymentTypes.id')
					->leftjoin('tblEmploymentLevels','tblJobs.experience_level_id', '=', 'tblEmploymentLevels.id')						
					->select('tblJobs.*', 'tblJobStatus.status_name', 
							 'tblJobTitles.name AS title_name', 
							 'tblDepartments.name AS department_name',
							 'tblEmploymentTypes.name AS emp_type_name',
							 'tblEmploymentLevels.name AS emp_level_name'
							)
					->orderBy('closing_date','DESC')
					->paginate(3);		
					
		return View::make ( 'recruitments.jobs.index' )
			   ->with ( 'jobs', $jobs );
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {		
		/*
		 * Get corresponding information
		 */
		$mstStatus = JobStatus::all();
		
		$mstJobTitles = JobTitle::all();
		
		$mstDepartments = Department::all();
		
		$mstEmploymentTypes = EmploymentType::all();
		
		$mstEmploymentLevels = EmploymentLevel::all();
		
		$mstCountries = Country::all();
		/*
		 * Show the edit form and pass the Job
		 */
		return View::make ( 'recruitments.jobs.create' )
		->with('mstJobTitles',  $mstJobTitles)
		->with('mstStatus', $mstStatus)
		->with('mstDepartments', $mstDepartments)
		->with('mstEmploymentTypes', $mstEmploymentTypes)
		->with('mstEmploymentLevels', $mstEmploymentLevels)
		->with('mstCountries', $mstCountries);
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {
		$rules = array (
				'title_id' => 'required',
				'no_pos' => 'required|integer|min:1',
				'short_description' => 'required|string',
				'description' => 'required|string',
				'department_id' => 'required|integer',
				'employment_type_id' => 'required|integer',
				'experience_level_id'=> 'required|integer',
				'closing_date' => 'required|date|after:tomorrow'
		);
		$validator = Validator::make ( Input::all (), $rules );
		
		// process the login
		if ($validator->fails ()) {
			return Redirect::to ( 'recruitments/jobs/create' )->withErrors ( $validator )->withInput ( Input::except ( 'password' ) );
		} else {
			// store
			$job = new Job ();
			$job->title_id = Input::get ( 'title_id' );
			$job->priority = Input::get ( 'priority' );
				
			$job->no_pos = Input::get ( 'no_pos' );
			$job->short_description = Input::get ( 'short_description' );
			$job->description = Input::get ( 'description' );
			$job->department_id = Input::get ( 'department_id' );
			$job->employment_type_id = Input::get ( 'employment_type_id' );
			$job->experience_level_id = Input::get ( 'experience_level_id' );
		
			$job->nationality_id = Input::get ( 'nationality_id' );
			$job->min_salary = Input::get ( 'min_salary' );
			$job->max_salary = Input::get ( 'max_salary' );
			$job->status_id = Input::get ( 'status_id' );
			$job->closing_date = Input::get ( 'closing_date' );
			$job->save ();
				
			return Redirect::to ( 'recruitments/jobs' );
		}		
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param int $id        	
	 * @return Response
	 */
	public function show($id) {
		
		/*
		 *  Get the job information
		 */
		$job = Job::find ( $id );
		/*
		 * Get corresponding information
		 */
		$status = $job->status;
		
		$title  = $job->title;
		
		$department = $job->department;
		
		$empType = $job->empType;
		
		$empLevel = $job->empLevel;
		
		$nationality = $job->nationality;
		/*
		 * Show the edit form and pass the Job
		 */ 
		return View::make ( 'recruitments.jobs.show' )
						->with('title',  $title)
						->with('status', $status)
						->with('department', $department)
						->with('empType', $empType)	
						->with('empLevel', $empLevel)
						->with('nationality', $nationality)
						->with('job', $job);
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id        	
	 * @return Response
	 */
	public function edit($id) {
		/*
		 *  Get the job information
		 */
		$job = Job::find ( $id );
		/*
		 * Get corresponding information
		 */
		$mstStatus = JobStatus::all();
		$status    = $job->status;
		
		$mstJobTitles = JobTitle::all();
		$title  = $job->title;
		
		$mstDepartments = Department::all();
		
		$mstEmploymentTypes = EmploymentType::all();
		
		$mstEmploymentLevels = EmploymentLevel::all();
		
		$mstCountries = Country::all();
		/*
		 * Show the edit form and pass the Job
		 */ 
		return View::make ( 'recruitments.jobs.edit' )
						->with('title' ,  $title)
						->with('mstJobTitles',  $mstJobTitles)
						->with('mstStatus', $mstStatus)
						->with('status', $status)
						->with('mstDepartments', $mstDepartments)
						->with('mstEmploymentTypes', $mstEmploymentTypes)	
						->with('mstEmploymentLevels', $mstEmploymentLevels)
						->with('mstCountries', $mstCountries)
						->with('job', $job);
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param int $id        	
	 * @return Response
	 */
	public function update($id) {
		$rules = array (
				'title_id' => 'required',
				'no_pos' => 'required|integer|min:1',
				'short_description' => 'required|string',
				'description' => 'required|string',
				'department_id' => 'required|integer',
				'employment_type_id' => 'required|integer',
				'experience_level_id'=> 'required|integer',
				'closing_date' => 'required|date|after:tomorrow'
		);
		$validator = Validator::make ( Input::all (), $rules );
		
		// process the login
		if ($validator->fails ()) {
			return Redirect::to ( 'recruitments/jobs/' . $id . '/edit' )->withErrors ( $validator )->withInput ( Input::except ( 'password' ) );
		} else {
			// store
			$job = Job::find ( $id );
			$job->title_id = Input::get ( 'title_id' );
			$job->priority = Input::get ( 'priority' );
				
			$job->no_pos = Input::get ( 'no_pos' );
			$job->short_description = Input::get ( 'short_description' );
			$job->description = Input::get ( 'description' );
			$job->department_id = Input::get ( 'department_id' );
			$job->employment_type_id = Input::get ( 'employment_type_id' );
			$job->experience_level_id = Input::get ( 'experience_level_id' );
				
			$job->nationality_id = Input::get ( 'nationality_id' );
			$job->min_salary = Input::get ( 'min_salary' );
			$job->max_salary = Input::get ( 'max_salary' );
			
			$job->status_id = Input::get ( 'status_id' );
			
			$job->closing_date = Input::get ( 'closing_date' );				
			$job->save ();
			
			return Redirect::to ( 'recruitments/jobs' );
		}
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id        	
	 * @return Response
	 */
	public function destroy($id) {
		$job = Job::find ( $id );
		$job->delete ();
		return Redirect::to ( 'recruitments/jobs' );
	}
}
