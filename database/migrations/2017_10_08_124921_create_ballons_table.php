<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBallonsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('ballons', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->boolean('poped')->default(0);
			$table->boolean('seen')->default(0);
			$table->bigInteger('parent_id')->nullable()->default(Null); //carries (POST / Comment / .. etc)
			$table->bigInteger('user_id')->unsigned(); //foreign key user
			$table->bigInteger('object_id')->unsigned(); //foreign key object
			$table->string('content')->nullable()->default(Null);
			$table->string('category')->nullable()->default(Null);
			$table->json('index')->nullable();
		});
		Schema::table('ballons', function (Blueprint $table) {
			// $table->foreign('user_id')->references('id')->on('users');
			// $table->foreign('object_id')->references('id')->on('objects');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('ballons');
	}
}
