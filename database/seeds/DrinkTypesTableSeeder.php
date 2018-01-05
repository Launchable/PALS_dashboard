<?php

use Illuminate\Database\Seeder;

class DrinkTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'name' => 'Shots',
                'color' => '#9370DB'
            ],
            [
                'name' => 'Mixed Drinks',
                'color' => '#800080'
            ],
            [
                'name' => 'Beer',
                'color' => '#40E0D0'
            ],
            [
                'name' => 'Liquor',
                'color' => '#E6E6FA'
            ],
        ];

        foreach ($types as $type) {
            \App\DrinkType::firstOrCreate($type);
        }
    }
}
