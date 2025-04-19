<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductFamiliesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $families = [
            [
                'product_family_code' => 'W',
                'product_family_name' => 'Solinote',
                'product_family_desc' => 'Structure simple pour les matières premières individuelles. Identifiées par un code commençant par "W" suivi d\'un numéro séquentiel (6 chiffres).',
                'product_family_active' => true,
            ],
            [
                'product_family_code' => 'PM',
                'product_family_name' => 'Produits du Marché',
                'product_family_desc' => 'Représente les produits disponibles sur le marché. Identifiés par un code commençant par "PM" suivi d\'un numéro séquentiel (6 chiffres).',
                'product_family_active' => true,
            ],
            [
                'product_family_code' => 'D',
                'product_family_name' => 'Dame',
                'product_family_desc' => 'Représente les parfums féminins. Identifiés par un code commençant par "D" suivi d\'un numéro séquentiel (6 chiffres).',
                'product_family_active' => true,
            ],
            [
                'product_family_code' => 'M',
                'product_family_name' => 'Masculin',
                'product_family_desc' => 'Représente les parfums masculins. Identifiés par un code commençant par "M" suivi d\'un numéro séquentiel (6 chiffres).',
                'product_family_active' => true,
            ],
            [
                'product_family_code' => 'U',
                'product_family_name' => 'Unisex',
                'product_family_desc' => 'Représente les parfums unisexes. Identifiés par un code commençant par "U" suivi d\'un numéro séquentiel (6 chiffres).',
                'product_family_active' => true,
            ],
        ];

        foreach ($families as $family) {
            // Vérifier si la famille existe déjà pour éviter les doublons
            $exists = DB::table('product_families')
                ->where('product_family_code', $family['product_family_code'])
                ->exists();
                
            if (!$exists) {
                DB::table('product_families')->insert(array_merge($family, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
                $this->command->info("Famille de produit \"{$family['product_family_name']}\" créée.");
            } else {
                $this->command->info("Famille de produit \"{$family['product_family_name']}\" existe déjà.");
            }
        }
    }
}