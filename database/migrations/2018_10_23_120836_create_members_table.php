<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name','255')->nullable();
            $table->string('middle_name','255')->nullable();
            $table->string('last_name','255')->nullable();
            $table->string('gender',255)->nullable();
            $table->text('address')->nullable();
            $table->timestamp('date_of_birth')->nullable();
            $table->unsignedInteger('blood_group_id')->nullable();
            $table->foreign('blood_group_id')->references('id')->on('blood_group_types')->onUpdate('cascade')->onDelete('cascade');
            $table->string('mobile','255')->nullable();
            $table->string('email','255')->nullable();
            $table->unsignedInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onUpdate('cascade')->onDelete('cascade');
            $table->string('longitude','255')->nullable();
            $table->string('latitude','255')->nullable();
            $table->string('profile_image')->nullable();
            $table->boolean('is_active')->nullable()->default(true);
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
        Schema::dropIfExists('members');
    }
}
