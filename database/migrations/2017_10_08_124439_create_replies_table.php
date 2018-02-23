<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replies', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->timestamps();
          $table->longText('body');
          $table->bigInteger('at');
          $table->string('type');
          $table->longText('text_content')->nullable()->default(NULL);
          // $table->bigInteger('comment_id')->unsigned()->nullable()->default(Null); //comment foreign key
          // $table->bigInteger('post_id')->unsigned()->nullable()->default(Null); //post foreign key
          $table->bigInteger('user_id')->unsigned(); //user foreign key
          $table->bigInteger('parent_id'); //parent , could be (Post , Comment , Reply)
          $table->string('parent_type');
          $table->bigInteger('object_id')->unsigned(); //object foreign key
          $table->json('index')->nullable();
        });
        Schema::table('replies', function(Blueprint $table){
            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('object_id')->references('id')->on('objects');
            // $table->foreign('post_id')->references('id')->on('knocks');
            // $table->foreign('comment_id')->references('id')->on('comments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replies');
    }
}
