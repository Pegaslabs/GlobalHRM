<?php

namespace App\Models\Recruitments;

use Illuminate\Database\Eloquent\Model;

class Candidate_Skills extends Model
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
		$this->table = "tblCandidate_Skills";
		$this->primaryKey ="id";
		$this->fillable = [
				'candidate_id',
				'skill_id',
				'no_years'					
		];
	}
	public function getSkill(){
		return $this->hasOne('App\Models\Recruitments\Skill','id','skill_id');
	}
	
}
