<?php

namespace App\Models\Recruitments;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
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
		$this->table = "tblCandidates";
		$this->primaryKey ="id";
	}
	public function getEducationHistory()
	{
		return $this->hasMany('App\Models\Recruitments\Candidate_Educations', 'candidate_id', 'id');
	}
	public function getSkillList()
	{
		return $this->hasMany('App\Models\Recruitments\Candidate_Skills', 'candidate_id', 'id');
	}
	public function getJobList()
	{		
		return $this->hasMany('App\Models\Recruitments\Candidate_Jobs', 'candidate_id', 'id');
	}
}
