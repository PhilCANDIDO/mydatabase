<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OlfactiveFamiliesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $olfactiveFamilies = [
            [
                'olfactive_family_name' => 'Florale',
                'olfactive_family_desc' => 'Famille très répandue, dominée par des notes de fleurs fraîches ou opulentes (rose, jasmin...).',
                'olfactive_family_active' => true,
            ],
            [
                'olfactive_family_name' => 'Florale Orientale',
                'olfactive_family_desc' => 'Mariage de fleurs et de notes chaudes (ambre, épices douces, muscs).',
                'olfactive_family_active' => true,
            ],
            [
                'olfactive_family_name' => 'Orientale',
                'olfactive_family_desc' => 'Notes riches et chaleureuses : ambre, vanille, résines, épices.',
                'olfactive_family_active' => true,
            ],
            [
                'olfactive_family_name' => 'Boisée',
                'olfactive_family_desc' => 'Notes sèches ou chaudes de bois (cèdre, santal, vétiver, patchouli...).',
                'olfactive_family_active' => true,
            ],
            [
                'olfactive_family_name' => 'Boisée Orientale',
                'olfactive_family_desc' => 'Combinaison de bois et de notes ambrées, souvent masculines.',
                'olfactive_family_active' => true,
            ],
            [
                'olfactive_family_name' => 'Fougère',
                'olfactive_family_desc' => 'Classique de la parfumerie masculine : lavande, mousse de chêne, coumarine.',
                'olfactive_family_active' => true,
            ],
            [
                'olfactive_family_name' => 'Hespéridée',
                'olfactive_family_desc' => 'Parfums frais, à base d\'agrumes (bergamote, citron, orange, pamplemousse).',
                'olfactive_family_active' => true,
            ],
            [
                'olfactive_family_name' => 'Chyprée',
                'olfactive_family_desc' => 'Accords de mousse, patchouli, bergamote, souvent sophistiqués.',
                'olfactive_family_active' => true,
            ],
            [
                'olfactive_family_name' => 'Aromatique',
                'olfactive_family_desc' => 'Herbes (romarin, thym), lavande, très utilisés pour les parfums masculins.',
                'olfactive_family_active' => true,
            ],
            [
                'olfactive_family_name' => 'Aquatique',
                'olfactive_family_desc' => 'Notes marines, iodées, ozoniques pour un effet de fraîcheur "eau".',
                'olfactive_family_active' => true,
            ],
            [
                'olfactive_family_name' => 'Verte',
                'olfactive_family_desc' => 'Accord herbacé, croquant, feuilles écrasées, galbanum...',
                'olfactive_family_active' => true,
            ],
            [
                'olfactive_family_name' => 'Fruitée',
                'olfactive_family_desc' => 'Fruits sucrés ou acidulés, souvent exotiques (pêche, pomme, fruits rouges...).',
                'olfactive_family_active' => true,
            ],
            [
                'olfactive_family_name' => 'Gourmande',
                'olfactive_family_desc' => 'Notes sucrées, alimentaires : vanille, caramel, praline, café...',
                'olfactive_family_active' => true,
            ],
            [
                'olfactive_family_name' => 'Cuirée',
                'olfactive_family_desc' => 'Notes animales, fumées, bois brûlés ou tabac.',
                'olfactive_family_active' => true,
            ],
            [
                'olfactive_family_name' => 'Musquée',
                'olfactive_family_desc' => 'Notes douces et sensuelles évoquant la peau propre, muscs blancs modernes.',
                'olfactive_family_active' => true,
            ],
        ];

        foreach ($olfactiveFamilies as $olfactiveFamily) {
            // Vérifier si la famille olfactive existe déjà pour éviter les doublons
            $exists = DB::table('olfactive_families')
                ->where('olfactive_family_name', $olfactiveFamily['olfactive_family_name'])
                ->exists();
                
            if (!$exists) {
                DB::table('olfactive_families')->insert(array_merge($olfactiveFamily, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
                $this->command->info("Famille olfactive \"{$olfactiveFamily['olfactive_family_name']}\" créée.");
            } else {
                $this->command->info("Famille olfactive \"{$olfactiveFamily['olfactive_family_name']}\" existe déjà.");
            }
        }
    }
}