<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchQueriesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('search_queries', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->longText('keywords')->nullable()->default(null);
			$table->bigInteger('query_id')->nullable()->default(null);
			$table->string('query_type')->nullable()->default(null);
			$table->string('object_quick_presets')->nullable()->default(null);
			$table->bigInteger('child_id')->nullable()->default(null);
			$table->json('index')->nullable()->default(null);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('search_queries');
	}
}
