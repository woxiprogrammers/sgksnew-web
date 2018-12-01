<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrawerWebviewDetailsTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drawer_webview_details_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('drawer_webview_details_id')->nullable();
            $table->foreign('drawer_webview_details_id')->references('id')->on('drawer_web_view_details')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('language_id')->nullable();
            $table->foreign('language_id')->references('id')->on('languages')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('drawer_webview_details_translations');
    }
}
