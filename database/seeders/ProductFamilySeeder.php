<?php

namespace Database\Seeders;

use App\Models\ProductFamily;
use Illuminate\Database\Seeder;

class ProductFamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $families = [
            [
                'code' => 'W',
                'name' => 'Solinote',
                'description' => 'Table des solinotes',
                'active' => true,
            ],
            [
                'code' => 'PM',
                'name' => 'Produits du Marché',
                'description' => 'Table des Produits du Marché',
                'active' => true,
            ],
            [
                'code' => 'D',
                'name' => 'Dame',
                'description' => 'Table des Dames',
                'active' => true,
            ],
            [
                'code' => 'M',
                'name' => 'Masculin',
                'description' => 'Table des Masculins',
                'active' => true,
            ],
            [
                'code' => 'U',
                'name' => 'Unisex',
                'description' => 'Table Unisex',
                'active' => true,
            ],
        ];

        foreach ($families as $family) {
            ProductFamily::firstOrCreate(
                ['code' => $family['code']],
                $family
            );
        }
    }
}