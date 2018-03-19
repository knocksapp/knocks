<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHashtagsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('hashtags', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->string('hashtag')->nullable()->default(NULL);
			$table->string('country')->nullable()->default(NULL);
			$table->bigInteger('count')->nullable()->default(NULL);
			$table->json('index')->nullable()->default(NULL);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('hashtags');
	}
}
