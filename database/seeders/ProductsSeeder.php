<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductFamily;
use App\Models\ZoneGeo;
use App\Models\OlfactiveFamily;
use App\Models\OlfactiveNote;
use App\Models\Application;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        // Récupérer les données de référence
        $families = ProductFamily::all();
        $applications = Application::all();
        $zoneGeos = ZoneGeo::all();
        $olfactiveFamilies = OlfactiveFamily::all();
        $olfactiveNotes = OlfactiveNote::all();
        
        // Tableau de base de données pour l'inspiration
        $baseProducts = [
            [
                'name' => 'Chanel No. 5',
                'marque' => 'Chanel',
                'annee_sortie' => 1921,
                'unisex' => false,
                'genre' => 'F',
                'olfactive_family' => 'Florale',
                'notes' => [
                    'head' => ['Aldéhydes', 'Bergamote'],
                    'heart' => ['Jasmin', 'Rose'],
                    'base' => ['Santal', 'Vanille']
                ],
                'zones' => ['Europe', 'Amérique du Nord', 'Asie du Nord']
            ],
            [
                'name' => 'Sauvage',
                'marque' => 'Dior',
                'annee_sortie' => 2015,
                'unisex' => false,
                'genre' => 'M',
                'olfactive_family' => 'Aromatique',
                'notes' => [
                    'head' => ['Bergamote', 'Poivre'],
                    'heart' => ['Lavande', 'Patchouli'],
                    'base' => ['Ambre', 'Cèdre']
                ],
                'zones' => ['Europe', 'Moyen-Orient', 'Amérique du Nord']
            ],
            [
                'name' => 'Light Blue',
                'marque' => 'Dolce & Gabbana',
                'annee_sortie' => 2001,
                'unisex' => false,
                'genre' => 'F',
                'olfactive_family' => 'Fruitée',
                'notes' => [
                    'head' => ['Citron', 'Pomme'],
                    'heart' => ['Jasmin', 'Muguet'],
                    'base' => ['Cèdre', 'Musc blanc']
                ],
                'zones' => ['Europe', 'Amérique du Nord', 'Pacifique']
            ],
            [
                'name' => 'Acqua di Gio',
                'marque' => 'Giorgio Armani',
                'annee_sortie' => 1996,
                'unisex' => false,
                'genre' => 'M',
                'olfactive_family' => 'Aquatique',
                'notes' => [
                    'head' => ['Bergamote', 'Mandarine'],
                    'heart' => ['Jasmin', 'Accord aquatique'],
                    'base' => ['Patchouli', 'Musc blanc']
                ],
                'zones' => ['Europe', 'Amérique du Nord', 'Asie du Sud']
            ],
            [
                'name' => 'Black Opium',
                'marque' => 'Yves Saint Laurent',
                'annee_sortie' => 2014,
                'unisex' => false,
                'genre' => 'F',
                'olfactive_family' => 'Orientale',
                'notes' => [
                    'head' => ['Poivre rose', 'Poire'],
                    'heart' => ['Fleur d\'oranger', 'Jasmin'],
                    'base' => ['Vanille', 'Café']
                ],
                'zones' => ['Europe', 'Moyen-Orient', 'Asie du Nord']
            ],
            [
                'name' => 'Bleu de Chanel',
                'marque' => 'Chanel',
                'annee_sortie' => 2010,
                'unisex' => true,
                'genre' => 'M',
                'olfactive_family' => 'Boisée',
                'notes' => [
                    'head' => ['Citron', 'Menthe'],
                    'heart' => ['Gingembre', 'Jasmin'],
                    'base' => ['Bois de santal', 'Cèdre']
                ],
                'zones' => ['Europe', 'Amérique du Nord', 'Asie du Nord']
            ],
            [
                'name' => 'La Vie Est Belle',
                'marque' => 'Lancôme',
                'annee_sortie' => 2012,
                'unisex' => false,
                'genre' => 'F',
                'olfactive_family' => 'Gourmande',
                'notes' => [
                    'head' => ['Cassis', 'Poire'],
                    'heart' => ['Iris', 'Jasmin'],
                    'base' => ['Vanille', 'Praline']
                ],
                'zones' => ['Europe', 'Amérique du Nord', 'Amérique Latine']
            ],
            [
                'name' => 'Aventus',
                'marque' => 'Creed',
                'annee_sortie' => 2010,
                'unisex' => true,
                'genre' => 'M',
                'olfactive_family' => 'Fruitée',
                'notes' => [
                    'head' => ['Bergamote', 'Pomme'],
                    'heart' => ['Jasmin', 'Rose'],
                    'base' => ['Musc blanc', 'Mousse de chêne']
                ],
                'zones' => ['Europe', 'Amérique du Nord', 'Moyen-Orient']
            ],
            [
                'name' => 'Flowerbomb',
                'marque' => 'Viktor & Rolf',
                'annee_sortie' => 2005,
                'unisex' => false,
                'genre' => 'F',
                'olfactive_family' => 'Florale Orientale',
                'notes' => [
                    'head' => ['Bergamote', 'Thé'],
                    'heart' => ['Jasmin', 'Rose'],
                    'base' => ['Patchouli', 'Vanille']
                ],
                'zones' => ['Europe', 'Amérique du Nord', 'Pacifique']
            ],
            [
                'name' => 'Terre d\'Hermès',
                'marque' => 'Hermès',
                'annee_sortie' => 2006,
                'unisex' => false,
                'genre' => 'M',
                'olfactive_family' => 'Boisée',
                'notes' => [
                    'head' => ['Orange', 'Pamplemousse'],
                    'heart' => ['Poivre', 'Géranium'],
                    'base' => ['Vétiver', 'Benjoin']
                ],
                'zones' => ['Europe', 'Moyen-Orient', 'Asie du Nord']
            ]
        ];
        
        // Liste des marques supplémentaires
        $additionalBrands = [
            'Guerlain', 'Tom Ford', 'Jo Malone', 'Byredo', 'Maison Francis Kurkdjian',
            'Serge Lutens', 'Diptyque', 'Comme des Garçons', 'Le Labo', 'Penhaligon\'s',
            'Frédéric Malle', 'Juliette Has A Gun', 'Atelier Cologne', 'Acqua di Parma', 'Ex Nihilo'
        ];
        
        // Pour chaque famille de produits
        foreach ($families as $family) {
            $this->command->info("Création des produits pour la famille: " . $family->product_family_name);
            
            // Obtenir le préfixe pour cette famille
            $prefix = $family->product_family_code;
            
            // Déterminer le dernier ID utilisé pour cette famille
            $lastProduct = Product::where('product_type', 'like', $prefix . '%')
                                  ->orderBy('product_type', 'desc')
                                  ->first();
            
            $lastId = 0;
            if ($lastProduct) {
                $lastId = (int)substr($lastProduct->product_type, strlen($prefix));
            }
            
            // Créer 25 produits pour cette famille
            for ($i = 1; $i <= 25; $i++) {
                $lastId++;
                $typeId = $prefix . str_pad($lastId, 6, '0', STR_PAD_LEFT);
                
                // Sélectionner un produit de base aléatoire comme modèle
                $baseProduct = $faker->randomElement($baseProducts);
                
                // Variations basées sur la famille
                switch ($family->product_family_code) {
                    case 'W': // Solinote - structure simple
                        $product = [
                            'product_type' => $typeId,
                            'product_family_id' => $family->id,
                            'product_name' => $faker->randomElement(['Essence de ', 'Extrait de ', 'Note de ', 'Absolu de ']) . 
                                            $olfactiveNotes->random()->olfactive_note_name,
                            'product_marque' => $faker->randomElement(
                                array_merge(
                                    array_column($baseProducts, 'marque'), 
                                    $additionalBrands
                                )
                            ),
                            'product_avatar' => null,
                        ];
                        break;
                        
                    case 'PM': // Produits du Marché
                        $product = [
                            'product_type' => $typeId,
                            'product_family_id' => $family->id,
                            'product_name' => $faker->randomElement([
                                $baseProduct['name'] . ' ' . $faker->word,
                                $baseProduct['name'] . ' ' . $faker->randomElement(['Intense', 'Light', 'Fresh', 'Noir', 'Bleu', 'Rouge']),
                                $faker->word . ' ' . $baseProduct['name'],
                            ]),
                            'product_marque' => $faker->randomElement(
                                array_merge(
                                    array_column($baseProducts, 'marque'), 
                                    $additionalBrands
                                )
                            ),
                            'product_avatar' => null,
                            'application_id' => $applications->random()->id,
                        ];
                        break;
                        
                    case 'D': // Dame
                        $product = [
                            'product_type' => $typeId,
                            'product_family_id' => $family->id,
                            'product_name' => $faker->randomElement([
                                $faker->firstName('female') . ' ' . $faker->randomElement(['Amour', 'Divine', 'Élixir', 'Parfum', 'Soir', 'Rose']),
                                $faker->randomElement(['Lady ', 'Princesse ', 'Madame ', 'Miss ', 'Femme ']) . $faker->word,
                                $baseProduct['name'] . ' ' . $faker->randomElement(['Pour Elle', 'Rose', 'Fleur', 'Éclat', 'Passion']),
                            ]),
                            'product_marque' => $faker->randomElement(
                                array_merge(
                                    array_column($baseProducts, 'marque'), 
                                    $additionalBrands
                                )
                            ),
                            'product_annee_sortie' => $faker->numberBetween(1990, 2024),
                            'product_unisex' => $faker->boolean(15), // 15% de chance d'être unisex
                            'product_avatar' => null,
                        ];
                        break;
                        
                    case 'M': // Masculin
                        $product = [
                            'product_type' => $typeId,
                            'product_family_id' => $family->id,
                            'product_name' => $faker->randomElement([
                                $faker->firstName('male') . ' ' . $faker->randomElement(['Intense', 'Sport', 'Extrême', 'Black', 'Blue', 'Royal']),
                                $faker->randomElement(['Monsieur ', 'Lord ', 'King ', 'Sir ', 'Homme ']) . $faker->word,
                                $baseProduct['name'] . ' ' . $faker->randomElement(['Pour Homme', 'Black', 'Sport', 'Extreme', 'Classic']),
                            ]),
                            'product_marque' => $faker->randomElement(
                                array_merge(
                                    array_column($baseProducts, 'marque'), 
                                    $additionalBrands
                                )
                            ),
                            'product_annee_sortie' => $faker->numberBetween(1990, 2024),
                            'product_unisex' => $faker->boolean(15), // 15% de chance d'être unisex
                            'product_avatar' => null,
                        ];
                        break;
                        
                    case 'U': // Unisex
                        $product = [
                            'product_type' => $typeId,
                            'product_family_id' => $family->id,
                            'product_name' => $faker->randomElement([
                                $faker->randomElement(['Unity ', 'Equal ', 'Both ', 'Unique ', 'Universal ']) . $faker->word,
                                $baseProduct['name'] . ' ' . $faker->randomElement(['Unisex', 'Everyone', 'Original', 'Pure', 'Essence']),
                                $faker->word . ' ' . $faker->randomElement(['One', 'U', 'Duo', 'Together', 'Balance']),
                            ]),
                            'product_marque' => $faker->randomElement(
                                array_merge(
                                    array_column($baseProducts, 'marque'), 
                                    $additionalBrands
                                )
                            ),
                            'product_annee_sortie' => $faker->numberBetween(1990, 2024),
                            'product_genre' => $faker->randomElement(['M', 'F']),
                            'product_avatar' => null,
                        ];
                        break;
                }
                
                // Création du produit
                $newProduct = Product::create($product);
                
                // Les associations ne s'appliquent pas aux produits Solinote (W)
                if ($family->product_family_code !== 'W') {
                    // Associations avec les zones géographiques (2-5 zones aléatoires)
                    $selectedZones = $zoneGeos->random($faker->numberBetween(2, 5));
                    foreach ($selectedZones as $zone) {
                        $newProduct->zoneGeos()->attach($zone->id);
                    }
                    
                    // Associations avec les familles olfactives (1-3 familles aléatoires)
                    $selectedFamilies = $olfactiveFamilies->random($faker->numberBetween(1, 3));
                    foreach ($selectedFamilies as $olfactiveFamily) {
                        $newProduct->olfactiveFamilies()->attach($olfactiveFamily->id);
                    }
                    
                    // Associations avec les notes olfactives
                    // 2-3 notes de tête
                    $headNotes = $olfactiveNotes->random($faker->numberBetween(2, 3));
                    foreach ($headNotes as $index => $note) {
                        $newProduct->olfactiveNotes()->attach($note->id, [
                            'olfactive_note_position' => 'head',
                            'olfactive_note_order' => $index + 1,
                        ]);
                    }
                    
                    // 2-3 notes de cœur
                    $heartNotes = $olfactiveNotes->random($faker->numberBetween(2, 3));
                    foreach ($heartNotes as $index => $note) {
                        $newProduct->olfactiveNotes()->attach($note->id, [
                            'olfactive_note_position' => 'heart',
                            'olfactive_note_order' => $index + 1,
                        ]);
                    }
                    
                    // 2-3 notes de fond
                    $baseNotes = $olfactiveNotes->random($faker->numberBetween(2, 3));
                    foreach ($baseNotes as $index => $note) {
                        $newProduct->olfactiveNotes()->attach($note->id, [
                            'olfactive_note_position' => 'base',
                            'olfactive_note_order' => $index + 1,
                        ]);
                    }
                }
                
                $this->command->info("  Produit créé: {$product['product_type']} - {$product['product_name']}");
            }
        }
        
        $this->command->info("Création des produits terminée avec succès!");
    }
}