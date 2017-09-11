<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slideshows', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('format');
            $table->timestamps();
        });

        Schema::create('slideshow_slides', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('slideshow_id')->unsigned();
            $table->string('image');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('text')->nullable();
            $table->string('link')->nullable();
            $table->string('page_id')->nullable();
            $table->integer('parent_id')->default(0)->nullable();
            $table->integer('lft')->unsigned()->nullable();
            $table->integer('rgt')->unsigned()->nullable();
            $table->integer('depth')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('slideshow_slides');
        Schema::drop('slideshows');
    }
}
