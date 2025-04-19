<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $applications = [
            [
                'application_name' => 'Eau de parfums',
                'application_desc' => 'Applications pour les eaux de parfums.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Cosmétiques',
                'application_desc' => 'Applications pour les produits cosmétiques.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Shampoing',
                'application_desc' => 'Applications pour les shampoings.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Hygiène',
                'application_desc' => 'Applications pour les produits d\'hygiène.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Bougie',
                'application_desc' => 'Applications pour les bougies parfumées.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Ambiance',
                'application_desc' => 'Applications pour les parfums d\'ambiance.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Détergence',
                'application_desc' => 'Applications pour les produits de détergence parfumés.',
                'application_active' => true,
            ],
        ];

        foreach ($applications as $application) {
            // Vérifier si l'application existe déjà pour éviter les doublons
            $exists = DB::table('applications')
                ->where('application_name', $application['application_name'])
                ->exists();
                
            if (!$exists) {
                DB::table('applications')->insert(array_merge($application, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
                $this->command->info("Application \"{$application['application_name']}\" créée.");
            } else {
                $this->command->info("Application \"{$application['application_name']}\" existe déjà.");
            }
        }
    }
}