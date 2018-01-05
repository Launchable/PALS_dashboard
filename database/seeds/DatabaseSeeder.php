<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(TypesTableSeeder::class);
        $this->call(DrinkTypesTableSeeder::class);
        $this->call(LocationTableSeeder::class);
        $this->call(DrinkTableSeeder::class);
        $this->call(CoverTableSeeder::class);
        $this->call(OrderTableSeeder::class);
        $this->call(EventTableSeeder::class);
    }
}
