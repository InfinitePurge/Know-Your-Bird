<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tag;
use App\Models\Prefix;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->word();
        
        while (Tag::where('name', $name)->exists()) {
            $name = $this->faker->unique()->word();
        }

        return [
            'name' => $name,
            'prefix_id' => $this->faker->optional(0.75, null)->randomElement(Prefix::pluck('id')),
        ];
    }
}

