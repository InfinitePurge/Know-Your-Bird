<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Prefix;
use Database\Factories\PrefixFactory;

class PrefixTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PrefixFactory::new()->create([
            'prefix' => 'Gentis',
        ]);
        PrefixFactory::new()->create([
            'prefix' => 'Rūšis',
        ]);
        PrefixFactory::new()->create([
            'prefix' => 'Porūšis',
        ]);
        PrefixFactory::new()->create([
            'prefix' => 'Šeima',
        ]);
    }
}
