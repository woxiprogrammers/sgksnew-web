<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassifiedsTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classifieds_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',255)->nullable();
            $table->text('classified_desc')->nullable();
            $table->unsignedInteger('classified_id')->nullable();
            $table->foreign('classified_id')->references('id')->on('classifieds')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('classifieds_translations');
    }
}
