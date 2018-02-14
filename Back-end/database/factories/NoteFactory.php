<?php

use Faker\Generator as Faker;

$factory->define(App\Note::class, function (Faker $faker) {
    $users = App\User::all()->toArray();
    return [
        'noteTitle' => $faker->catchPhrase,
        'noteContent' => $faker->paragraph,
        'created_at' => $faker->dateTime($max = 'now'),
        'updated_at' => $faker->dateTime($max = 'now'),
        'user_id' => random_int($users[0]['id'], $users[count($users)-1]['id']),
    ];
});
