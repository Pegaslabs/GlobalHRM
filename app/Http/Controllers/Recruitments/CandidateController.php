<?php

namespace App\Http\Controllers\Recruitments;

/*
 *
 */
use App\Models\Recruitments\Candidate;
use App\Models\Recruitments\JobTitle;
use App\Models\Recruitments\Job;
use App\Models\Organization\Country;


use App\Models\Common\UploadFileEntry;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;
/*
 *
 */
use DB, View, Validator, Redirect, Request;
use Storage, File, Log, Image;

class CandidateController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$candidates = DB::table ( 'tblCandidates' )
					  ->join ( 'tblJobTitles', 'tblCandidates.resume_title_id', '=', 'tblJobTitles.id' )
					  ->select ( 'tblCandidates.*', 'tblJobTitles.name as job_title_name' )
					  ->paginate ( 10 );
		return View::make ( 'recruitments.candidates.index' )
				->with ( 'candidates', $candidates );
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		/*
		 * Nationality selection
		 */
		$countries = Country::all();
		/*
		 * Job Title selection
		 */
		$jobTitles = JobTitle::all ();
		/*
		 * Create view
		 */
		return View::make ( 'recruitments.candidates.create' )
					->with ( 'jobTitles', $jobTitles )
		        	->with ( 'countries', $countries );
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {
		$rules = array (
				'first_name' => 'required|string|max:50',
				'middle_name' => 'required|string|max:50',
				'last_name' => 'required|string|max:50',
				'address' => 'string|max:500',
				'nationality_id' => 'required|integer',
				'resume_title_id' => 'required|integer',
				'email' => 'required|string|max:100',
				'mobile' => 'required|string|max:10' 
		);
		$validator = Validator::make ( Input::all (), $rules );
		
		// process the login
		if ($validator->fails ()) {
			return Redirect::to ( 'recruitments/candidates/create' )->withErrors ( $validator )->withInput ( Input::except ( 'password' ) );
		} else {
			// store
			$candidate = new Candidate ();
			$candidate->first_name = Input::get ( 'first_name' );
			$candidate->middle_name = Input::get ( 'middle_name' );
			$candidate->last_name = Input::get ( 'last_name' );
			$candidate->gender = Input::get ( 'gender' );
			$candidate->address = Input::get ( 'address' );
			$candidate->nationality_id = Input::get ( 'nationality_id' );
			$candidate->resume_title_id = Input::get ( 'resume_title_id' );
			$candidate->profile_summary = Input::get ( 'profile_summary' );
			$candidate->email = Input::get ( 'email' );
			$candidate->mobile = Input::get ( 'mobile' );
			/*
			 * Handle Avatar Upload
			 * 
			 */
			if (Input::hasFile('avatar_file')){				
				$avatar_file = Request::file ( 'avatar_file' );
				$avatar = array('image' => $avatar_file);
				$rules = array('image' => 'mimes:jpeg,bmp,png');
				$validator = Validator::make($avatar, $rules);
				if ($validator->fails ()){
					return Redirect::to ( 'recruitments/candidates/create' )->withErrors ( $validator )->withInput ( Input::except ( 'password' ) );
				}else{					
					if ($avatar_file ->isValid()) {
						$destinationPath = 'avatar';
						$extension = $avatar_file->getClientOriginalExtension(); // getting image extension
						$fileName = 'img_'.time().'.'.$extension;                // renameing image
						
						Storage::disk('local')->put($destinationPath.'/'.$fileName, File::get($avatar_file));
						//$avatar_file->move(public_path().'/storage/app/'.$destinationPath, $fileName);         // uploading file to given path	
						
						
						$image = Image::make(sprintf(storage_path().'/app/avatar/%s', $fileName))->resize(90, 90)->save(); // Resize image
						
						
						$AvatarEntry = new UploadFileEntry ();
						$AvatarEntry->mime = $avatar_file->getClientMimeType ();
						$AvatarEntry->category = 1;
						$AvatarEntry->original_filename = $avatar_file->getClientOriginalName ();
						$AvatarEntry->filename = $avatar_file->getFilename () . '.' . $extension;						
						$AvatarEntry->save ();					
					}
					else {
						// sending back with error message.
						Session::flash('error', 'Uploaded file is not valid');
						return Redirect::to('recruitments/candidates/create');
					}
									
				}
			}
			/*
			 * Handle CV Upload
			 */
			$file = Request::file ( 'resume_file' );
			$extension = $file->getClientOriginalExtension ();
			Storage::disk ( 'local' )->put ( 'cv/'. $file->getFilename () . '.' . $extension, File::get ( $file ) );
			
			$ResumeEntry = new UploadFileEntry ();
			$ResumeEntry->mime = $file->getClientMimeType ();
			$ResumeEntry->category = 2;
			$ResumeEntry->original_filename = $file->getClientOriginalName ();
			$ResumeEntry->filename = $file->getFilename () . '.' . $extension;
			
			$ResumeEntry->save ();
			/*
			 *
			 */
			$candidate->resume_upload_id = $ResumeEntry->id;
			$candidate->avatar_upload_id = $AvatarEntry->id;
			$candidate->save ();
			return Redirect::to ( 'recruitments/candidates' );
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
		 * Get master data to fill to selection box
		 */
		$mstJobs = DB::select ( 'SELECT tblJobs.job_id, tblJobTitles.job_title_name
    						   FROM tblJobs
    						   LEFT JOIN tblJobTitles
    			               ON tblJobs.job_title_id = tblJobTitles.job_title_id' );
		/*
		 * Get master interview result datas
		 */
		
		$mstInterviewResults = InterviewResult::all();
		
		/*
		 * get Candidate's details
		 */
		$candidateInfo = DB::table ( 'tblCandidates' )
						->leftjoin ( 'tblResumeFiles', 'tblCandidates.resume_upload_id', '=', 'tblResumeFiles.id' )
						->select ( 'tblCandidates.*', 'tblResumeFiles.filename' )->where ( 'candidate_id', '=', $id )->first ();
		/*
		 * Get Candidate's skills
		 */
		
		$candidateSkills = DB::select ( 'SELECT tblSkills.*, tblCandidate_Skills.no_years FROM tblSkills
    									JOIN tblCandidate_Skills
    									ON tblSkills.skill_id = tblCandidate_Skills.skill_id
    								    WHERE tblCandidate_Skills.candidate_id= :candidate_id', [ 'candidate_id' => $id ] );
		/*
		 * Get person's education history
		 */
		
		$educationsHistory = DB::select ( 'SELECT tblEducationLevels.*,
    										tblCandidate_Educations.institute, 
    										tblCandidate_Educations.majority,
    										tblCandidate_Educations.start_year,  
    										tblCandidate_Educations.graduation_year
    									FROM tblEducationLevels
    									JOIN tblCandidate_Educations
    									ON tblEducationLevels.education_level_id = tblCandidate_Educations.education_id
    								    WHERE tblCandidate_Educations.candidate_id= :candidate_id
    									ORDER BY tblCandidate_Educations.graduation_year DESC', [ 'candidate_id' => $id ] );
		/*
		 * Get list of applied jobs
		 */
		
		$appliedPositions = DB::select ( 'SELECT 
    										tblJobs.*,
											tblCandidate_Jobs.id,
											tblCandidate_Jobs.job_id,
											tblCandidate_Jobs.candidate_id,
    										tblCandidate_Jobs.notes,    
											tblJobTitles.job_title_id,
    										tblJobTitles.job_title_name
    									FROM tblJobs
    									JOIN tblCandidate_Jobs
    									ON tblJobs.job_id = tblCandidate_Jobs.job_id
    									JOIN tblJobTitles
    									ON tblJobs.job_title_id = tblJobTitles.job_title_id
    								    WHERE tblCandidate_Jobs.candidate_id= :candidate_id
    									ORDER BY tblCandidate_Jobs.created_at ASC', ['candidate_id' => $id ] );
		/*
		 * Get list of scheduled interviews
		 */
		$scheduledInterviews = DB::select(' SELECT tblInterviewSchedules.*, tblTmp.job_id AS job_id, tblInterviewResults.result_name as result
										    FROM tblInterviewSchedules										    
										    INNER JOIN 
												( SELECT *
												  FROM
													tblCandidate_Jobs
												  WHERE
													tblCandidate_Jobs.candidate_id = :candidate_id
											    ) AS tblTmp
										    ON 
												tblInterviewSchedules.candidate_job_id = tblTmp.id
											LEFT JOIN tblInterviewResults
											ON
												tblInterviewSchedules.result_id = tblInterviewResults.id'
										   , ['candidate_id' => $id] );
				
		return View::make ( 'recruitments.candidates.show' )
				->with ( 'jobs', $mstJobs )
				->with ( 'mstInterviewResults', $mstInterviewResults)
				->with ( 'candidateInfo', $candidateInfo )
				->with ( 'educationsHistory', $educationsHistory )
				->with ( 'appliedPositions', $appliedPositions )
				->with ( 'candidateSkills', $candidateSkills )
				->with ( 'scheduledInterviews', $scheduledInterviews);
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id        	
	 * @return Response
	 */
	public function edit($id) {
		$candidateInfo = DB::table ( 'tblCandidates' )->leftjoin ( "tblResumeFiles", 'tblCandidates.resume_upload_id', '=', 'tblResumeFiles.id' )->select ( 'tblCandidates.*', 'tblResumeFiles.filename', 'tblResumeFiles.original_filename' )->where ( 'candidate_id', '=', $id )->first ();
		/*
		 * Nationality selection
		 */
		$countries = Countries::getList ( 'name' );
		/*
		 *
		 */
		$jobTitles = JobTitle::all ();
		return View::make ( 'recruitments.candidates.edit' )->with ( 'candidateInfo', $candidateInfo )->with ( 'jobTitles', $jobTitles )->with ( 'countries', $countries );
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param int $id        	
	 * @return Response
	 */
	public function update($id) {
		$rules = array (
				'first_name' => 'required|string|max:50',
				'middle_name' => 'required|string|max:50',
				'last_name' => 'required|string|max:50',
				'gender' => 'required|integer|max:2',
				'address' => 'string|max:500',
				'nationality_id' => 'required|integer',
				'resume_title_id' => 'required|integer',
				'email' => 'required|string|max:100',
				'mobile' => 'required|string|max:10' 
		);
		$validator = Validator::make ( Input::all (), $rules );
		
		// process the login
		if ($validator->fails ()) {
			return Redirect::to ( 'recruitments/candidates/create' )->withErrors ( $validator )->withInput ( Input::except ( 'password' ) );
		} else {
			// store
			$candidate = Candidate::find ( $id );
			$candidate->first_name = Input::get ( 'first_name' );
			$candidate->middle_name = Input::get ( 'middle_name' );
			$candidate->last_name = Input::get ( 'last_name' );
			$candidate->gender = Input::get ( 'gender' );
			$candidate->address = Input::get ( 'address' );
			$candidate->nationality_id = Input::get ( 'nationality_id' );
			$candidate->resume_title_id = Input::get ( 'resume_title_id' );
			$candidate->profile_summary = Input::get ( 'profile_summary' );
			$candidate->email = Input::get ( 'email' );
			$candidate->mobile = Input::get ( 'mobile' );
			/*
			 * handle file Upload
			 */
			$file = Request::file ( 'resume_file' );
			
			if (Input::hasFile('imaresume_filege')) {
				/*
				 * Upload file
				 */
				$extension = $file->getClientOriginalExtension ();
				
				Storage::disk ( 'local' )->put ( $file->getFilename () . '.' . $extension, File::get ( $file ) );
				/*
				 * Delete old uploaded file
				 */
				$entry = ResumeFileEntry::find ( $candidate->resume_upload_id );
				if (is_null ( $entry )) {
					$entry = new ResumeFileEntry ();
				} else {
					Storage::disk ( 'local' )->delete ( $entry->filename );
				}
				
				/*
				 * Update with new information
				 */
				$entry->mime = $file->getClientMimeType ();
				$entry->original_filename = $file->getClientOriginalName ();
				$entry->filename = $file->getFilename () . '.' . $extension;
				$entry->save ();
				$candidate->resume_upload_id = $entry->id;
			}
			
			$candidate->save ();
			return Redirect::to ( 'recruitments/candidates' );
		}
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id        	
	 * @return Response
	 */
	public function destroy($id) {
		// delete
		$candidate = Candidate::find ( $id );
		$candidate->delete ();
		return Redirect::to ( 'recruitments/candidates' );
	}
	/*
	 * Get uploaded resume file
	 */
	public function getUploadedResumeFile($filename) {
		$entry = ResumeFileEntry::where ( 'filename', '=', $filename )->firstOrFail ();
		$file = Storage::disk ( 'local' )->get ( $entry->filename );
		
		return (new Response ( $file, 200 ))->header ( 'Content-Type', $entry->mime );
	}
	/*
	 * Applied Job section handling
	 */
	public function applyForAJob() {
		$candidate_id = Input::get ( 'candidate_id' );
		$job_id = Input::get ( 'job_id' );
		$notes = Input::get ( 'applicants_note' );
		
		
		$applicant = DB::select ( "	SELECT * 
    			    				FROM tblCandidate_Jobs
    								WHERE 
    									tblCandidate_Jobs.candidate_id=:candidate_id AND
    									tblCandidate_Jobs.job_id =:job_id", [ 
				'candidate_id' => $candidate_id,
				'job_id' => $job_id 
		] );
		Log::info ( 'Save Start' );
		if (count ( $applicant ) == 0) {
			DB::statement ( "INSERT INTO tblCandidate_Jobs(candidate_id, job_id, notes) 
											VALUES (:candidate_id, :job_id, :notes)", [ 
					'candidate_id' => $candidate_id,
					'job_id' => $job_id,
					'notes' => $notes 
			] );
		} else {
			DB::statement ( "UPDATE  tblCandidate_Jobs 
							SET  notes = :notes
							WHERE 
								tblCandidate_Jobs.candidate_id=:candidate_id AND
								tblCandidate_Jobs.job_id =:job_id", [ 
					'candidate_id' => $candidate_id,
					'job_id' => $job_id,
					'notes' => $notes
			] );
		}
		return Redirect::to ( 'recruitments/candidates/'.$candidate_id );
	}

	public function deleteAppliedJob($id) {
		$rc = Candidate_Job::find ( $id );
		$candidate_id = $rc->candidate_id;
		$rc->delete ();
		return Redirect::to ( 'recruitments/candidates/'.$candidate_id );
	}
	
	public function updateAppliedJob($id){		
		$job_id = Input::get ( 'selected_job_id' );
		$notes = Input::get ( 'selected_applicants_note' );		
		try {
			$candidate_job = Candidate_Job::findOrFail ( $id );
			$candidate_job->job_id = $job_id;			
			$candidate_job->notes = $notes;	
			$candidate_job->save();
		}
		catch (ModelNotFoundException $e) {
			// Do nothing
		}
		$candidate_job = Candidate_Job::findOrFail ( $id );
		
		return Redirect::to ( 'recruitments/candidates/'.$candidate_job->candidate_id );	
	}
	/*
	 * Interview section handling
	 */
	public function deleteScheduledInterview($id) {
		$interview = InterviewSchedule::find ( $id );
		/*
		 * Get current candidate's id by job_candidate_id
		 */
		$candidateJob = Candidate_Job::find($interview->candidate_job_id);
		$candidate_id = $candidateJob->candidate_id;
		/*
		 * Delete record
		 */
		$interview->delete ();
		return Redirect::to ( 'recruitments/candidates/'.$candidate_id );
	}
	
	public function scheduleAnInterview() {
		
		$candidate_id       =   Input::get ( 'candidate_id' );
		$applied_job_id     = 	Input::get ( 'applied_job_id' );
		$interview_state    = 	Input::get ( 'interview_state' );
		$interview_datetime =  	Input::get ( 'interview_datetime' );
		$interview_location =  	Input::get ( 'interview_location' );
		$interview_result   =   Input::get ( 'interview_result' );
		$interview_note     = 	Input::get ( 'interview_note' );
		
		Log::info('$interview_datetime : '.$interview_datetime);
				
		$interview = new InterviewSchedule();
		$interview->candidate_job_id = $applied_job_id;
		$interview->interview_state = $interview_state;
		$interview->scheduled_time = $interview_datetime;
		$interview->location = $interview_location;
		$interview->result_id = $interview_result;
		$interview->note = $interview_note;
		$interview->save();
		
		return Redirect::to ( 'recruitments/candidates/'.$candidate_id );		
	}
	public function uploadAvatar(){
		
		$file = Request::file('avatar');
		
		$destinationPath = 'avatars/';
		
		$filename = $file->getClientOriginalName();
		
		$file->move($destinationPath, $filename);
		
		// save the file path on user avatar
		
		$user = User::where('id',$user->id)->first();
		
		$user->avatar = $destinationPath.$filename;
		
		$user->save();
		
		return response()->json(['success' => true, 'file' => asset($destinationPath.$filename) ]);
	}
}
