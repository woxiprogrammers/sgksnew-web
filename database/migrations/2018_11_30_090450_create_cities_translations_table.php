<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name','255')->nullable();
            $table->unsignedInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('language_id')->nullable();
            $table->foreign('language_id')->references('id')->on('languages')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('cities_translations');
    }
}
