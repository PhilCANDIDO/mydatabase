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
        
    }
}