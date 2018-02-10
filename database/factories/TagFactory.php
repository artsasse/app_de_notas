<?php

use Faker\Generator as Faker;

$factory->define(App\Tag::class, function (Faker $faker) {
    $users = App\User::all()->toArray();
    return [
        'name' => $faker->word,
        'created_at' => $faker->dateTime($max = 'now'),
        'updated_at' => $faker->dateTime($max = 'now'),
        'user_id' => random_int($users[0]['id'], $users[count($users)-1]['id']),
    ];
});
