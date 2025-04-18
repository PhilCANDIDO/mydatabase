<?php

namespace Database\Seeders;

use App\Models\ReferenceData;
use Illuminate\Database\Seeder;

class ReferenceDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Données de référence par type
        $referenceDataSets = [
            // Zones géographiques
            'zone_geo' => [
                ['value' => 'europe', 'label' => 'Europe', 'description' => 'Pays européens', 'order' => 1],
                ['value' => 'namerica', 'label' => 'Amérique du Nord', 'description' => 'États-Unis et Canada', 'order' => 2],
                ['value' => 'lamerica', 'label' => 'Amérique Latine', 'description' => 'Amérique Centrale et du Sud', 'order' => 3],
                ['value' => 'asia', 'label' => 'Asie', 'description' => 'Pays asiatiques', 'order' => 4],
                ['value' => 'middle_east', 'label' => 'Moyen-Orient', 'description' => 'Pays du Moyen-Orient', 'order' => 5],
                ['value' => 'africa', 'label' => 'Afrique', 'description' => 'Pays africains', 'order' => 6],
                ['value' => 'oceania', 'label' => 'Océanie', 'description' => 'Australie et îles du Pacifique', 'order' => 7],
            ],
            
            // Familles olfactives
            'famille_olfactive' => [
                ['value' => 'floral', 'label' => 'Floral', 'description' => 'Notes florales dominantes', 'order' => 1],
                ['value' => 'oriental', 'label' => 'Oriental', 'description' => 'Notes chaudes et épicées', 'order' => 2],
                ['value' => 'woody', 'label' => 'Boisé', 'description' => 'Notes de bois', 'order' => 3],
                ['value' => 'fresh', 'label' => 'Frais', 'description' => 'Notes fraîches et légères', 'order' => 4],
                ['value' => 'fougere', 'label' => 'Fougère', 'description' => 'Notes aromatiques et lavande', 'order' => 5],
                ['value' => 'chypre', 'label' => 'Chypre', 'description' => 'Notes de mousse de chêne et agrumes', 'order' => 6],
                ['value' => 'gourmand', 'label' => 'Gourmand', 'description' => 'Notes sucrées et comestibles', 'order' => 7],
                ['value' => 'aquatic', 'label' => 'Aquatique', 'description' => 'Notes marines et océaniques', 'order' => 8],
            ],
            
            // Descriptions olfactives (notes)
            'description_olfactive' => [
                // Notes de tête
                ['value' => 'citrus', 'label' => 'Agrumes', 'description' => 'Orange, citron, bergamote', 'order' => 1],
                ['value' => 'lavender', 'label' => 'Lavande', 'description' => 'Aromatique et frais', 'order' => 2],
                ['value' => 'bergamot', 'label' => 'Bergamote', 'description' => 'Agrume avec des nuances florales', 'order' => 3],
                ['value' => 'mint', 'label' => 'Menthe', 'description' => 'Fraîche et herbacée', 'order' => 4],
                
                // Notes de cœur
                ['value' => 'rose', 'label' => 'Rose', 'description' => 'Floral classique', 'order' => 10],
                ['value' => 'jasmine', 'label' => 'Jasmin', 'description' => 'Floral intense', 'order' => 11],
                ['value' => 'ylang', 'label' => 'Ylang-Ylang', 'description' => 'Floral exotique', 'order' => 12],
                ['value' => 'violet', 'label' => 'Violette', 'description' => 'Floral délicat', 'order' => 13],
                
                // Notes de fond
                ['value' => 'vanilla', 'label' => 'Vanille', 'description' => 'Douce et chaude', 'order' => 20],
                ['value' => 'musk', 'label' => 'Musc', 'description' => 'Animal et chaud', 'order' => 21],
                ['value' => 'sandalwood', 'label' => 'Bois de Santal', 'description' => 'Boisé crémeux', 'order' => 22],
                ['value' => 'amber', 'label' => 'Ambre', 'description' => 'Chaud et résineux', 'order' => 23],
                ['value' => 'patchouli', 'label' => 'Patchouli', 'description' => 'Terreux et boisé', 'order' => 24],
            ],
            
            // Applications (utilisées principalement pour les produits du marché)
            'application' => [
                ['value' => 'edp', 'label' => 'Eau de Parfum', 'description' => 'Concentration 15-20%', 'order' => 1],
                ['value' => 'edt', 'label' => 'Eau de Toilette', 'description' => 'Concentration 8-15%', 'order' => 2],
                ['value' => 'edc', 'label' => 'Eau de Cologne', 'description' => 'Concentration 3-8%', 'order' => 3],
                ['value' => 'parfum', 'label' => 'Parfum', 'description' => 'Concentration 20-30%', 'order' => 4],
                ['value' => 'cosmetic', 'label' => 'Cosmétique', 'description' => 'Pour produits de soin', 'order' => 5],
                ['value' => 'candle', 'label' => 'Bougie', 'description' => 'Pour parfumer l\'air', 'order' => 6],
                ['value' => 'home', 'label' => 'Parfum d\'Intérieur', 'description' => 'Diffuseurs, sprays d\'ambiance', 'order' => 7],
            ],
        ];

        // Création des données de référence
        foreach ($referenceDataSets as $type => $dataSet) {
            $this->command->info("Création des données de référence pour le type: $type");
            
            foreach ($dataSet as $data) {
                // Vérifier si la donnée existe déjà
                $existingData = ReferenceData::where('type', $type)
                    ->where('value', $data['value'])
                    ->first();
                
                if (!$existingData) {
                    ReferenceData::create([
                        'type' => $type,
                        'value' => $data['value'],
                        'label' => $data['label'],
                        'description' => $data['description'],
                        'order' => $data['order'],
                        'active' => true,
                        'is_multiple' => $type === 'zone_geo' ? true : false, // Par défaut, seule la zone_geo permet une sélection multiple
                    ]);
                    $this->command->info("  - '{$data['label']}' créé");
                } else {
                    $this->command->info("  - '{$data['label']}' existe déjà");
                }
            }
        }
    }
}