<?php

use Faker\Generator as Faker;

$factory->define(App\Place::class, function (Faker $faker) {
    $title = $faker->sentence;
    $latitude = $faker->latitude($min  = 51.7543835, $max = 51.7712839);
    $longitude = $faker->longitude($min = -0.4452365, $max = -1.2578505);

    return [
        'slug'         => str_slug($title),
        'title'        => $title,
        'body'         => $faker->paragraph,
        'town'         => $faker->city,
        'address'      => $faker->address,
        'coordinates'  => DB::raw("(GeomFromText('POINT(" . $latitude . " " . $longitude . ")'))"),
        'longitude'    => $longitude,
        'latitude'     => $latitude,
        'phone'        => $faker->phoneNumber,
        'website'      => $faker->url
    ];
});
