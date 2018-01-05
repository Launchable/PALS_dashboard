<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = [
            [
                'code'        => 'location-1',
                'name'        => 'My First Laction',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Nulla tincidunt, felis eu auctor hendrerit, 
                ex nunc rutrum libero, ut imperdiet ante lorem ut quam. Phasellus a 
                mattis nulla. Ut a feugiat turpis, id condimentum eros. Sed eget nunc sem. 
                Pellentesque consequat rutrum laoreet. Suspendisse quis leo sit amet velit ullamcorper varius 
                ut sit amet arcu. Mauris nisl est, congue et posuere et, iaculis a urna. Sed dignissim ipsum purus, 
                vel lobortis metus tempor sed. Fusce tempor est efficitur felis gravida dictum. Etiam eleifend at 
                sapien et ornare. Nam et volutpat est. Donec non urna vel justo fringilla elementum. Donec laoreet 
                sem vel magna mollis, in elementum mauris sagittis. Integer lacus dui, pellentesque vel gravida at, 
                pulvinar sollicitudin nulla. Maecenas feugiat neque vel elementum mattis. Morbi vel ex eu lacus 
                rhoncus varius ut sed nunc.',
                'address'     => 'manila',
                'phone'       => '(123) 123-1234',
                'latitude'    => 14.59951240,
                'longitude'   => 120.98421950,
                'image'       => 'default.jpg'
            ],
            [
                'code'        => 'location-2',
                'name'        => 'My Second Laction',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Nulla tincidunt, felis eu auctor hendrerit, 
                ex nunc rutrum libero, ut imperdiet ante lorem ut quam. Phasellus a 
                mattis nulla. Ut a feugiat turpis, id condimentum eros. Sed eget nunc sem. 
                Pellentesque consequat rutrum laoreet. Suspendisse quis leo sit amet velit ullamcorper varius 
                ut sit amet arcu. Mauris nisl est, congue et posuere et, iaculis a urna. Sed dignissim ipsum purus, 
                vel lobortis metus tempor sed. Fusce tempor est efficitur felis gravida dictum. Etiam eleifend at 
                sapien et ornare. Nam et volutpat est. Donec non urna vel justo fringilla elementum. Donec laoreet 
                sem vel magna mollis, in elementum mauris sagittis. Integer lacus dui, pellentesque vel gravida at, 
                pulvinar sollicitudin nulla. Maecenas feugiat neque vel elementum mattis. Morbi vel ex eu lacus 
                rhoncus varius ut sed nunc.',
                'address'     => 'iloilo',
                'phone'       => '(123) 123-1234',
                'latitude'    => 14.59951240,
                'longitude'   => 120.98421950,
                'image'       => 'default.jpg'
            ]
        ];


        foreach ($locations as $location) {
            \App\Location::firstOrCreate($location);
        }

        $locationTypes = [
            [
                'location_id' => 1,
                'type_id'     => 1
            ],
            [
                'location_id' => 2,
                'type_id'     => 2
            ]
        ];

        foreach ($locationTypes as $types) {
            DB::table('location_types')
              ->insert($types);
        }

        /*
         * Location users
         */
        $locationUsers = [
            [
                'location_id' => 1,
                'user_id'     => 2
            ],
            [
                'location_id' => 2,
                'user_id'     => 2
            ],
        ];

        foreach ($locationUsers as $users) {
            DB::table('location_users')
              ->insert($users);
        }

        $locationOperations = [
            [
                'location_id' => 1,
                'week_day'    => 0,
                'opens_at'    => '08:00',
                'closes_at'   => '16:00'
            ],
            [
                'location_id' => 1,
                'week_day'    => 1,
                'opens_at'    => '08:00',
                'closes_at'   => '16:00'
            ],
            [
                'location_id' => 1,
                'week_day'    => 2,
                'opens_at'    => '08:00',
                'closes_at'   => '16:00'
            ],
            [
                'location_id' => 1,
                'week_day'    => 3,
                'opens_at'    => '08:00',
                'closes_at'   => '16:00'
            ],
            [
                'location_id' => 1,
                'week_day'    => 4,
                'opens_at'    => '08:00',
                'closes_at'   => '16:00'
            ],
            [
                'location_id' => 1,
                'week_day'    => 5,
                'opens_at'    => '08:00',
                'closes_at'   => '16:00'
            ],
            [
                'location_id' => 1,
                'week_day'    => 6,
                'opens_at'    => '08:00',
                'closes_at'   => '16:00'
            ],
                #########################
            [
                'location_id' => 2,
                'week_day'    => 0,
                'opens_at'    => '08:00',
                'closes_at'   => '16:00'
            ],
            [
                'location_id' => 2,
                'week_day'    => 1,
                'opens_at'    => '08:00',
                'closes_at'   => '16:00'
            ],
            [
                'location_id' => 2,
                'week_day'    => 2,
                'opens_at'    => '08:00',
                'closes_at'   => '16:00'
            ],
            [
                'location_id' => 2,
                'week_day'    => 3,
                'opens_at'    => '08:00',
                'closes_at'   => '16:00'
            ],
            [
                'location_id' => 1,
                'week_day'    => 4,
                'opens_at'    => '08:00',
                'closes_at'   => '16:00'
            ],
            [
                'location_id' => 2,
                'week_day'    => 5,
                'opens_at'    => '08:00',
                'closes_at'   => '16:00'
            ],
            [
                'location_id' => 2,
                'week_day'    => 6,
                'opens_at'    => '08:00',
                'closes_at'   => '16:00'
            ]
        ];

        foreach ($locationOperations as $operation) {
            DB::table('location_operations')
              ->insert($operation);
        }

    }
}
