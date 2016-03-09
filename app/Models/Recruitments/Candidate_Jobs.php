<?php

namespace App\Models\Recruitments;

use Illuminate\Database\Eloquent\Model;

class Candidate_Jobs extends Model
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
		$this->table = "tblCandidate_Jobs";
		$this->primaryKey ="id";
		$this->fillable = [
				'candidate_id',
				'job_id',
				'notes'					
		];
	}
	public function getJobInfo(){
		return $this->hasOne('App\Models\Recruitments\Job','id','job_id');
	}
	public function getInterviewList(){
		return $this->hasMany('App\Models\Recruitments\InterviewSchedule','candidate_job_id','id');
	}
	
}
