<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pauksciai;

class PauksciaiTableSeeder extends Seeder
{
    public function run()
    {
        // Use the factory method provided by Laravel
        \App\Models\Pauksciai::factory()->count(20)->create();
    }
}
