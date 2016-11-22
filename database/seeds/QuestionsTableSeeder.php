<?php

use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Question::class, 'single-choice', 50)->create()->each(function ($question) {
            $question->systemAnswers()
                ->save(factory(App\Models\SystemAnswer::class, 'true')->make());
            for ($i=0; $i < 3; $i++) { 
                $question->systemAnswers()
                    ->save(factory(App\Models\SystemAnswer::class, 'false')->make());
            }
        });

        factory(App\Models\Question::class, 'text', 50)->create()->each(function ($question) {
            $question->systemAnswers()->save(factory(App\Models\SystemAnswer::class, 'true')->make());
        });

        factory(App\Models\Question::class, 50)->create();
    }
}
