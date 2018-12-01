<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCityIdToDrawerWebViewDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drawer_web_view_details', function (Blueprint $table) {
            $table->unsignedInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drawer_web_view_details', function (Blueprint $table) {
            $table->dropColumn('city_id');
        });
    }
}
