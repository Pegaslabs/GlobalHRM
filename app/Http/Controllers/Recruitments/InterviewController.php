<?php

namespace App\Http\Controllers\Recruitments;

use App\Http\Controllers\Controller;
use App\Models\Recruitments\InterviewSchedule;
use Input;

class InterviewController extends Controller {
	public function index() {
	}
	public function edit($id) {
	}
	public function update($id) {
	}
	public function create() {
	}
	public function store() {
		$candidate_job_id   = Input::get ( 'candidate_job_id' );
		$interview_state    = Input::get ( 'interview_state' );
		$interview_datetime = Input::get ( 'interview_datetime' );
		$interview_location = Input::get ( 'interview_location' );
		$interview_result   = Input::get ( 'interview_result' );
		$interview_note     = Input::get ( 'interview_note' );
		$interviewer_id     = Input::get ( 'interviewer_id' );
		
		$interview = new InterviewSchedule ();
		$interview->candidate_job_id = $candidate_job_id;
		$interview->interview_state = $interview_state;
		$interview->scheduled_time = $interview_datetime;
		$interview->location = $interview_location;
		$interview->interviewer_id = $interviewer_id;
		$interview->result_id = $interview_result;
		$interview->notes = $interview_note;
		$interview->save ();
	}
	public function show($id) {
	}
	public function destroy($id) {
	}
}
