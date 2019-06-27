<?php

use Faker\Generator as Faker;

$factory->define(App\Review::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'title' => $faker->words($nb = 3, $asText = true) ,
        'body' => $faker->paragraph
    ];
});
