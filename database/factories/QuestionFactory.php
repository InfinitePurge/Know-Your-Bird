<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition()
    {
        return [
            'question' => $this->faker->sentence,
            'image' => null, // Add logic to generate images if needed
            'created_by' => 1, // Replace with logic to get user IDs
            'edited_by' => null,
        ];
    }
}
