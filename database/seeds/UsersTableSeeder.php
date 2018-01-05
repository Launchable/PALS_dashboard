<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'username'       => 'administrator',
                'email'          => 'admin@pals.com',
                'password'       => bcrypt('123456'),
                'api_token'      => str_random(60),
                'avatar'         => 'default.jpg',
                'role'           => 'administrator',
                'remember_token' => str_random(10),
                'first_name'     => 'Administrator',
                'last_name'      => 'Pals',
                'age'            => 30,
                'gender'         => 'male'
            ],
            [
                'username'       => 'manager',
                'email'          => 'manager@pals.com',
                'password'       => bcrypt('123456'),
                'api_token'      => str_random(60),
                'avatar'         => 'default.jpg',
                'role'           => 'manager',
                'remember_token' => str_random(10),
                'first_name'     => 'Manager',
                'last_name'      => 'Pals',
                'age'            => 30,
                'gender'         => 'male'
            ],
            [
                'username'       => 'registered',
                'email'          => 'registered@pals.com',
                'password'       => bcrypt('123456'),
                'api_token'      => str_random(60),
                'avatar'         => 'default.jpg',
                'role'           => 'registered',
                'remember_token' => str_random(10),
                'first_name'     => 'Registered',
                'last_name'      => 'Pals',
                'age'            => 30,
                'gender'         => 'female'
            ],
            [
                'username'       => 'registered1',
                'email'          => 'registered1@pals.com',
                'password'       => bcrypt('123456'),
                'api_token'      => str_random(60),
                'avatar'         => 'default.jpg',
                'role'           => 'registered',
                'remember_token' => str_random(10),
                'first_name'     => 'Registered One',
                'last_name'      => 'Pals',
                'age'            => 30,
                'gender'         => 'female'
            ]
        ];

        foreach ($users as $user) {
            // Insert Manager Record
            $userData = App\User::create([
                'username'       => $user['username'],
                'email'          => $user['email'],
                'password'       => $user['password'],
                'api_token'      => str_random(60),
                'avatar'         => $user['avatar'],
                'role'           => $user['role'],
                'remember_token' => $user['remember_token'],
            ]);

            $userData->profile()
                     ->create([
                         'first_name' => $user['first_name'],
                         'last_name'  => $user['last_name'],
                         'age'        => $user['age'],
                         'gender'     => $user['gender']
                     ]);
        }


        // Add additional fake users
        factory(App\User::class, 20)
            ->create()
            ->each(function ($u) {
                $u->profile()
                  ->save(factory(App\UserProfile::class)->make());
            });

    }
}
