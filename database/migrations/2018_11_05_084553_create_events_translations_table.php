<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->text('event_name')->nullable();
            $table->text('description')->nullable();
            $table->text('venue')->nullable();
            $table->unsignedInteger('event_id')->nullable();
            $table->foreign('event_id')->references('id')->on('events')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('events_translations');
    }
}
