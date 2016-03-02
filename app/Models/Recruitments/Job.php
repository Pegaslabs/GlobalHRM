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
}
