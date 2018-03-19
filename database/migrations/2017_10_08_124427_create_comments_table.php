<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('comments', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->longText('body')->nullable()->default(Null);
			$table->bigInteger('at');
			$table->string('type');
			$table->longText('text_content')->nullable()->default(NULL);
			$table->bigInteger('post_id')->unsigned(); //post foreign key
			$table->bigInteger('user_id')->unsigned(); //user foreign key
			$table->bigInteger('object_id')->unsigned(); //object foreign key
			$table->json('index')->nullable();
			$table->string('quick_preset')->nullable()->default(NULL);
			$table->longText('keywords')->nullable()->default(NULL);
		});
		Schema::table('comments', function (Blueprint $table) {
			// $table->foreign('user_id')->references('id')->on('users');
			// $table->foreign('object_id')->references('id')->on('objects');
			// $table->foreign('post_id')->references('id')->on('knocks');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('comments');
	}
}
