<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('objs', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->bigInteger('user_id')->unsigned(); //User id
			$table->string('type');
			$table->longText('keywords')->nullable()->default(NULL);
			$table->boolean('has_media');
			$table->json('index')->nullable();
			$table->string('quick_preset')->nullable()->default(NULL);

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('objs');
	}
}
