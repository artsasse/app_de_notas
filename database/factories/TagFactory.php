<?php

use Faker\Generator as Faker;

$factory->define(App\Tag::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'created_at' => $faker->dateTime($max = 'now'),
        'updated_at' => $faker->dateTime($max = 'now'),
    ];
});
