<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCheckinsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('user_checkins', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->bigInteger('lat')->nullable()->default(NULL);
			$table->bigInteger('lang')->nullable()->default(NULL);
			$table->bigInteger('user_id')->nullable()->default(NULL);
			$table->string('address')->nullable()->default(NULL);
			$table->json('location')->nullable()->default(NULL);
			$table->json('index')->nullable()->default(NULL);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('user_checkins');
	}
}
