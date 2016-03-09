<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblCandidate_Jobs', function (Blueprint $table) {     
        	$table->increments('id');    	 
            $table->integer('candidate_id');
            $table->integer('job_id');
            $table->longtext('notes');
			$table->timestamp  ( 'created_at' )->default ( DB::raw ( 'CURRENT_TIMESTAMP' ) );
			$table->timestamp  ( 'updated_at' )->default ( DB::raw ( 'CURRENT_TIMESTAMP' ) );        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tblCandidate_Jobs');
    }
}
