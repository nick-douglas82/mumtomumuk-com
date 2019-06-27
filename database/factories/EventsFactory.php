<?php

use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
    return [
        'title' => $faker->words($nb = 3, $asText = true),
        'event_at' => $faker->date('Y-m-d H:i:s', 'now')
    ];
});
