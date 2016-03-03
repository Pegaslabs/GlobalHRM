<?php

namespace App\Models\Recruitments;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
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
	/*
	 * 
	 */
	protected $fillable;
	
	public function __construct()
	{
		$this->table      = "tblJobs";
		$this->primaryKey = "id";
		$this->fillable = [
				'title_id', 
				'no_pos', 
				'short_description',
				'description',
				'department_id',
				'employment_type_id',
				'experience_level_id',
				'job_function_id',
				'education_level_id',
				'nationality_id',
				'min_salary',
				'max_salary',
				'status_id',
				'priority',
				'closing_date'
		];
	}
	/*
	 * Eloquent: Relationships
	 */
	
	public function status()
	{
		return $this->belongsTo('App\Models\Recruitments\JobStatus', 'status_id', 'id');
	}
	public function title(){
		return $this->belongsTo('App\Models\Recruitments\JobTitle',  'title_id', 'id');
	}
	public function department(){
		return $this->belongsTo('App\Models\Organization\Department',  'department_id', 'id');
	}
	public function empType(){
		return $this->belongsTo('App\Models\Recruitments\EmploymentType',  'employment_type_id', 'id');
	}
	public function empLevel(){
		return $this->belongsTo('App\Models\Recruitments\EmploymentLevel',  'experience_level_id', 'id');
	}
}
