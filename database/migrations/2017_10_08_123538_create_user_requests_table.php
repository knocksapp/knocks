<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRequestsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('user_requests', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->string('response')->nullable();
			$table->bigInteger('sender_id')->unsigned(); //foregin key user
			$table->bigInteger('reciver_id'); //foregin key user
			$table->json('circles')->nullable()->default(Null);
			$table->json('index')->nullable();
			$table->string('parent_type')->nullable()->default('user');
		});
		Schema::table('user_requests', function (Blueprint $table) {
			// $table->foreign('sender_id')->references('id')->on('users');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('user_requests');
	}
}
