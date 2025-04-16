<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductFamily;
use App\Models\ProductOlfactiveFamily;
use App\Models\ProductOlfactiveNote;
use App\Models\ProductZoneGeo;
use App\Models\ReferenceData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Désactiver les contraintes de clés étrangères pour accélérer l'insertion
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // S'assurer que les familles et données de référence existent
        $this->seedReferenceDataIfNeeded();
        $this->seedProductFamiliesIfNeeded();
        
        // Nombre de produits à générer par famille
        $countByFamily = [
            'W' => 50,  // Solinote
            'PM' => 100, // Produits du Marché
            'D' => 100,  // Dame
            'M' => 100,  // Masculin
            'U' => 50,   // Unisex
        ];
        
        $this->command->info('Génération des produits de test...');
        
        // Récupérer toutes les familles de produits
        $families = ProductFamily::all()->keyBy('code');
        
        // Récupérer les données de référence
        $zoneGeos = ReferenceData::where('type', 'zone_geo')->where('active', true)->get();
        $olfactiveFamilies = ReferenceData::where('type', 'famille_olfactive')->where('active', true)->get();
        $olfactiveNotes = ReferenceData::where('type', 'description_olfactive')->where('active', true)->get();
        $applications = ReferenceData::where('type', 'application')->where('active', true)->get();
        
        // Vérifier que les données de référence existent
        if ($zoneGeos->isEmpty() || $olfactiveFamilies->isEmpty() || $olfactiveNotes->isEmpty() || $applications->isEmpty()) {
            $this->command->error("Données de référence manquantes. Assurez-vous que les données de référence sont correctement chargées.");
            // Forcer la création des données de référence
            $this->seedReferenceDataIfNeeded(true);
            
            // Recharger les données après la création
            $zoneGeos = ReferenceData::where('type', 'zone_geo')->where('active', true)->get();
            $olfactiveFamilies = ReferenceData::where('type', 'famille_olfactive')->where('active', true)->get();
            $olfactiveNotes = ReferenceData::where('type', 'description_olfactive')->where('active', true)->get();
            $applications = ReferenceData::where('type', 'application')->where('active', true)->get();
        }
        
        // Générer les produits pour chaque famille
        foreach ($countByFamily as $familyCode => $count) {
            $family = $families[$familyCode];
            
            $this->command->info("Génération de {$count} produits pour la famille {$familyCode}");
            
            for ($i = 1; $i <= $count; $i++) {
                // Générer un type unique pour le produit (code famille + 6 chiffres)
                $type = $familyCode . str_pad($i, 6, '0', STR_PAD_LEFT);
                
                // Données communes à toutes les familles
                $productData = [
                    'type' => $type,
                    'product_family_id' => $family->id,
                    'nom' => $this->generateProductName($familyCode),
                    'marque' => $this->generateBrandName(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
                // Données spécifiques selon la famille
                switch ($familyCode) {
                    case 'PM':
                        $productData['specific_attributes'] = json_encode([
                            'application' => $applications->random()->value,
                        ]);
                        break;
                        
                    case 'D':
                    case 'M':
                        $productData['date_sortie'] = rand(1990, date('Y'));
                        $productData['unisex'] = rand(0, 100) < 20; // 20% de chance d'être unisex
                        break;
                        
                    case 'U':
                        $productData['date_sortie'] = rand(1990, date('Y'));
                        $productData['specific_attributes'] = json_encode([
                            'genre' => rand(0, 1) ? 'Masculin' : 'Féminin',
                        ]);
                        break;
                }
                
                // Créer le produit
                $productId = DB::table('products')->insertGetId($productData);
                
                // Ne pas ajouter de relations pour les solinotes (W)
                if ($familyCode === 'W') {
                    continue;
                }
                
                // Ajouter des zones géographiques (1 à 3 aléatoirement)
                $zoneCount = min(rand(1, 3), $zoneGeos->count());
                $selectedZones = $zoneGeos->random($zoneCount);
                
                foreach ($selectedZones as $zone) {
                    DB::table('product_zone_geos')->insert([
                        'product_id' => $productId,
                        'zone_geo_value' => $zone->value,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                
                // Ajouter des familles olfactives (1 à 2 aléatoirement)
                $familyCount = min(rand(1, 2), $olfactiveFamilies->count());
                $selectedFamilies = $olfactiveFamilies->random($familyCount);
                
                foreach ($selectedFamilies as $olfactiveFamily) {
                    DB::table('product_olfactive_families')->insert([
                        'product_id' => $productId,
                        'famille_value' => $olfactiveFamily->value,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                
                // Ajouter des notes olfactives
                $this->addOlfactiveNotes($productId, $olfactiveNotes, 'tete', 2);
                $this->addOlfactiveNotes($productId, $olfactiveNotes, 'coeur', 2);
                $this->addOlfactiveNotes($productId, $olfactiveNotes, 'fond', 2);
            }
            
            $this->command->info("Produits {$familyCode} créés avec succès");
        }
        
        // Réactiver les contraintes de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        $this->command->info('Génération des produits terminée');
    }
    
    /**
     * Ajouter des notes olfactives à un produit
     */
    private function addOlfactiveNotes(int $productId, $olfactiveNotes, string $position, int $maxNotes): void
    {
        // S'assurer que nous avons des notes olfactives
        if ($olfactiveNotes->isEmpty()) {
            return;
        }
        
        // Déterminer aléatoirement combien de notes ajouter (de 0 à maxNotes)
        $noteCount = min(rand(0, $maxNotes), $olfactiveNotes->count());
        
        if ($noteCount === 0) {
            return;
        }
        
        $selectedNotes = $olfactiveNotes->random($noteCount);
        $selectedNotes = is_array($selectedNotes) ? collect($selectedNotes) : $selectedNotes;
        
        for ($i = 0; $i < $noteCount; $i++) {
            $note = is_array($selectedNotes) || $selectedNotes instanceof \Illuminate\Support\Collection 
                  ? $selectedNotes[$i] 
                  : $selectedNotes;
            
            DB::table('product_olfactive_notes')->insert([
                'product_id' => $productId,
                'position' => $position,
                'order' => $i + 1,
                'description_value' => $note->value,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
    
    /**
     * Générer un nom de produit fictif selon la famille
     */
    private function generateProductName(string $familyCode): string
    {
        $adjectives = [
            'Intense', 'Elegant', 'Délicat', 'Frais', 'Sensuel', 'Mystérieux', 'Moderne', 
            'Classique', 'Luxueux', 'Léger', 'Audacieux', 'Raffiné', 'Exotique', 'Oriental',
            'Floral', 'Fruité', 'Boisé', 'Épicé', 'Ambré', 'Aquatique', 'Vert', 'Citronné'
        ];
        
        $nouns = [
            'Essence', 'Parfum', 'Aura', 'Elixir', 'Secret', 'Splendeur', 'Attraction', 
            'Charme', 'Séduction', 'Passion', 'Prestige', 'Éclat', 'Mystère', 'Rêve',
            'Désir', 'Allure', 'Pouvoir', 'Fascination', 'Émotion', 'Sensation'
        ];
        
        switch ($familyCode) {
            case 'W':
                // Pour les solinotes, utiliser des noms de matières premières
                $solinotes = [
                    'Rose', 'Jasmin', 'Tubéreuse', 'Lavande', 'Bergamote', 'Citron', 'Orange', 
                    'Patchouli', 'Vanille', 'Santal', 'Vétiver', 'Musc', 'Ambre', 'Cèdre',
                    'Iris', 'Ylang-Ylang', 'Néroli', 'Bois de Oud', 'Tonka', 'Cardamome',
                    'Cannelle', 'Gingembre', 'Mandarine', 'Fraise', 'Cassis', 'Poire'
                ];
                return $solinotes[array_rand($solinotes)];
                
            case 'PM':
                // Pour les produits du marché, utiliser une combinaison nom + adjectif
                return $nouns[array_rand($nouns)] . ' ' . $adjectives[array_rand($adjectives)];
                
            case 'D':
                // Pour les parfums femme, utiliser des noms féminins
                $femaleNames = [
                    'La Belle', 'Divine', 'Étoile', 'Fleur', 'Femme', 'Diva', 'Princesse', 
                    'Rose', 'Duchesse', 'Miss', 'Mademoiselle', 'Madame', 'Perle', 'Lune'
                ];
                return $femaleNames[array_rand($femaleNames)] . ' ' . $adjectives[array_rand($adjectives)];
                
            case 'M':
                // Pour les parfums homme, utiliser des noms masculins
                $maleNames = [
                    'Le Gentleman', 'Homme', 'King', 'Lord', 'Duke', 'Mr', 'Monsieur', 'Prince', 
                    'Hero', 'Legend', 'Knight', 'Explorer', 'Conquistador', 'Aventurier'
                ];
                return $maleNames[array_rand($maleNames)] . ' ' . $adjectives[array_rand($adjectives)];
                
            case 'U':
                // Pour les parfums unisexes, utiliser des noms neutres
                $unisexNames = [
                    'Persona', 'Liberté', 'Équilibre', 'Harmonie', 'Fusion', 'Unity', 'Duality', 
                    'Ambiguïté', 'Versatile', 'Both', 'Énergie', 'Yin Yang', 'Infinité'
                ];
                return $unisexNames[array_rand($unisexNames)] . ' ' . $adjectives[array_rand($adjectives)];
                
            default:
                return 'Parfum ' . Str::random(8);
        }
    }
    
    /**
     * Générer un nom de marque fictif
     */
    private function generateBrandName(): string
    {
        $brandPrefixes = [
            'Lux', 'Royal', 'Elite', 'Grand', 'Pure', 'Prima', 'Aroma', 'Scent', 'Ess', 'Frag',
            'Odor', 'Parf', 'Olor', 'Attar', 'Sens', 'Glam', 'Chic', 'Vogue', 'Mode', 'Style'
        ];
        
        $brandSuffixes = [
            'ance', 'ence', 'ia', 'ium', 'ique', 'or', 'ure', 'aris', 'oria', 'ium',
            'elle', 'ona', 'enza', 'ista', 'ismo', 'ita', 'ola', 'ose', 'ette', 'ier'
        ];
        
        // 30% de chance d'avoir un nom de marque composé
        if (rand(1, 100) <= 30) {
            $firstPart = $brandPrefixes[array_rand($brandPrefixes)];
            $secondPart = $brandSuffixes[array_rand($brandSuffixes)];
            $thirdPart = $brandPrefixes[array_rand($brandPrefixes)];
            
            return $firstPart . $secondPart . ' ' . $thirdPart;
        }
        
        // Format standard : préfix + suffixe
        return $brandPrefixes[array_rand($brandPrefixes)] . $brandSuffixes[array_rand($brandSuffixes)];
    }
    
    /**
     * Vérifier et seeder des données de référence si nécessaire
     */
    private function seedReferenceDataIfNeeded(bool $force = false): void
    {
        // Vérifier si les données de référence existent déjà
        if (!$force && ReferenceData::count() > 0) {
            return;
        }
        
        $this->command->info('Création des données de référence...');
        
        // Descriptions olfactives (adjectifs pour parfumerie)
        $olfactiveDescriptions = [
            'fleuri' => 'Fleuri',
            'boise' => 'Boisé',
            'agrume' => 'Agrume',
            'citron' => 'Citronné',
            'fruite' => 'Fruité',
            'sucre' => 'Sucré',
            'vanille' => 'Vanillé',
            'epice' => 'Épicé',
            'ambree' => 'Ambré',
            'musque' => 'Musqué',
            'cuir' => 'Cuir',
            'poudre' => 'Poudré',
            'vert' => 'Vert',
            'aromatique' => 'Aromatique',
            'frais' => 'Frais',
            'marin' => 'Marin',
            'oriental' => 'Oriental',
            'gourmand' => 'Gourmand',
            'fumee' => 'Fumé',
            'terreux' => 'Terreux',
            'resine' => 'Résineux',
            'balsamique' => 'Balsamique',
            'beurre' => 'Beurré',
            'mielleux' => 'Mielleux',
            'herbace' => 'Herbacé',
            'conifere' => 'Conifère',
            'lactone' => 'Lactoné',
            'aldehyde' => 'Aldéhydé'
        ];
        
        $order = 1;
        foreach ($olfactiveDescriptions as $value => $label) {
            ReferenceData::firstOrCreate(
                ['type' => 'description_olfactive', 'value' => $value],
                [
                    'label' => $label,
                    'description' => "Description olfactive: {$label}",
                    'order' => $order++,
                    'active' => true,
                    'is_multiple' => false
                ]
            );
        }
        
        // Familles olfactives (déjà définies dans ReferenceDataSeeder, mais les redéfinir ici pour être sûr)
        $famillesOlfactives = [
            'floral' => 'Floral',
            'floral_doux' => 'Floral doux',
            'floral_ambre' => 'Floral ambré',
            'ambre' => 'Ambré',
            'ambre_doux' => 'Ambré doux',
            'ambre_boise' => 'Ambré boisé',
            'boise' => 'Boisé',
            'bois_moussu' => 'Bois moussu',
            'bois_sec' => 'Bois sec',
            'fraiche_aromatique' => 'Fraîche Aromatique',
            'hesperide' => 'Hespéridé',
            'aquatic' => 'Aquatic',
            'vert' => 'Vert',
            'fruite' => 'Fruité',
        ];
        
        $order = 1;
        foreach ($famillesOlfactives as $value => $label) {
            ReferenceData::firstOrCreate(
                ['type' => 'famille_olfactive', 'value' => $value],
                [
                    'label' => $label,
                    'description' => "Famille olfactive: {$label}",
                    'order' => $order++,
                    'active' => true,
                    'is_multiple' => true,
                ]
            );
        }
        
        // Zones géographiques
        $zonesGeographiques = [
            'europe' => 'Europe',
            'amerique_nord' => 'Amérique du Nord',
            'amerique_sud' => 'Amérique du Sud',
            'asie_pacifique' => 'Asie-Pacifique',
            'moyen_orient' => 'Moyen-Orient',
            'afrique' => 'Afrique',
            'monde' => 'Monde entier',
            'france' => 'France',
            'allemagne' => 'Allemagne',
            'royaume_uni' => 'Royaume-Uni',
            'italie' => 'Italie',
            'espagne' => 'Espagne',
            'usa' => 'États-Unis',
            'chine' => 'Chine',
            'japon' => 'Japon',
            'coree_sud' => 'Corée du Sud',
            'inde' => 'Inde',
            'emirats_arabes_unis' => 'Émirats Arabes Unis',
            'arabie_saoudite' => 'Arabie Saoudite',
            'bresil' => 'Brésil',
            'russie' => 'Russie',
        ];
        
        $order = 1;
        foreach ($zonesGeographiques as $value => $label) {
            ReferenceData::firstOrCreate(
                ['type' => 'zone_geo', 'value' => $value],
                [
                    'label' => $label,
                    'description' => "Zone géographique: {$label}",
                    'order' => $order++,
                    'active' => true,
                    'is_multiple' => true,
                ]
            );
        }
        
        // Applications pour les produits du marché
        $applications = [
            'eau_parfum' => 'Eau de parfum',
            'cosmetique' => 'Cosmétique',
            'bougie' => 'Bougie',
            'ambiance' => 'Ambiance',
            'hygiene' => 'Hygiène',
            'detergence' => 'Détergence',
        ];
        
        $order = 1;
        foreach ($applications as $value => $label) {
            ReferenceData::firstOrCreate(
                ['type' => 'application', 'value' => $value],
                [
                    'label' => $label,
                    'description' => "Application: {$label}",
                    'order' => $order++,
                    'active' => true,
                    'is_multiple' => false,
                ]
            );
        }
        
        $this->command->info('Données de référence créées avec succès');
    }
    
    /**
     * Vérifier et seeder les familles de produits si nécessaire
     */
    private function seedProductFamiliesIfNeeded(): void
    {
        // Vérifier si les familles existent déjà
        if (ProductFamily::count() > 0) {
            return;
        }
        
        $this->command->info('Création des familles de produits...');
        
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
        
        $this->command->info('Familles de produits créées avec succès');
    }
}