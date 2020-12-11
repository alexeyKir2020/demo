<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100)->nullable();
            $table->string('area',100)->nullable();
            $table->string('region',100)->nullable();
            $table->float('locationlt')->nullable();
            $table->float('locationln')->nullable();
            $table->string('area_be',100)->nullable();
            $table->string('name_be',100)->nullable();
            $table->string('region_be',100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
