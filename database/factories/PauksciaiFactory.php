<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use App\Models\Pauksciai;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pauksciai>
 */

class PauksciaiFactory extends Factory
{
    protected $model = Pauksciai::class;

    public function definition(): array
    {
        $createdByUser = User::inRandomOrder()->first();
        $editedByUser = $this->faker->boolean(30) ? User::inRandomOrder()->first() : null;

        return [
            'pavadinimas' => $this->faker->word,
            'aprasymas' => $this->faker->paragraph,
            'kilme' => $this->faker->country,
            'image' => $this->faker->imageUrl(),
            'created_by' => $createdByUser->id,
            'edited_by' => $editedByUser ? $editedByUser->id : null,
        ];
    }
}
