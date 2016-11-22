<?php

use Illuminate\Database\Seeder;

class SystemAnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\SystemAnswer::class, 200)->create();
    }
}
