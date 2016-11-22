<?php

$factory->define(App\Models\SystemAnswer::class, function (Faker\Generator $faker) {

    return [
        'content' => $faker->text(100),
        'is_correct' => rand(0, 1),
        'question_id' => function () {
            return App\Models\Question::where('type', config('question.type.multiple-choice'))
                ->inRandomOrder()
                ->get()
                ->first()
                ->id;
        },
    ];
});

$factory->defineAs(App\Models\SystemAnswer::class, 'true', function ($faker) use ($factory) {

    return [
        'content' => $faker->text(100),
        'is_correct' => config('answer.correct.true'),
    ];
});

$factory->defineAs(App\Models\SystemAnswer::class, 'false', function ($faker) use ($factory) {

    return [
        'content' => $faker->text(100),
        'is_correct' => config('answer.correct.false'),
    ];
});
