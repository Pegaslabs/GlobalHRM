<?php

namespace App\Http\Controllers\Recruitments;

/*
 *
 */
use App\Models\Recruitments\Candidate;
use App\Models\Recruitments\JobTitle;
use App\Models\Recruitments\Job;
use App\Models\Recruitments\Candidate_Jobs;
use App\Models\Recruitments\InterviewResult;
use App\Models\Common\UploadFileEntry;

use App\Models\Organization\Country;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;
/*
 *
 */
use DB, View, Validator, Redirect, Request;
use Storage, File, Image;
use Session;

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
			
			$candidateSkills = Input::get ('candidate_skills');
			$arrCandidateSkills = explode(',', $candidateSkills);
			var_dump($arrCandidateSkills);
			exit(1);
			
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
						$image = Image::make(sprintf(storage_path().'/app/avatar/%s', $fileName))->resize(150, 150)->save(); // Resize image
						
						$AvatarEntry = new UploadFileEntry ();
						$AvatarEntry->mime = $avatar_file->getClientMimeType ();
						$AvatarEntry->category = 1;
						$AvatarEntry->original_filename = $avatar_file->getClientOriginalName ();
						$AvatarEntry->filename = $fileName;						
						$AvatarEntry->save ();		
						$candidate->avatar_upload_id = $AvatarEntry->id;						
					}
					else {
						// sending back with error message.
						Session::flash('errors', trans('labels.recruitments.candidates.messages.001_RC_CANDIDATE_CREATE_FAILED'));
						return Redirect::to('recruitments/candidates/create');
					}									
				}
			}
			/*
			 * Handle CV Upload
			 */
			if (Input::hasFile('resume_file')){
				$cvfile = Request::file ( 'resume_file' );
				$extension = $cvfile->getClientOriginalExtension ();
				Storage::disk ( 'local' )->put ( 'cv/'. $cvfile->getFilename () . '.' . $extension, File::get ( $cvfile ) );
				
				$ResumeEntry = new UploadFileEntry ();
				$ResumeEntry->mime = $cvfile->getClientMimeType ();
				$ResumeEntry->category = 2;
				$ResumeEntry->original_filename = $cvfile->getClientOriginalName ();
				$ResumeEntry->filename = $cvfile->getFilename () . '.' . $extension;
				
				$ResumeEntry->save ();
				$candidate->resume_upload_id = $ResumeEntry->id;			
			}
			/*
			 *
			 */
			$candidate->save ();
			Session::flash('success', trans('labels.recruitments.candidates.messages.000_RC_CANDIDATE_CREATE_SUCCESS'));				
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
		
		$candidate = Candidate::find($id);
		
		$resume_upload_id = $candidate->resume_upload_id;
		
		$avatar_upload_id = $candidate->avatar_upload_id;
		/*
		 * CVFile reference
		 */
		$cvFile = null;
		if (($resume_upload_id != 0) || (!is_null($resume_upload_id) )){
			$cvFile = UploadFileEntry::find($resume_upload_id)->filename;
		}
		/*
		 * Avatar reference
		 */
		$avatarFile = null;
		if (($avatar_upload_id != 0) || (!is_null($avatar_upload_id) )){
			$avatarFile = UploadFileEntry::find($avatar_upload_id)->filename;
		}
		
		/*
		 * Get Education History
		 */
		$educationHistory = $candidate->getEducationHistory;
		/*
		 * Get Personal Skill List
		 */
		$skillList = $candidate->getSkillList;
		
		/*
		 * Get list of applied Job
		 */
		
		$appliedJobs = $candidate->getJobList;
		
		
		foreach ($appliedJobs as $appliedJob){
			$interviewSchedules = $appliedJob->getInterviewList;
			$interviewSchedules = $interviewSchedules->reject(function ($interviewSchedule) {
				$now = new \DateTime("now");
				$scheduled_time = new \DateTime($interviewSchedule->scheduled_time);
				$dateDiff = $now->diff($scheduled_time);
    			return ($dateDiff->invert !=1);
			})->all();
		}
				
		$mstInterviewResults = InterviewResult::all();
		
		/*
		 * Display View
		 */
		return View::make ( 'recruitments.candidates.show' )
					 ->with ('mstInterviewResults', $mstInterviewResults)
			   		 ->with ( 'candidate', $candidate )
					 ->with ( 'cvFile', $cvFile)
					 ->with ( 'avatarFile', $avatarFile)
					 ->with ( 'educationHistory', $educationHistory)
					 ->with ( 'skillList' , $skillList)
					 ->with ( 'appliedJobs',$appliedJobs);
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id        	
	 * @return Response
	 */
	public function edit($id) {
		/*
		 * Get Candidate Information Detail
		 */
		$candidateInfo = Candidate::find($id);
		
		$resume_upload_id = $candidateInfo->resume_upload_id;
		
		$avatar_upload_id = $candidateInfo->avatar_upload_id;
		/*
		 * CVFile reference
		 */
		$cvFile = null;
		if (($resume_upload_id != 0) || (!is_null($resume_upload_id) )){
			$cvFile = UploadFileEntry::find($resume_upload_id)->filename;
		}
		/*
		 * Avatar reference
		 */
		$avatarFile = null;
		if (($avatar_upload_id != 0) || (!is_null($avatar_upload_id) )){
			$avatarFile = UploadFileEntry::find($avatar_upload_id)->filename;
		}
		
		/*
		 * Nationality selection
		 */
		$mstCountries = Country::all();
		/*
		 *
		 */
		
		/*
		 * Job Title selection
		 */
		$mstJobTitles = JobTitle::all ();
		
		/*
		 * Render view
		 */
		
		return View::make ( 'recruitments.candidates.edit' )
							->with ( 'avatarFile', $avatarFile)
							->with ( 'cvFile', $cvFile)
				            ->with ( 'candidateInfo', $candidateInfo )
		                    ->with ( 'mstJobTitles', $mstJobTitles )
		                    ->with ( 'mstCountries', $mstCountries )
							->withInput(Input::except('password'));
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
			if (Input::hasFile('avatar_file')){				
				$avatar_file = Request::file ( 'avatar_file' );
				$avatar = array('image' => $avatar_file);
				$rules = array('image' => 'mimes:jpeg,bmp,png');
				$validator = Validator::make($avatar, $rules);
				if ($validator->fails ()){
					return Redirect::to ( 'recruitments/candidates/create' )->withErrors ( $validator )->withInput ( Input::except ( 'password' ) );
				}else{					
					if ($avatar_file ->isValid()) {
						/*
						 * Delete current avatar
						 */
						$avatar_delete_id = $candidate->avatar_upload_id;
						$deleteAvatarFilename = null;
						if (($avatar_delete_id != 0) || (!is_null($avatar_delete_id) )){
							$deleteAvatarFileEntry = UploadFileEntry::find($avatar_delete_id);
							$deleteAvatarFilename = $deleteAvatarFileEntry->filename;
							if(Storage::disk('local')->exists('avatar/'.$deleteAvatarFilename)){
								Storage::disk('local')->delete('avatar/'.$deleteAvatarFilename);
								$deleteAvatarFileEntry->delete();
							}
						}
						
						/*
						 * Upload new avatar
						 */
						$destinationPath = 'avatar';
						$extension = $avatar_file->getClientOriginalExtension(); // getting image extension
						$fileName = 'img_'.time().'.'.$extension;                // renameing image
						
						Storage::disk('local')->put($destinationPath.'/'.$fileName, File::get($avatar_file));						
						$image = Image::make(sprintf(storage_path().'/app/avatar/%s', $fileName))->resize(150, 150)->save(); // Resize image
						
						$AvatarEntry = new UploadFileEntry ();
						$AvatarEntry->mime = $avatar_file->getClientMimeType ();
						$AvatarEntry->category = 1;
						$AvatarEntry->original_filename = $avatar_file->getClientOriginalName ();
						$AvatarEntry->filename = $fileName;						
						$AvatarEntry->save ();		
						$candidate->avatar_upload_id = $AvatarEntry->id;	
						
					}
					else {
						// sending back with error message.
						Session::flash('errors', trans('labels.recruitments.candidates.messages.001_RC_CANDIDATE_CREATE_FAILED'));
						return Redirect::to('recruitments/candidates/create');
					}									
				}
			}
			/*
			 * Handle CV Upload
			 */
			if (Input::hasFile('resume_file')){
				
				/*
				 * Delete current resume
				 */
				$resume_delete_id = $candidate->resume_upload_id;
				$deleteCVFilename = null;
				if (($resume_delete_id != 0) || (!is_null($resume_delete_id) )){
					$deleteCVFileEntry = UploadFileEntry::find($resume_delete_id);
					$deleteCVFilename  = $deleteCVFileEntry->filename;
					if(Storage::disk('local')->exists('cv/'.$deleteCVFilename)){
						Storage::disk('local')->delete('cv/'.$deleteCVFilename);
						$deleteCVFileEntry->delete();
					}
				}
				/*
				 * Upload new resume
				 */
				
				$cvfile = Request::file ( 'resume_file' );
				$extension = $cvfile->getClientOriginalExtension ();
				Storage::disk ( 'local' )->put ( 'cv/'. $cvfile->getFilename () . '.' . $extension, File::get ( $cvfile ) );
				
				$ResumeEntry = new UploadFileEntry ();
				$ResumeEntry->mime = $cvfile->getClientMimeType ();
				$ResumeEntry->category = 2;
				$ResumeEntry->original_filename = $cvfile->getClientOriginalName ();
				$ResumeEntry->filename = $cvfile->getFilename () . '.' . $extension;
				
				$ResumeEntry->save ();
				$candidate->resume_upload_id = $ResumeEntry->id;			
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
	 * Get Uploaded resume file
	 */
	public function getUploadedResumeFile($filename) {
		$entry = UploadFileEntry::where ( 'filename', '=', $filename )->firstOrFail ();
		if(Storage::disk('local')->exists('cv/'. $entry->filename)){		
			$file = Storage::disk ( 'local' )->get ('cv/'. $entry->filename );		
			return (new Response ( $file, 200 ))->header ( 'Content-Type', $entry->mime );
		}
	}
	/*
	 * Applicantion Handler
	 */
	public function createNewApplication() {
		
		$candidate_id = Request::get ( 'candidate_id' );
		$job_id       = Request::get ( 'job_id' );
		$notes        = Request::get ( 'applicants_note' );
		
		$appliedJob = new Candidate_Jobs;
		$appliedJob->candidate_id = $candidate_id;
		$appliedJob->job_id = $job_id;
		$appliedJob->notes = $notes;
		$appliedJob->save();
		return Redirect::to ( 'recruitments/candidates/'.$candidate_id );
	}
	
	public function deleteApplication($id) {
		$rc = Candidate_Jobs::find ( $id );
		$candidate_id = $rc->candidate_id;
		$rc->delete ();
		return Redirect::to ( 'recruitments/candidates/'.$candidate_id );
	}
	
	public function updateApplication($id){		
		
		$job_id = Input::get ( 'selected_job_id' );
		$notes = Input::get ( 'selected_applicants_note' );		
		
		$candidate_job = Candidate_Job::findOrFail ( $id );
		$candidate_job->job_id = $job_id;			
		$candidate_job->notes = $notes;	
		$candidate_job->save();
		
		return Redirect::to ( 'recruitments/candidates/'.$candidate_job->candidate_id );	
	}
	
}
