<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidateEducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblCandidate_Educations', function (Blueprint $table) {      
        	$table->increments('id');        	 
            $table->integer('candidate_id');
            $table->integer('education_id')->unsigned();            
            $table->string('institute', 100);
            $table->string('majority',200)->default(null);
            $table->date('start_year');
            $table->date('graduation_year');          
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
    	Schema::drop('tblCandidate_Educations');
    }
}
