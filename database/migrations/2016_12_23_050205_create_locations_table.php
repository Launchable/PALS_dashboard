<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('locations')) {
            Schema::create('locations', function (Blueprint $table) {
                $table->increments('id');
                /*$table->integer('user_id')
                      ->unsigned()
                      ->index();
                $table->foreign('user_id')
                      ->references('id')
                      ->on('users')
                      ->onDelete('cascade');*/

                $table->string('code')
                      ->nullable()
                      ->index();
                $table->string('name')
                      ->index();
                $table->string('address')
                      ->nullable();
                $table->text('description')
                      ->nullable();
                $table->string('phone')
                      ->nullable();
                $table->decimal('latitude', 11, 8)
                      ->index()
                      ->nullable();
                $table->decimal('longitude', 11, 8)
                      ->index()
                      ->nullable();
                $table->string('image')
                      ->default('default.jpg');
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
        Schema::dropIfExists('locations');
    }
}
