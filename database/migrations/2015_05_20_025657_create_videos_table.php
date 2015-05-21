<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('videos', function($table)
        {
            $table->increments('id');
            $table->string('video_id');
            $table->integer('position');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('published_at');
            $table->timestamp('imported_at');
            $table->timestamp('updated_at');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('videos');
	}

}
