<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {    	
    	Schema::create ( 'tblJobTitles', function (Blueprint $table) {
    		$table->increments ( 'id' );    		
    		$table->string    ('code',10);
    		$table->string    ('name',100);
    		$table->longtext  ('description');
    		$table->timestamp ('created_at' )->default ( DB::raw ( 'CURRENT_TIMESTAMP' ) );
    		$table->timestamp ('updated_at' )->default ( DB::raw ( 'CURRENT_TIMESTAMP' ) );
    	} );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tblJobTitles');
    }
}
