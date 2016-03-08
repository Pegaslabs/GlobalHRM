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
}
