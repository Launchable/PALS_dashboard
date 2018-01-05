<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/*
 * User Factory
 */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'username'       => $faker->userName,
        'email'          => $faker->unique()->safeEmail,
        'password'       => bcrypt('secret'),
        'api_token'      => str_random(60),
        'avatar'         => 'default.jpg',
        'role'           => $faker->randomElement([
            'registered',
            'manager'
        ]),
        'remember_token' => str_random(10),
        'created_at'     => $faker->dateTimeBetween('-1 WEEK', 'now')
    ];
});

/*
 * Profile Factory
 */
$factory->define(App\UserProfile::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name'  => $faker->lastName(),
        'age'        => $faker->numberBetween(18, 60),
        'gender'     => $faker->randomElement([
            'male',
            'female'
        ])
    ];
});

/*
 * Orders Drink
 */
$factory->define(App\Order::class, function (Faker\Generator $faker) {
    return [
        'user_id'     => $faker->numberBetween(3, 20),
        'drink_id'    => $faker->numberBetween(1, 50),
        //'cover_id'    => $faker->numberBetween(1, 20),
        'price'       => $faker->randomFloat(2, 2, 50),
        'location_id' => $faker->numberBetween(1, 2),
        'is_redeemed' => $faker->numberBetween(0, 1),
        'created_at'  => $faker->dateTimeBetween('-1 month', 'now')
    ];
});

/*
 * Drinks
 */
$factory->define(App\Drink::class, function (Faker\Generator $faker) {
    return [
        'location_id'  => $faker->numberBetween(1, 2),
        'type_id'      => $faker->numberBetween(1, 4),
        'code'         => 'drink-' . $faker->numberBetween(1, 50),
        'title'        => $faker->word,
        'description'  => $faker->paragraph,
        'price'        => $faker->randomFloat(2, 2, 50),
        'is_available' => 1,
        'created_at'   => $faker->dateTimeBetween('-1 month', 'now')
    ];
});

/*
 * User Drinks
 */
$factory->define(App\UserDrink::class, function (Faker\Generator $faker) {
    return [
        'user_id'     => 3,
        'sender_id'   => $faker->numberBetween(4, 20),
        'drink_id'    => $faker->numberBetween(1, 50),
        'price'       => $faker->randomFloat(2, 2, 50),
        'message'     => $faker->paragraph,
        'is_redeemed' => $faker->numberBetween(0, 1)
    ];
});

/*
 * Covers
 */
$factory->define(App\Cover::class, function (Faker\Generator $faker) {
    return [
        'location_id' => $faker->numberBetween(1, 2),
        'code'        => 'cover-s' . $faker->numberBetween(1, 50),
        'title'       => $faker->word,
        'description' => $faker->paragraph,
        'price'       => $faker->randomFloat(2, 2, 50),
        'created_at'  => $faker->dateTimeBetween('-1 month', 'now')
    ];
});

/*
 * Cover Drinks
 */
$factory->define(App\UserCover::class, function (Faker\Generator $faker) {
    return [
        'user_id'     => 3,
        'sender_id'   => $faker->numberBetween(4, 20),
        'cover_id'    => $faker->numberBetween(1, 50),
        'price'       => $faker->randomFloat(2, 2, 50),
        'message'     => $faker->paragraph,
        'is_redeemed' => $faker->numberBetween(0, 1)
    ];
});

/*
 * Events
 */
$factory->define(App\Event::class, function (Faker\Generator $faker) {
    return [
        'location_id' => $faker->numberBetween(1, 2),
        'title'       => $faker->word,
        'description' => $faker->paragraph,
        'date'        => \Carbon\Carbon::now(),
    ];
});
