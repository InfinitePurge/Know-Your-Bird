<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionTableSeeder extends Seeder
{
    public function run()
    {
        Question::factory()->count(5)->create();
    }
}
