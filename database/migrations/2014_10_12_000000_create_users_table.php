<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('username');
                $table->string('email')
                      ->unique();
                $table->string('password');
                $table->string('api_token',60)->unique(); //our api token
                $table->string('role')
                      ->default('registered')
                      ->index();
                $table->string('avatar')
                      ->default('default.jpg');
                $table->string('avatar_social')
                      ->nullable();
                $table->dateTime('last_logged_in_at')
                      ->nullable();
                $table->tinyInteger('location_count')
                      ->default(0);
                $table->rememberToken();
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
        Schema::drop('users');
    }
}
