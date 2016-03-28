<?php

namespace App\Http\Controllers\Recruitments;

use App\Http\Controllers\Controller;

use View, DB, Validator,Redirect, Response;

use App\Models\Recruitments\Job;
use App\Models\Recruitments\JobTitle;
use App\Models\Recruitments\EmploymentType;
use App\Models\Recruitments\EmploymentLevel;
use App\Models\Recruitments\JobStatus;
use App\Models\Recruitments\EducationLevel;


use App\Models\Organization\Department;
use App\Models\Organization\Country;

use Input;
use Illuminate\Http\Request;


class JobController extends Controller
{
/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {			
		return View::make ( 'recruitments.jobs.index' );
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
		
		$mstEducationLevel = EducationLevel::all();
		/*
		 * Show the edit form and pass the Job
		 */
		return View::make ( 'recruitments.jobs.create' )
		->with('mstEducationLevels', $mstEducationLevel)
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
			$job->education_level_id = Input::get ( 'employment_education_id' );
				
			
		
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
		
		$educationLevel = $job->educationLevel;
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
						->with('educationLevel', $educationLevel)
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
		
		$mstEducationLevel = EducationLevel::all();
		
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
						->with('mstEducationLevels', $mstEducationLevel)						
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
			$job->education_level_id  = Input::get ( 'employment_education_id' );
				
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
	/*
	 * Tools
	 */
	public function getAvailableApplications($candidate_id){
		$availableJobs = DB::select("SELECT tblJobs.*, tblJobTitles.name as titleName
									 FROM tblJobs 
									 LEFT JOIN tblJobTitles
									 ON tblJobs.title_id = tblJobTitles.id
									 WHERE tblJobs.id NOT IN (
										SELECT job_id FROM tblCandidate_Jobs 
										WHERE
											tblCandidate_Jobs.candidate_id=:candidate_id)", [ 'candidate_id' => $candidate_id ]);
		if(!is_null($availableJobs))
			$res = response()->json(['success'=>true,'data'=>json_encode($availableJobs)]);
		else 
			$res = response()->json(['success'=>false, 'data' => 'There is no available job for selection']);
		return $res ;
	}
	public function getInvolvedApplications($candidate_id){
		$availableJobs = DB::select("SELECT tblJobs.*, tblJobTitles.name as titleName
									 FROM tblJobs
									 LEFT JOIN tblJobTitles
									 ON tblJobs.title_id = tblJobTitles.id
									 WHERE tblJobs.id IN (
										SELECT job_id FROM tblCandidate_Jobs
										WHERE
											tblCandidate_Jobs.candidate_id=:candidate_id)", [ 'candidate_id' => $candidate_id ]);
		if(!is_null($availableJobs))
			$res = response()->json(['success'=>true,'data'=>json_encode($availableJobs)]);
		else
			$res = response()->json(['success'=>false, 'data' => 'There is no available job for selection']);
		return $res ;
	}
	
	public function getJobsInfo(Request $request){		
		/*
		 * Paging
		 */
		$limit =  0;
		$skip  =  0;
		if ( $request->has('start')  &&  $request->has('length') )
		{
			$limit = intval($request->input('length'));
			$skip  = intval($request->input('start'));
		}
		
		/*
		 * Order By
		 */
		
		$sortColumns=array(
				0=>'tblJobs.id',
				1=>'tblJobTitles.name',
				2=>'tblJobs.no_pos',
				3=>'tblJobs.description',
				4=>'tblDepartments.name',
				5=>'tblJobs.priority',
				6=>'tblEmploymentTypes.name',
				7=>'tblEmploymentLevels.name',
				8=>'tblJobStatus.status_name',
				9=>'tblJobs.closing_date',
				10=>''
		);
		$orderBy="closing_date";
		$direction="desc";
		if($request->has('order'))
		{
			$column = $request->input('order.0.column');
			$direction  = $request->input('order.0.dir');
			$orderBy = $sortColumns[intval($column)];
		}
		/*
		 * Count the records Total & set the initial value for recordsFiltered
		 */
		$recordTotals = $jobs = DB::table('tblJobs')->count();
		$recordsFiltered = 	$recordTotals;
		
		$jobs = null;
		if($request->has('search.value')){
			$keyword = trim($request->input('search.value'));
			if($keyword != ""){
				$jobs = DB::table('tblJobs')
		                ->where('tblJobTitles.name', 'LIKE', '%'.$keyword.'%')
		                ->orWhere('tblDepartments.name', 'LIKE', '%'.$keyword.'%')
		                ->orWhere('tblSkills.name', 'LIKE','%'.$keyword.'%')
						->leftjoin('tblJobStatus','tblJobs.status_id', '=', 'tblJobStatus.id')
						->leftjoin('tblJobTitles','tblJobs.title_id','=','tblJobTitles.id')
						->leftjoin('tblDepartments','tblJobs.department_id','=','tblDepartments.id')
						->leftjoin('tblEmploymentTypes','tblJobs.employment_type_id', '=', 'tblEmploymentTypes.id')
						->leftjoin('tblEmploymentLevels','tblJobs.experience_level_id', '=', 'tblEmploymentLevels.id')
						->leftjoin('tblSkills', 'tblJobs.job_function_id', '=','tblSkills.id')
						->select('tblJobs.*',
								'tblJobStatus.status_name',
								'tblJobStatus.description AS display',
								'tblJobTitles.name AS title_name',
								'tblDepartments.name AS department_name',
								'tblEmploymentTypes.name AS emp_type_name',
								'tblEmploymentLevels.name AS emp_level_name'
								)
						->skip($skip)
						->take($limit)
						->orderBy($orderBy,$direction)
						->get();
					$recordsFiltered= count($jobs);
			}
		}else{
			$jobs = DB::table('tblJobs')
					->leftjoin('tblJobStatus','tblJobs.status_id', '=', 'tblJobStatus.id')
					->leftjoin('tblJobTitles','tblJobs.title_id','=','tblJobTitles.id')
					->leftjoin('tblDepartments','tblJobs.department_id','=','tblDepartments.id')
					->leftjoin('tblEmploymentTypes','tblJobs.employment_type_id', '=', 'tblEmploymentTypes.id')
					->leftjoin('tblEmploymentLevels','tblJobs.experience_level_id', '=', 'tblEmploymentLevels.id')
					->select('tblJobs.*',
							'tblJobStatus.status_name',
							'tblJobStatus.description AS display',
							'tblJobTitles.name AS title_name',
							'tblDepartments.name AS department_name',
							'tblEmploymentTypes.name AS emp_type_name',
							'tblEmploymentLevels.name AS emp_level_name'
							)
					->skip($skip)
					->take($limit)
					->orderBy($orderBy,$direction)
					->get();
		}
		
		$ret = array("draw"=> Input::get('draw'),"recordsTotal"=>$recordTotals, "recordsFiltered"=> $recordsFiltered,'data'=>array());
		foreach($jobs as $job){
			$jobInfo = array($job->id, 
							 $job->title_name, 
							 $job->no_pos, 
					         $job->description, 
					         $job->department_name, 
					         $job->priority, 
					         $job->emp_type_name, 
					         $job->emp_level_name, 
					         '<td><span class="badge bg-'.$job->display.'">'.$job->status_name.'</span></td>', 
							 $job->closing_date,
							 '<a  class="btn btn-block btn-info" href="'.route('recruitments.jobs.show' , ['jobs'=> $job->id]) .'">Details</a>'
			);
			array_push($ret['data'], $jobInfo);								
		}
		return json_encode($ret);
	}
	
}
