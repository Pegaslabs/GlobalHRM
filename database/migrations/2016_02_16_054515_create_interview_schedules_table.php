<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterviewSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblInterviewSchedules', function (Blueprint $table) {
            $table->increments('id');       	 
            $table->integer('candidate_job_id');
            $table->enum('interview_state',['1st Interview', '2nd Interview', '3rd Interview', 'Final Interview']);
            $table->integer('interviewer_id')->default(0);
            $table->datetime('scheduled_time')->nullable();   
            $table->datetime('scheduled_time_end')->nullable();
            $table->string('location')->nullable();
            $table->string('result_id', 255);
            $table->longtext('notes')->nullable();
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
        Schema::drop('tblInterviewSchedules');
    }
}
