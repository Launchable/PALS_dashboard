<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('location_operations')) {
            Schema::create('location_operations', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('location_id')
                      ->unsigned()
                      ->index();
                $table->foreign('location_id')
                      ->references('id')
                      ->on('locations')
                      ->onDelete('cascade');
                
                $table->tinyInteger('week_day');
                $table->time('opens_at')
                      ->nullable();
                $table->time('closes_at')
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
        Schema::dropIfExists('location_operations');
    }
}
