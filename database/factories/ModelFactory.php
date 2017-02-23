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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Item::class, function (Faker\Generator $faker) {
    return [
        'user_id'     => factory(\App\User::class)->create()->id,
        'shop_id'     => factory(\App\Shop::class)->create()->id,
        'title'       => $faker->sentence,
        'description' => $faker->text,
        'quantity'    => $faker->randomNumber,
        'amount'      => $faker->randomNumber,
        'symbol'      => '$',
        'images'      => [],
        'extra'       => [],
    ];
});

$factory->define(App\Shop::class, function (Faker\Generator $faker) {
    return [
        'user_id'  => factory(\App\User::class)->create()->id,
        'name'     => $faker->sentence,
        'phone'    => $faker->e164PhoneNumber,
        'email'    => $faker->safeEmail,
        'address'  => $faker->address,
        'contact'  => $faker->name,
        'panorama' => $faker->image,
    ];
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    return [
        'shop_id'	=> factory(\App\Shop::class)->create()->id,
        'name' 		=> $faker->sentence,
    ];
});

$factory->define(App\Marker::class, function (Faker\Generator $faker) {
    return [
        'shop_id'       => factory(\App\Shop::class)->create()->id,
        'markable_id'   => factory(\App\Item::class)->create()->id,
        'markable_type' => \App\Item::class,
        'latitude'      => $faker->latitude,
        'longitude'     => $faker->longitude,
        'latitude_px'   => $faker->randomNumber,
        'longitude_px'  => $faker->randomNumber,
    ];
});

$factory->define(App\Path::class, function (Faker\Generator $faker) {
    return [
        'user_id'   => factory(\App\User::class)->create()->id,
        'name'      => $faker->word,
    ];
});

