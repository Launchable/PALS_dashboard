<?php

use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Order::class, 100)->create();

        // Insert Covers in orders
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            App\Order::create([
                'user_id'     => $faker->numberBetween(3, 20),
                'cover_id'    => $faker->numberBetween(1, 50),
                'price'       => $faker->randomFloat(2, 2, 50),
                'location_id' => $faker->numberBetween(1, 2),
                'is_redeemed' => $faker->numberBetween(0, 1),
                'created_at'  => $faker->dateTimeBetween('-1 month', 'now')
            ]);
        }

        // Create drink orders today
        for ($i = 0; $i < 10; $i++) {
            App\Order::create([
                'user_id'     => $faker->numberBetween(3, 20),
                'drink_id'    => $faker->numberBetween(1, 50),
                'price'       => $faker->randomFloat(2, 2, 50),
                'location_id' => $faker->numberBetween(1, 2),
                'is_redeemed' => $faker->numberBetween(0, 1),
                'created_at'  => $faker->dateTimeBetween('-10 HOUR', 'now')
            ]);
        }

        // Create cover orders today
        for ($i = 0; $i < 7; $i++) {
            App\Order::create([
                'user_id'     => $faker->numberBetween(3, 20),
                'cover_id'    => $faker->numberBetween(1, 50),
                'price'       => $faker->randomFloat(2, 2, 50),
                'location_id' => $faker->numberBetween(1, 2),
                'is_redeemed' => $faker->numberBetween(0, 1),
                'created_at'  => $faker->dateTimeBetween('-12 HOURS', '1 DAY')
            ]);
        }
    }
}
