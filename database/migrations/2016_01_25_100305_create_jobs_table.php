<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateJobsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'tblJobs', function (Blueprint $table) {
			$table->increments('id');
			$table->integer ( 'title_id' )->unsigned ()->comment ( 'job title id' );
			$table->float   ('no_pos' )->unsigned ()->default ( 0.0 )->comment ( 'number of positions' );
			$table->string  ( 'short_description', 1000 )->comment ( 'Short description for this job' );
			$table->longText( 'description' )->comment ( 'full description for this job' );
			$table->integer ( 'department_id' )->unsigned ()->comment ( 'Department which request to post this job' );
			$table->integer ( 'employment_type_id' )->unsigned ()->comment ( 'Employment type' );
			$table->integer ( 'experience_level_id' )->unsigned ()->comment ( 'Experience type' );
			$table->integer ( 'job_function_id' )->unsigned ()->nullable()->comment ( 'Job Function' );
			$table->integer ( 'education_level_id' )->unsigned ()->nullable()->comment ( 'Education level' );
			$table->integer ( 'nationality_id' )->unsigned ()->comment ( 'Nationality' );
			$table->double  ( 'min_salary' )->unsigned ()->comment ( 'Min salary' );
			$table->double  ( 'max_salary' )->unsigned ()->comment ( 'Max salary' );
			$table->integer ( 'status_id' )->comment ( 'Job Status' );
			$table->enum       ( 'priority',['SS','S','A','B','C','D']);				
			$table->date       ( 'closing_date' )->default ( '0000-00-00' );
			$table->timestamp  ( 'created_at' )->default ( DB::raw ( 'CURRENT_TIMESTAMP' ) );
			$table->timestamp  ( 'updated_at' )->default ( DB::raw ( 'CURRENT_TIMESTAMP' ) );
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop ( 'tblJobs' );
	}
}
