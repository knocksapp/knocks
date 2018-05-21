<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('user_addresses', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->bigInteger('user_id')->unsigned(); //User id
			$table->bigInteger('object_id')->unsigned(); //Object id
			$table->string('country')->nullable()->default(NULL);
			$table->string('state')->nullable()->default(NULL);
			$table->string('region')->nullable()->default(NULL);
			$table->string('current')->nullable()->default('f');
			$table->string('zipcode')->nullable()->default(NULL);
			$table->json('index')->nullable()->default(NULL);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('user_addresses');
	}
}
