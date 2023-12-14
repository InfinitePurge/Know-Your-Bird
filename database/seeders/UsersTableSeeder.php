<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use Faker\Generator as Faker;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Let's assume you have a role with ID 2 as a regular user
        $roleId = 2;

        // Create an admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.lt',
            'password' => bcrypt('123'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => 1,
        ]);

        User::factory()->count(250)->create();
    }
}
