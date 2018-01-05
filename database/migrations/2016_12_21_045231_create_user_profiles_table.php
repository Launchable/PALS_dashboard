<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('user_profiles')) {
            Schema::create('user_profiles', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')
                      ->unsigned()
                      ->index();
                $table->foreign('user_id')
                      ->references('id')
                      ->on('users')
                      ->onDelete('cascade');
                $table->string('first_name')
                      ->nullable();
                $table->string('last_name')
                      ->nullable();
                $table->string('phone')
                      ->nullable()
                      ->index();
                $table->tinyInteger('age')
                      ->nullable();
                $table->string('gender', 10)
                      ->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
}
