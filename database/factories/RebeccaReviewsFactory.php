<?php

use Faker\Generator as Faker;

$factory->define(App\RebeccaReview::class, function (Faker $faker) {
    $title = $faker->sentence();

    return [
        'site_id'  => 1,
        'slug'     => str_slug($title),
        'title'    => $title,
        'body'     => $faker->paragraph()
    ];
});
