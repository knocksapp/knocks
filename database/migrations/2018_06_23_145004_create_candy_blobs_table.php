<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandyBlobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candy_blobs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
      			$table->bigInteger('kid_id');
            $table->bigInteger('parent_id');
            $table->bigInteger('req_id');
      			$table->string('status');
      			$table->json('index')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candy_blobs');
    }
}
