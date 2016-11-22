<?php

$factory->define(App\Models\Question::class, function (Faker\Generator $faker) {

    return [
        'content' => $faker->text,
        'type' => config('question.type.multiple-choice'),
        'subject_id' => function () {
            return App\Models\Subject::inRandomOrder()
                ->get()
                ->first()
                ->id;
        },
        'user_id' => function () {
            return App\Models\User::inRandomOrder()
                ->get()
                ->first()
                ->id;
        }
    ];
});

$factory->defineAs(App\Models\Question::class, 'single-choice', function ($faker) use ($factory) {

    return [
        'content' => $faker->text,
        'type' => config('question.type.single-choice'),
        'subject_id' => function () {
            return App\Models\Subject::inRandomOrder()->get()->first()->id;
        },
        'user_id' => function () {
            return App\Models\User::inRandomOrder()
                ->get()
                ->first()
                ->id;
        }
    ];
});

$factory->defineAs(App\Models\Question::class, 'text', function ($faker) use ($factory) {

    return [
        'content' => $faker->text,
        'type' => config('question.type.text'),
        'subject_id' => function () {
            return App\Models\Subject::inRandomOrder()->get()->first()->id;
        },
        'user_id' => function () {
            return App\Models\User::inRandomOrder()
                ->get()
                ->first()
                ->id;
        }
    ];
});
