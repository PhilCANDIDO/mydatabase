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

        // Zones géographiques (choix multiple)
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
                    'order' => $order++,
                    'active' => true,
                    'is_multiple' => true,
                ]
            );
        }
    }
}