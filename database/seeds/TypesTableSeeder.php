<?php

use Illuminate\Database\Seeder;

class TypesTableSeeder extends Seeder
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
                'name' => 'Bar'
            ],
            [
                'name' => 'Night Club'
            ],
            [
                'name' => 'Coffee Shop'
            ]
        ];

        foreach ($types as $type) {
            \App\Type::firstOrCreate($type);
        }
    }
}
