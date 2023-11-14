<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Answer;
use App\Models\Question;

class AnswerTableSeeder extends Seeder
{
    public function run()
    {
        // For each question, create 1 correct answer and 3 wrong answers
        Question::all()->each(function (Question $question) {
            // Create correct answer
            Answer::factory()->create([
                'QuestionID' => $question->id,
                'isCorrect' => true,
            ]);

            // Create 3 wrong answers
            Answer::factory()->count(3)->create([
                'QuestionID' => $question->id,
                'isCorrect' => false,
            ]);
        });
    }
}
