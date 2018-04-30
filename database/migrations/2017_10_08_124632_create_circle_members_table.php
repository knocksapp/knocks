<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCircleMembersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('circle_members', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->bigInteger('user_id')->unsigned(); //foreign key user
			$table->bigInteger('owner_id')->unsigned(); //foreign key user
			$table->bigInteger('circle_id')->unsigned(); //foreign key circle
			$table->json('index')->nullable();
		});
		Schema::table('circle_members', function (Blueprint $table) {
			// $table->foreign('user_id')->references('id')->on('users');
			// $table->foreign('circle_id')->references('id')->on('circles');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('circle_members');
	}
}
