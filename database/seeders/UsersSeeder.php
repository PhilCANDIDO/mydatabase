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
        // Créer l'utilisateurs Reader@mydatabase.test
        $readerUser = User::where('email', 'Reader@mydatabase.test')->first();
        if (!$readerUser) {
            $readerUser = User::create([
                'name' => 'Reader User',
                'email' => 'Reader@mydatabase.test',
                'password' => Hash::make('azertyui'), // Change
            ]);
        }
  
        $readerUser->assignRole('Reader');
        $this->command->info('Reader User assigned role: Reader');

        // Créer l'utilisateurs Writer@mydatabase.test
        $writerUser = User::where('email', 'Writer@mydatabase.test')->first();
        if (!$writerUser) {
            $writerUser = User::create([
                'name' => 'Writer User',
                'email' => 'Writer@mydatabase.test',
                'password' => Hash::make('azertyui'), // Change
            ]);
        }

        $writerUser->assignRole('Writer');
        $this->command->info('Writer User assigned role: Writer');

        // Créer l'utilisateurs Superviser@mydatabase.test
        $SuperviserUser = User::where('email', 'Superviser@mydatabase.test')->first();
        if (!$SuperviserUser) {
            $SuperviserUser = User::create([
                'name' => 'Superviser User',
                'email' => 'Superviser@mydatabase.test',
                'password' => Hash::make('azertyui'), // Change
            ]);
        }

        $SuperviserUser->assignRole('Superviser');
        $this->command->info('Superviser User assigned role: Superviser');
    }
}
