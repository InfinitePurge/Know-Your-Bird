<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\Answer;
use App\Models\Question;

class QuizTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create 5-10 quizzes
        Quiz::factory()->count(rand(5, 10))->create()->each(function (Quiz $quiz) {
            // For each quiz, create 10-15 questions
            $questions = Question::factory()->count(rand(10, 15))->create([
                'created_by' => $quiz->created_by,
                'edited_by' => $quiz->edited_by,
            ]);

            // Attach questions to the quiz
            $quiz->questions()->attach($questions);

            // For each question, create correct answer
            $questions->each(function (Question $question) {
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
        });
    }
}
