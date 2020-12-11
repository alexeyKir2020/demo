<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_providers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('auth_provider',255);
            $table->string('auth_provider_id',255);
            $table->string('avatar',255)->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('auth_providers', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::dropIfExists('auth_providers');
    }
}
