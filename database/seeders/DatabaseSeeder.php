<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $testUser = User::where('email', 'test@example.com')->first();
        if (!$testUser) {
            User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('azerty'), // Change
            ]);
        }

        $this->call([
            AdminUserSeeder::class,
            RolesAndPermissionsSeeder::class,
        ]);
    }
}
