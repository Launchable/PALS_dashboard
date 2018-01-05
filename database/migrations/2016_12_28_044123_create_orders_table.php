<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')
                  ->unsigned()
                  ->index();
            
            $table->integer('location_id')
                  ->unsigned()
                  ->index();

            $table->integer('drink_id')
                  ->unsigned()
                  ->nullable();
            $table->integer('cover_id')
                  ->unsigned()
                  ->nullable();
            $table->decimal('price', 10, 2)
                  ->index();

            $table->boolean('is_redeemed')
                  ->default(0)
                  ->index();
            
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
        Schema::dropIfExists('orders');
    }
}
