<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductFamily;
use App\Models\ReferenceData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtenir toutes les familles de produits
        $families = ProductFamily::all();
        
        // Récupérer les données de référence
        $zoneGeos = ReferenceData::where('type', 'zone_geo')->pluck('value')->toArray();
        $famillesOlfactives = ReferenceData::where('type', 'famille_olfactive')->pluck('value')->toArray();
        $notesOlfactives = ReferenceData::where('type', 'description_olfactive')->pluck('value')->toArray();
        $applications = ReferenceData::where('type', 'application')->pluck('value')->toArray();
        
        // Marques fictives
        $marques = [
            'Aromalife', 'Parfumerie Générale', 'Senteurs Élégantes', 'Fragrance Noble', 
            'Éclat de Parfum', 'Essence Pure', 'Art Olfactif', 'Note Parfumée',
            'Parfums de l\'Âme', 'Odeur Subtile', 'Fragrances Exclusives', 'Parfum Signature',
            'Arôme Délicat', 'Scents of Nature', 'Parfums Éternels', 'Délice Olfactif'
        ];
        
        // Pour chaque famille, créer 20 produits
        foreach ($families as $family) {
            $this->command->info("Création de 20 produits de test pour la famille {$family->name} ({$family->code})");
            
            // Déterminer le dernier numéro de type pour cette famille
            $lastType = Product::where('type', 'like', $family->code . '%')
                ->orderByRaw('CAST(SUBSTRING(type, ' . (strlen($family->code) + 1) . ') AS UNSIGNED) DESC')
                ->first();
            
            $nextNumber = 1;
            if ($lastType) {
                $lastNumber = (int)substr($lastType->type, strlen($family->code));
                $nextNumber = $lastNumber + 1;
            }

            // Créer 20 produits pour cette famille
            for ($i = 0; $i < 20; $i++) {
                $typeNumber = str_pad($nextNumber + $i, 6, '0', STR_PAD_LEFT);
                $type = $family->code . $typeNumber;
                
                // Commencer une transaction pour assurer l'intégrité
                DB::beginTransaction();
                
                try {
                    // Données de base communes à toutes les familles
                    $productData = [
                        'type' => $type,
                        'product_family_id' => $family->id,
                        'nom' => "Produit Test {$family->code} " . ($i + 1),
                        'marque' => $marques[array_rand($marques)],
                    ];
                    
                    // Ajouter des attributs spécifiques selon la famille
                    if ($family->code != 'W') {
                        if (in_array($family->code, ['D', 'M', 'U'])) {
                            $productData['date_sortie'] = rand(1990, 2024);
                        }
                        
                        if (in_array($family->code, ['D', 'M'])) {
                            $productData['unisex'] = (bool)rand(0, 1);
                        }
                        
                        if ($family->code == 'U') {
                            $productData['specific_attributes'] = [
                                'genre' => rand(0, 1) ? 'Masculin' : 'Féminin'
                            ];
                        }
                        
                        if ($family->code == 'PM') {
                            $productData['specific_attributes'] = [
                                'application' => $applications[array_rand($applications)]
                            ];
                        }
                    }
                    
                    // Créer le produit
                    $product = Product::create($productData);
                    
                    // Ajouter des relations pour les familles autres que W
                    if ($family->code != 'W') {
                        // Zones géographiques (1-3 zones aléatoires)
                        $numZones = rand(1, 3);
                        $selectedZones = array_rand(array_flip($zoneGeos), $numZones);
                        if (!is_array($selectedZones)) {
                            $selectedZones = [$selectedZones];
                        }
                        
                        foreach ($selectedZones as $zoneValue) {
                            $product->zoneGeos()->create([
                                'zone_geo_value' => $zoneValue
                            ]);
                        }
                        
                        // Familles olfactives (1-2 familles aléatoires)
                        $numFamilles = rand(1, 2);
                        $selectedFamilles = array_rand(array_flip($famillesOlfactives), $numFamilles);
                        if (!is_array($selectedFamilles)) {
                            $selectedFamilles = [$selectedFamilles];
                        }
                        
                        foreach ($selectedFamilles as $familleValue) {
                            $product->olfactiveFamilies()->create([
                                'famille_value' => $familleValue
                            ]);
                        }
                        
                        // Notes olfactives
                        // Tête (1-2 notes)
                        for ($pos = 1; $pos <= rand(1, 2); $pos++) {
                            $product->olfactiveNotes()->create([
                                'position' => 'tete',
                                'order' => $pos,
                                'description_value' => $notesOlfactives[array_rand($notesOlfactives)]
                            ]);
                        }
                        
                        // Cœur (1-2 notes)
                        for ($pos = 1; $pos <= rand(1, 2); $pos++) {
                            $product->olfactiveNotes()->create([
                                'position' => 'coeur',
                                'order' => $pos,
                                'description_value' => $notesOlfactives[array_rand($notesOlfactives)]
                            ]);
                        }
                        
                        // Fond (1-2 notes)
                        for ($pos = 1; $pos <= rand(1, 2); $pos++) {
                            $product->olfactiveNotes()->create([
                                'position' => 'fond',
                                'order' => $pos,
                                'description_value' => $notesOlfactives[array_rand($notesOlfactives)]
                            ]);
                        }
                    }
                    
                    // Valider la transaction
                    DB::commit();
                    
                    $this->command->info("  - Produit {$type} créé avec succès");
                    
                } catch (\Exception $e) {
                    // En cas d'erreur, annuler la transaction
                    DB::rollBack();
                    $this->command->error("  - Erreur lors de la création du produit {$type}: " . $e->getMessage());
                }
            }
        }
        
        $this->command->info("100 produits de test ont été créés (20 par famille)");
    }
}