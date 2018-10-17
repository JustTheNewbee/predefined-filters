<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSavedFiltersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('saved_filters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('filter_key')->index();
            $table->string('filter_url')->index();
            $table->integer('user_id')->unsigned();
            $table->json('form_data');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('saved_filters');
    }
}
