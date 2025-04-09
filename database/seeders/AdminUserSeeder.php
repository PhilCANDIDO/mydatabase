<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@mysdatabase.test')->first();

        if (!$admin) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@mydatabase.test', // Change
                'password' => Hash::make('azerty'), // Change
            ]);
            $this->command->info('Admin user created');
        } else {
            $this->command->info('Admin user already exists');
        }
    }
}
