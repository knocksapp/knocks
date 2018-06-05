<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLogsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('user_logs', function (Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->bigInteger('user_id')->nullable()->default(null);
			$table->json('index')->nullable();
			$table->string('url')->nullable()->default(null);
			$table->string('method')->nullable()->default(null);
			$table->string('ip')->nullable()->default(null);
			$table->string('os')->nullable()->default(null);
			$table->string('os_version')->nullable()->default(null);
			$table->string('browser')->nullable()->default(null);
			$table->string('browser_version')->nullable()->default(null);
			$table->string('device')->nullable()->default(null);

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('user_logs');
	}
}
