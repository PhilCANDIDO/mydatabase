<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OlfactiveNotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $olfactiveNotes = [
            [
                'olfactive_note_name' => 'Bergamote',
                'olfactive_note_desc' => 'Agrume frais et légèrement floral, souvent utilisé en note de tête pour apporter fraîcheur et luminosité.',
                'olfactive_note_active' => true,
            ],
            [
                'olfactive_note_name' => 'Rose',
                'olfactive_note_desc' => 'Note florale riche et complexe, pilier de la parfumerie, avec des facettes variées selon les espèces utilisées.',
                'olfactive_note_active' => true,
            ],
            [
                'olfactive_note_name' => 'Jasmin',
                'olfactive_note_desc' => 'Fleur blanche puissante et envoûtante, incontournable en parfumerie, apportant sensualité et richesse.',
                'olfactive_note_active' => true,
            ],
            [
                'olfactive_note_name' => 'Vétiver',
                'olfactive_note_desc' => 'Note terreuse et boisée extraite des racines, apportant profondeur et caractère, souvent utilisée en fond.',
                'olfactive_note_active' => true,
            ],
            [
                'olfactive_note_name' => 'Vanille',
                'olfactive_note_desc' => 'Note gourmande, chaude et réconfortante, très appréciée en fond pour sa douceur et sa persistance.',
                'olfactive_note_active' => true,
            ],
            [
                'olfactive_note_name' => 'Patchouli',
                'olfactive_note_desc' => 'Note terreuse et boisée au caractère affirmé, apportant profondeur et sensualité aux compositions.',
                'olfactive_note_active' => true,
            ],
            [
                'olfactive_note_name' => 'Lavande',
                'olfactive_note_desc' => 'Note aromatique fraîche et herbacée, classique de la parfumerie, particulièrement utilisée dans les fougères.',
                'olfactive_note_active' => true,
            ],
            [
                'olfactive_note_name' => 'Citron',
                'olfactive_note_desc' => 'Agrume vif et pétillant, apportant fraîcheur et énergie en note de tête, très utilisé dans les colognes.',
                'olfactive_note_active' => true,
            ],
            [
                'olfactive_note_name' => 'Musc',
                'olfactive_note_desc' => 'Note sensuelle et enveloppante, fixateur par excellence, donnant rondeur et persistance aux parfums.',
                'olfactive_note_active' => true,
            ],
            [
                'olfactive_note_name' => 'Santal',
                'olfactive_note_desc' => 'Bois crémeux et lacté, à la fois doux et persistant, apportant chaleur et élégance aux compositions.',
                'olfactive_note_active' => true,
            ],
            [
                'olfactive_note_name' => 'Ambre',
                'olfactive_note_desc' => 'Accord chaud et vanillé, plutôt qu\'ingrédient unique, apportant chaleur et sensualité en fond.',
                'olfactive_note_active' => true,
            ],
            [
                'olfactive_note_name' => 'Cèdre',
                'olfactive_note_desc' => 'Bois sec et élégant, avec des facettes à la fois fraîches et chaudes, pilier des parfums masculins.',
                'olfactive_note_active' => true,
            ],
            [
                'olfactive_note_name' => 'Tubéreuse',
                'olfactive_note_desc' => 'Fleur blanche capiteuse et entêtante au caractère très affirmé, icône de la parfumerie opulente.',
                'olfactive_note_active' => true,
            ],
            [
                'olfactive_note_name' => 'Cannelle',
                'olfactive_note_desc' => 'Épice chaude et sucrée apportant chaleur et dynamisme, avec une légère facette piquante.',
                'olfactive_note_active' => true,
            ],
            [
                'olfactive_note_name' => 'Iris',
                'olfactive_note_desc' => 'Note poudreuse et élégante extraite des racines (orris), précieuse et sophistiquée, avec des aspects boisés.',
                'olfactive_note_active' => true,
            ],
            [
                'olfactive_note_name' => 'Fraise',
                'olfactive_note_desc' => 'Note fruitée douce et gourmande, apportant une dimension juteuse et légèrement acidulée.',
                'olfactive_note_active' => true,
            ],
            [
                'olfactive_note_name' => 'Oud',
                'olfactive_note_desc' => 'Bois précieux du Moyen-Orient aux facettes animales et boisées puissantes, très recherché en parfumerie de luxe.',
                'olfactive_note_active' => true,
            ],
            [
                'olfactive_note_name' => 'Violette',
                'olfactive_note_desc' => 'Note florale délicate et poudreuse avec des aspects verts et légèrement aqueux, très reconnaissable.',
                'olfactive_note_active' => true,
            ],
            [
                'olfactive_note_name' => 'Menthe',
                'olfactive_note_desc' => 'Note aromatique fraîche et vivifiante, apportant une sensation de fraîcheur immédiate en tête.',
                'olfactive_note_active' => true,
            ],
            [
                'olfactive_note_name' => 'Cardamome',
                'olfactive_note_desc' => 'Épice fraîche et légèrement camphrée, apportant fraîcheur et complexité sans l\'acidité des agrumes.',
                'olfactive_note_active' => true,
            ],
            [
                'olfactive_note_name' => 'Fève Tonka',
                'olfactive_note_desc' => 'Note gourmande aux facettes vanillées, amandées et tabacées, apportant chaleur et sensualité.',
                'olfactive_note_active' => true,
            ],
            [
                'olfactive_note_name' => 'Poivre',
                'olfactive_note_desc' => 'Épice piquante et dynamique, souvent utilisée en tête pour apporter vibration et caractère.',
                'olfactive_note_active' => true,
            ],
            [
                'olfactive_note_name' => 'Orange',
                'olfactive_note_desc' => 'Agrume doux et ensoleillé, plus chaleureux que le citron, apportant joie et énergie positive.',
                'olfactive_note_active' => true,
            ],
            [
                'olfactive_note_name' => 'Pêche',
                'olfactive_note_desc' => 'Fruit juteux et velouté aux notes douces et légèrement lactées, très utilisé dans les floraux féminins.',
                'olfactive_note_active' => true,
            ],
            [
                'olfactive_note_name' => 'Ylang-Ylang',
                'olfactive_note_desc' => 'Fleur exotique crémeuse aux facettes légèrement épicées et bananes, apportant sensualité et exotisme.',
                'olfactive_note_active' => true,
            ],
        ];

        foreach ($olfactiveNotes as $olfactiveNote) {
            // Vérifier si la note olfactive existe déjà pour éviter les doublons
            $exists = DB::table('olfactive_notes')
                ->where('olfactive_note_name', $olfactiveNote['olfactive_note_name'])
                ->exists();
                
            if (!$exists) {
                DB::table('olfactive_notes')->insert(array_merge($olfactiveNote, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
                $this->command->info("Note olfactive \"{$olfactiveNote['olfactive_note_name']}\" créée.");
            } else {
                $this->command->info("Note olfactive \"{$olfactiveNote['olfactive_note_name']}\" existe déjà.");
            }
        }
    }
}