<?php

namespace App\Models\Recruitments;

use Illuminate\Database\Eloquent\Model;

class InterviewSchedule extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table;
	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];
	
	/**
	 * Define our custom primary key
	 */
	
	protected $primaryKey;
	
	public function __construct()
	{
		$this->table = "tblInterviewSchedules";
		$this->primaryKey ="id";
		$this->fillable = [
				'candidate_job_id',
				'interview_state',
				'interviewer_id',
				'scheduled_time',
				'location',
				'result_id',
				'notes'					
		];
	}
	public function getInterviewResult(){
		return $this->hasOne('App\Models\Recruitments\InterviewResult','id','result_id');
	}	
}
