<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use App\Models\Pauksciai;
use App\Models\User;
use Illuminate\Support\Facades\File;

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

        // Directory to store images
        $imageDirectory = public_path('storage/images/birds');

        // Get an array of files in the specified directory
        $files = File::files($imageDirectory);

        // Randomly select one file from the array
        $randomImage = $files[rand(0, count($files) - 1)];

        return [
            'pavadinimas' => $this->faker->word,
            'aprasymas' => $this->faker->paragraph,
            'kilme' => $this->faker->country,
            'image' => 'storage/images/birds/' . $randomImage->getFilename(),
            'created_by' => $createdByUser->id,
            'edited_by' => $editedByUser ? $editedByUser->id : null,
        ];
    }
}
