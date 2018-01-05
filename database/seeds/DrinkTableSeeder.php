<?php

use Illuminate\Database\Seeder;

class DrinkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Drink::class, 50)->create();
        factory(\App\UserDrink::class, 20)->create();
    }
}
