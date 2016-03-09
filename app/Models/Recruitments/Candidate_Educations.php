<?php

namespace App\Models\Recruitments;

use Illuminate\Database\Eloquent\Model;

class Candidate_Educations extends Model
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
		$this->table = "tblCandidate_Educations";
		$this->primaryKey ="id";
		$this->fillable = [
				'candidate_id',
				'education_id',
				'institute',
				'majority',
				'start_year',
				'graduation_year'				
		];
	}
	public function getEducationLevel(){
		return $this->hasOne('App\Models\Recruitments\EducationLevel','id','education_id');
	}
	
}
