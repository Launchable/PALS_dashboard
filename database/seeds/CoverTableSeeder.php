<?php

use Illuminate\Database\Seeder;

class CoverTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Cover::class, 50)->create();
        factory(\App\UserCover::class, 20)->create();
    }
}
