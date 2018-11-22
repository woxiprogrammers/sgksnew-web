<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrawerWebViewDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drawer_web_view_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('drawer_web_id')->nullable();
            $table->foreign('drawer_web_id')->references('id')->on('drawer_web_view')->onUpdate('cascade')->onDelete('cascade');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('drawer_web_view_details');
    }
}
