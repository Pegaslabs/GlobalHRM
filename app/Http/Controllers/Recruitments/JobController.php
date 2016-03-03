<?php

namespace App\Http\Controllers\Recruitments;

use App\Http\Controllers\Controller;
use View, DB;

use App\Models\Recruitments\Job;


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
					->paginate(20);		
					
		return View::make ( 'recruitments.jobs.index' )
			   ->with ( 'jobs', $jobs );
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
	
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {
		
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
		/*
		 * Show the edit form and pass the Job
		 */ 
		return View::make ( 'recruitments.jobs.show' )
						->with('title',  $title)
						->with('status', $status)
						->with('department', $department)
						->with('empType', $empType)	
						->with('empLevel', $empLevel)
						->with('job', $job);
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id        	
	 * @return Response
	 */
	public function edit($id) {
		

	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param int $id        	
	 * @return Response
	 */
	public function update($id) {
		
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id        	
	 * @return Response
	 */
	public function destroy($id) {
		
	}
}
