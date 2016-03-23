<?php

namespace App\Http\Controllers\Recruitments;

use App\Http\Controllers\Controller;
use App\Models\Recruitments\InterviewSchedule;
use App\Models\Recruitments\Candidate_Jobs;
use App\Models\Recruitments\InterviewResult;

use Input, Redirect;
use View, Log;
use DB;

class InterviewController extends Controller {
	public function index() {
		$mstInterviewResults = InterviewResult::all();
		
		return View::make('recruitments.interviews.index')
							->with ('mstInterviewResults', $mstInterviewResults)
							->with('candidate', null);
	}
	public function edit($id) {
		
	}
	public function update($id) {
		$interview = InterviewSchedule::find( $id );
		
		$scheduled_time = Input::get('start');
		$scheduled_time_end = Input::get('end');

		if($interview){				
			$interview->scheduled_time = $scheduled_time;
			$interview->scheduled_time_end = $scheduled_time_end;			
			$interview->save();			
			$res = response()->json(['success'=>true,'data'=>json_encode($interview)]);
		}else
				$res = response()->json(['success'=>false, 'data' => 'Can not find data from tblInterviewSchedules.']);
		return $res ;
		
	}
	public function create() {
		
	}
	public function store() {
		$candidate_id   = Input::get ('candidate_id' );
		$job_id 		= Input::get ('applied_job_id');
		
		$candidate_job   = Candidate_Jobs::where(['candidate_id'=>$candidate_id, 'job_id'=>$job_id])->first();
		
		$interview_state    = Input::get ( 'interview_state' );
		
		$interview_start_datetime = Input::get ( 'interview_start_datetime' );
		$interview_end_date_time  = Input::get ( 'interview_end_datetime' );
		
		$interview_location = Input::get ( 'interview_location' );
		$result_id          = Input::get ( 'result_id' );
		$interview_note     = Input::get ( 'interview_note' );
		$interviewer_id     = Input::get ( 'interviewer_id' );
		
		$interview = new InterviewSchedule ();
		$interview->candidate_job_id = $candidate_job->id;
		$interview->interview_state = $interview_state;
		
		$interview->scheduled_time = $interview_start_datetime;
		$interview->scheduled_time_end = $interview_end_date_time;
		
		
		$interview->location = $interview_location;
		$interview->interviewer_id = $interviewer_id;
		$interview->result_id = $result_id;
		$interview->notes = $interview_note;
		$interview->save ();
		
		$redirect_url =  Input::get ( 'redirect_url' );
		if(!is_null($redirect_url)){
			return Redirect::to($redirect_url);
				
		}
	}
	public function show($id) {
		$interview = InterviewSchedule::find( $id );
		$candidateJob = $interview->getCandidateJobInfo;
		$job = $candidateJob->getJobInfo;
		$title = $job->title;
		$jobFunction = $job->jobFunction;
		if(!is_null($interview))
			$res = response()->json(['success'=>true,'data'=>json_encode($interview)]);
		else
			$res = response()->json(['success'=>false, 'data' => 'Can not find data from tblInterviewSchedules.']);
		return $res ;
	}
	public function getInterviewInfoByID($id){
		$interview = InterviewSchedule::find( $id );

		if(!is_null($interview))
			$res = response()->json(['success'=>true,'data'=>json_encode($interview)]);
		else
			$res = response()->json(['success'=>false, 'data' => 'Can not find data from tblInterviewSchedules.']);
		return $res ;
	}
	
	public function destroy($id) {
		$interview = InterviewSchedule::find ( $id );
		/*
		 * Get current candidate's id by job_candidate_id
		 */
		$candidateJobs = Candidate_Jobs::find($interview->candidate_job_id);
		$candidate_id = $candidateJobs->candidate_id;
		/*
		 * Delete record
		 */
		$interview->delete ();
		return Redirect::to ( 'recruitments/candidates/'.$candidate_id );
	}
	/*
	 * 
	 */
	public function getAllInterviewsByPeriod()
	{		
		$inputStart = Input::get('start');
		$inputEnd   = Input::get('end');
		
		Log::info($inputStart);
		Log::info($inputEnd);
				
		//$res = response()->json(['success'=>true, 'data' => json_encode($candidate_jobs)]);
		
		$pivotStart = date('Y-m-d H:i:s',$inputStart);
		$pivotEnd   = date('Y-m-d H:i:s',$inputEnd);
		
		
		$interviewSchedules = DB::table('tblInterviewSchedules')
							->whereBetween('scheduled_time',array($pivotStart, $pivotEnd))
							->get();
		
		$events = array();
		foreach($interviewSchedules as $interviewSchedule){
			$candidate_job = Candidate_Jobs::find($interviewSchedule->candidate_job_id);
			$candidate = $candidate_job->getCandidateInfo;
			$job= $candidate_job->getJobInfo; 
			$event = array();
			$event['id'] = $interviewSchedule->id;
			$title = '['. 'JD'.str_pad($job->id, 8 , "0", STR_PAD_LEFT) . ']';
			$title = $title . $candidate->first_name.' '. $candidate->middle_name.' '. $candidate->last_name;
			$event['title'] = $title;
			$scheduled_start =  $interviewSchedule->scheduled_time;
			$scheduled_end   =  $interviewSchedule->scheduled_time_end;
			
			if(!is_null($scheduled_start)){
				$event['start'] = $scheduled_start;
				$event['end']   = $scheduled_end;
			}
			if(!is_null($scheduled_end)){					
				$event['end']   = $scheduled_end;
			}	
			
			$event['className'] = 'fc-content';
			$event['textColor'] = 'black';
			$event['allDay'] = (is_null($scheduled_start)||is_null($scheduled_end));
			//$event['url'] = route('recruitments.interviews.show',['interviews'=>$interviewSchedule->id]);
			array_push($events, $event);				
		}									
		$res = json_encode($events);		
		return $res;
	}
}
