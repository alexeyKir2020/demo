<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganisationsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organisations_users', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')->onDelete('cascade');
            $table->integer('organisation_id')->unsigned();
            $table->foreign('organisation_id')
                ->references('id')
                ->on('organisations')->onDelete('cascade');
            $table->boolean('is_owner')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organisations_users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::dropIfExists('organisations_users');
    }
}
