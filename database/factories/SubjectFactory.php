<?php

$factory->define(App\Models\Subject::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->word,
        'duration' => 20 * config('subject.duration.minute'),
        'number_of_question' => config('subject.question.number.default'),
    ];
});
