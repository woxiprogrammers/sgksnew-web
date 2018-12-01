<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('package_id')->nullable();
            $table->foreign('package_id')->references('id')->on('classified_packages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('package_desc')->nullable();
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
        Schema::dropIfExists('package_rules');
    }
}
