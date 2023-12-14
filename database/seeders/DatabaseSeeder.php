<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\SeedManager;
use Database\Factories\AnswerFactory;
use Database\Factories\QuestionFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UsersTableSeeder::class,
            PauksciaiTableSeeder::class,
            QuestionTableSeeder::class,
            AnswerTableSeeder::class,
            PrefixTableSeeder::class,
            TagTableSeeder::class,
            // UserAnswersTableSeeder::class,
        ]);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
