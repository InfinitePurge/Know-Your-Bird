<?php

namespace Database\Factories;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Answer;
use App\Models\Question;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory
{
    protected $model = Answer::class;

    public function definition()
    {
        return [
            'QuestionID' => Question::factory(),
            'AnswerText' => $this->faker->sentence,
            'isCorrect' => $this->faker->boolean,
        ];
    }
}
