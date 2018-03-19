<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserHashtagsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('user_hashtags', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->string('hashtag')->nullable()->default(NULL);
			$table->bigInteger('user_id')->unsigned();
			$table->bigInteger('object_id')->nullable()->default(NULL);
			$table->string('parent_type')->nullable()->default(NULL);
			$table->bigInteger('parent_id')->nullable()->default(NULL);
			$table->json('index')->nullable()->default(NULL);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('user_hashtags');
	}
}
