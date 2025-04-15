<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer les utilisateurs de test
        $readerUser = User::where('email', 'Reader@mydatabase.test')->first();
        if (!$readerUser) {
            $readerUser = User::create([
                'name' => 'Reader User',
                'email' => 'Reader@mydatabase.test',
                'password' => Hash::make('azertyui'), // Change
            ]);
        }
        // Assigner le rôle Super à l'admin
        $readerUser->assignRole('Reader');
        $this->command->info('Reader User assigned role: Reader');

        $writerUser = User::where('email', 'Writer@mydatabase.test')->first();
        if (!$writerUser) {
            $writerUser = User::create([
                'name' => 'Writer User',
                'email' => 'Writer@mydatabase.test',
                'password' => Hash::make('azertyui'), // Change
            ]);
        }
        // Assigner le rôle Super à l'admin
        $writerUser->assignRole('Writer');
        $this->command->info('Writer User assigned role: Writer');
    }
}
