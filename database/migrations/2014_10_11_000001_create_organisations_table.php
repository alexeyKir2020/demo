<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organisations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255);
            $table->string('link', 255)->nullable();
            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('organisation_types');
            $table->integer('city_id')->unsigned()->nullable();
            $table->foreign('city_id')->references('id')->on('cities');
            $table->string('reg_number',100);
            $table->string('email', 255);
            $table->string('avatar')->nullable();
            $table->string('contact_person', 255);
            $table->string('phone',100)->nullable();
            $table->string('addition_phone',100)->nullable();
            $table->string('addition_email',255)->nullable();
            $table->tinyInteger('status')->unsigned();
            $table->tinyInteger('previous_status')->unsigned()->nullable();
            $table->json('requested_changes')->nullable();
            $table->softDeletes();
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
        Schema::table('organisations', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::dropIfExists('organisations');
    }
}
