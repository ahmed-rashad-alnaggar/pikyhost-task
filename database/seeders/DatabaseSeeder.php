<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed test user.
        User::create([
            'name' => 'test',
            'email' => 'ahmad@example.com',
            'password' => Hash::make('admin'),
        ]);

        $this->call([
            PageSeeder::class,
            PageSectionSeeder::class,
        ]);
    }
}
