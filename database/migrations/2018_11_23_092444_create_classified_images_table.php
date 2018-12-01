<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassifiedImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classified_images', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('classified_id')->nullable();
            $table->foreign('classified_id')->references('id')->on('classifieds')->onUpdate('cascade')->onDelete('cascade');
            $table->string('image_url')->nullable();
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
        Schema::dropIfExists('classified_images');
    }
}
