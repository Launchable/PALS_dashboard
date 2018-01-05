<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drinks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('location_id')
                  ->unsigned();

            $table->foreign('location_id')
                  ->references('id')
                  ->on('locations')
                  ->onDelete('cascade');
            
            $table->integer('type_id')
                  ->unsigned();
            $table->string('code')
                  ->nullable()
                  ->index();

            $table->string('title');
            $table->text('description')
                  ->nullable();
            $table->decimal('price', 10, 2);
            $table->time('start_time')
                  ->nullable();
            $table->time('end_time')
                  ->nullable();

            $table->decimal('timed_price', 10, 2)
                  ->nullable();
            $table->string('promo_code')
                  ->nullable();
            $table->integer('stocks')
                  ->nullable();
            
            $table->tinyInteger('is_limited')
                  ->default(0);
            $table->tinyInteger('is_available')
                  ->default(1);
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
        Schema::dropIfExists('drinks');
    }
}
