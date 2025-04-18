<?php

namespace Database\Seeders;

use App\Models\ProductFamily;
use Illuminate\Database\Seeder;

class ProductFamiliesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tableau des familles de produits à créer
        $families = [
            [
                'code' => 'W',
                'name' => 'Solinote',
                'description' => 'Matières premières individuelles pour la parfumerie',
                'active' => true
            ],
            [
                'code' => 'PM',
                'name' => 'Produits du Marché',
                'description' => 'Produits disponibles sur le marché, incluant des informations sur les applications',
                'active' => true
            ],
            [
                'code' => 'D',
                'name' => 'Dame',
                'description' => 'Parfums féminins avec informations sur l\'année de sortie et option unisex',
                'active' => true
            ],
            [
                'code' => 'M',
                'name' => 'Masculin',
                'description' => 'Parfums masculins avec informations sur l\'année de sortie et option unisex',
                'active' => true
            ],
            [
                'code' => 'U',
                'name' => 'Unisex',
                'description' => 'Parfums unisexes avec informations sur l\'année de sortie et le genre dominant',
                'active' => true
            ],
        ];

        // Création des familles de produits
        foreach ($families as $family) {
            // Vérifier si la famille existe déjà (pour éviter les doublons)
            $existingFamily = ProductFamily::where('code', $family['code'])->first();
            
            if (!$existingFamily) {
                ProductFamily::create($family);
                $this->command->info("Famille de produits '{$family['name']}' (code: {$family['code']}) créée avec succès.");
            } else {
                $this->command->info("Famille de produits '{$family['name']}' (code: {$family['code']}) existe déjà.");
            }
        }
    }
}