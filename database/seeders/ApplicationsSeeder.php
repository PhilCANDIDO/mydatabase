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
                'application_name' => 'Fine fragrance',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Cosmétique',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Ambiance',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Détergence',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'EDT/EDP',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Brumes',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Roll on',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Eau de cologne',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Crème solaire',
                'application_desc' => '',
                'application_active' => true,
            ],	
            [
                'application_name' => 'Savon solide',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Gel douche',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Shampooing',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Après shampooing',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Crème/huile/sérum visage',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Crème/huile corps',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Gommage',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Déodorant',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Masque capillaire',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Mousse à raser',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Crème éclaircissante',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Maquillage',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Gel hydroalcoolique',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Crème mains',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Produits pour cheveux',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Talc',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Hairmist',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Gel intime/lubrifiant',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Bougie',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Diffuseur capillaire',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Diffuseur par nébulisation',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Diffuseur voiture',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Spray d’ambiance',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Désodorisant',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Bakhoor',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Lessive',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Assouplissant',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Lave sol',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Lave vitre',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Liquide vaisselle',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Désinfectant',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Savon liquide', 
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Antitranspirant',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Gel WC',
                'application_desc' => '',
                'application_active' => true,
            ],
            [
                'application_name' => 'Javel',
                'application_desc' => '',
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