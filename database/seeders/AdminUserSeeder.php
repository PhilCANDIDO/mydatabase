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
        $admin = User::where('email', 'admin@mydatabase.test')->first();

        if (!$admin) {
            $admin = User::create([  // Assignez le résultat de create() à $admin
                'name' => 'Admin',
                'email' => 'admin@mydatabase.test',
                'password' => Hash::make('azertyui'),
            ]);
            $this->command->info('Admin user created');
        } else {
            $this->command->info('Admin user already exists');
        }

        // Assigner le rôle Super à l'admin
        $admin->assignRole('Super');
        $this->command->info('Admin assigned role: Super');
    }
}
