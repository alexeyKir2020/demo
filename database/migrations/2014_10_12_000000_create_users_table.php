<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email',255)->unique();
            $table->string('phone',100)->nullable()->unique();
            $table->string('first_name',255)->nullable();
            $table->string('second_name',255)->nullable();
            $table->string('third_name',255)->nullable();
            $table->string('avatar',255)->nullable();
            $table->boolean('subscribed')->nullable()->default(false);
            $table->timestamp('identity_verified_at')->nullable();
            $table->string('password',100)->nullable();
            $table->tinyInteger('status')->unsigned();
            $table->tinyInteger('previous_status')->unsigned()->nullable();
            $table->json('requested_changes')->nullable();
            $table->rememberToken();
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::dropIfExists('users');
    }
}
