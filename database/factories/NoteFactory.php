<?php

use Faker\Generator as Faker;

$factory->define(App\Note::class, function (Faker $faker) {
    return [
        'noteTitle' => $faker->catchPhrase,
        'noteContent' => $faker->paragraph,
        'created_at' => $faker->dateTime($max = 'now'),
        'updated_at' => $faker->dateTime($max = 'now'),
    ];
});
