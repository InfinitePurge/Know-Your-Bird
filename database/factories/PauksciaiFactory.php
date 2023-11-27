<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use App\Models\Pauksciai;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

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
         $imageDirectory = public_path('images/birds');
 
         // Get an array of files in the specified directory
         $files = File::files($imageDirectory);
 
         if (empty($files)) {
             // Handle the scenario where there are no images
             throw new \Exception('No images found in the specified directory.');
         }
 
         $randomImage = collect($files)->random();
 
         return [
             'pavadinimas' => $this->generateUniquePavadinimas(),
             'aprasymas' => $this->faker->paragraph(90, true),
             'kilme' => $this->getRandomCountryName(),
             // if api is not working
            // 'kilme' => $this->faker->country(),
             'image' => 'images/birds/' . $randomImage->getFilename(),
             'created_by' => $createdByUser->id,
             'edited_by' => $editedByUser ? $editedByUser->id : null,
         ];
     }
 
     private function generateUniquePavadinimas(): string
     {
         $prefix = 'bird_';
         $uniqueIdentifier = uniqid();
 
         return $prefix . $uniqueIdentifier;
     }
 
     private function getRandomCountryName(): string
     {
         $countries = $this->fetchAllCountries();
         return $countries[array_rand($countries)];
     }
 
     private function fetchAllCountries(): array
     {
         return Cache::remember('countries', 10800, function () {
             $api_url = 'https://restcountries.com/v3.1/independent?status=true&fields=name';

            $response = Http::get($api_url);
            $countries_data = $response->json();

            return array_map(function ($country) {
                return $country['name']['common'];
            }, $countries_data);
        });
    }
}
