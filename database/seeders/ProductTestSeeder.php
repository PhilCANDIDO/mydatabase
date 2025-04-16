<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductFamily;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // S'assurer que les familles existent
        $this->checkFamilies();
        
        // Désactiver les contraintes de clés étrangères pour accélérer l'insertion
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Distributions des produits par famille
        $counts = [
            'W' => 150,   // 15% Solinote
            'PM' => 250,  // 25% Produits du Marché
            'D' => 250,   // 25% Dame
            'M' => 200,   // 20% Masculin
            'U' => 150    // 15% Unisex
        ];
        
        $this->command->info('Début de la génération de 1000 produits de test');
        
        // Génération des produits pour chaque famille
        foreach ($counts as $familyCode => $count) {
            $this->command->info("Génération de {$count} produits pour la famille {$familyCode}");
            
            $methodName = $this->getFamilyMethodName($familyCode);
            Product::factory()->{$methodName}()->count($count)->create();
            
            $this->command->info("Produits {$familyCode} créés avec succès");
        }
        
        // Réactiver les contraintes de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        $this->command->info('Génération des produits terminée');
    }
    
    /**
     * Vérifier que toutes les familles de produits existent
     */
    private function checkFamilies(): void
    {
        $requiredFamilies = ['W', 'PM', 'D', 'M', 'U'];
        $existingFamilies = ProductFamily::pluck('code')->toArray();
        
        $missingFamilies = array_diff($requiredFamilies, $existingFamilies);
        
        if (!empty($missingFamilies)) {
            $this->command->warn('Certaines familles de produits sont manquantes. Exécutez d\'abord le ProductFamilySeeder.');
            $missingFamiliesStr = implode(', ', $missingFamilies);
            $this->command->warn("Familles manquantes: {$missingFamiliesStr}");
            exit;
        }
    }
    
    /**
     * Obtenir le nom de méthode correspondant à la famille de produits
     */
    private function getFamilyMethodName(string $familyCode): string
    {
        return [
            'W' => 'solinote',
            'PM' => 'productMarket',
            'D' => 'dame',
            'M' => 'masculin',
            'U' => 'unisex',
        ][$familyCode];
    }
}