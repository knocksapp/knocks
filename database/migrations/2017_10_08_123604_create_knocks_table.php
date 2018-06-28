<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKnocksTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('knocks', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->longText('body')->nullable()->default(NULL);
			$table->bigInteger('at');
			$table->string('type');
			$table->longText('text_content')->nullable()->default(NULL);
			$table->bigInteger('user_id')->unsigned(); //user foreign key
			$table->bigInteger('object_id')->unsigned(); //object foreign key
			$table->json('index')->nullable();
			$table->string('quick_preset')->nullable()->default(NULL);
			$table->longText('keywords')->nullable()->default(NULL);
			$table->bigInteger('shared')->nullable()->default(NULL); //user foreign key
		});
		Schema::table('knocks', function (Blueprint $table) {
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
		Schema::dropIfExists('knocks');
	}
}
