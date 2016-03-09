<?php

namespace App\Models\Recruitments;

use Illuminate\Database\Eloquent\Model;

class EducationLevel extends Model
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
		$this->table = "tblEducationLevels";
		$this->primaryKey ="id";
		$this->fillable = [
				'name',
				'description'
		];
	}
}
