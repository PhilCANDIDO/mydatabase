<?php

namespace Database\Seeders;

use App\Models\ReferenceData;
use Illuminate\Database\Seeder;

class ReferenceDataSeeder extends Seeder
{
    public function run()
    {
        // Applications (choix unique)
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
                    'order' => $order++,
                    'active' => true,
                    'is_multiple' => false,
                ]
            );
        }
        
        // Familles olfactives (choix multiple)
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
                    'order' => $order++,
                    'active' => true,
                    'is_multiple' => true,
                ]
            );
        }
    }
}