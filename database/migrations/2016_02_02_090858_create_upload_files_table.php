<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblUploadFiles', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('category');
			$table->string('filename');
			$table->string('mime');
			$table->string('original_filename');
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tblUploadFiles');
    }
}
