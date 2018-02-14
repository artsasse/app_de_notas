<?php

use Faker\Generator as Faker;

$factory->define(App\NoteTag::class, function (Faker $faker) {
    $notes = App\Note::all()->toArray();
    $tags = App\Tag::all()->toArray();

    return [
      'note_id' => random_int($notes[0]['id'], $notes[count($notes)-1]['id']),
      'tag_id' => random_int($tags[0]['id'], $tags[count($tags)-1]['id']),
      //'created_at' => $faker->dateTime($max = 'now'),
      //'updated_at' => $faker->dateTime($max = 'now'),
    ];
});
