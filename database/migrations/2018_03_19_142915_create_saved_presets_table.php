<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavedPresetsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('saved_presets', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->bigInteger('user_id')->nullable();
			$table->json('preset')->nullable();
			$table->json('index')->nullable();
			$table->longText('thumbnail')->nullable();
			$table->string('name')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('saved_presets');
	}
}
