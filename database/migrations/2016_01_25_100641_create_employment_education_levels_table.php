<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmploymentEducationLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create ( 'tblEducationLevels', function (Blueprint $table) {
			$table->increments ( 'id' )->unsigned ();
			$table->string ( 'name', 100 );
			$table->longtext ( 'description' );
			$table->timestamp ( 'created_at' )->default ( DB::raw ( 'CURRENT_TIMESTAMP' ) );
			$table->timestamp ( 'updated_at' )->default ( DB::raw ( 'CURRENT_TIMESTAMP' ) );
		} );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop ('tblEducationLevels');
    }
}
