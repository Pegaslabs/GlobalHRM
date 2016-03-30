<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblCandidates', function (Blueprint $table) {            
            $table->increments('id');
            $table->string('first_name',50);
            $table->string('middle_name',50);           
            $table->string('last_name',50);
            $table->enum('gender',['Male','Female','Unspecified']);
            $table->string('address',500);            
            $table->integer('nationality_id')->unsigned();
            $table->string('mobile', 12)->unique();
            $table->string('email', 100)->unique();
            $table->integer('resume_title_id');
            $table->string('resume_headline',200);            
            $table->integer('resume_upload_id');  
            $table->integer('avatar_upload_id');           
            $table->string('profile_summary',1000);      
            $table->timestamps ();        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tblCandidates');
    }
}
