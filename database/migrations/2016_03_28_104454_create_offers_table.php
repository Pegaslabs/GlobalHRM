<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create ( 'tblOffers', function (Blueprint $table) {
			$table->increments('id');
			$table->integer ( 'candidate_job_id' )->comment ( 'candidate applied for a specific job' );
			$table->longText( 'description' )->comment ( 'full description for this job' );
			$table->double  ( 'salary' )->unsigned ()->comment ( 'Offred salary' );
			$table->integer ( 'status_id' )->comment ( 'Job Status' );
			$table->enum    ( 'priority',['SS','S','A','B','C','D']);				
			$table->date    ( 'join_date' )->default ( '0000-00-00' );
			$table->timestamp  ( 'created_at' )->default ( DB::raw ( 'CURRENT_TIMESTAMP' ) );
			$table->timestamp  ( 'updated_at' )->default ( DB::raw ( 'CURRENT_TIMESTAMP' ) );
		} );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop ( 'tblOffers' );
    }
}
