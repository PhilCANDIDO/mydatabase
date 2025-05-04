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
                'id' => 1,
                'olfactive_note_name' => 'Florale',
                'olfactive_note_desc' => 'Fleurie, douce, romantique.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 2,
                'olfactive_note_name' => 'Hespéridé',
                'olfactive_note_desc' => 'Agrumes frais et pétillants.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 3,
                'olfactive_note_name' => 'Epicé',
                'olfactive_note_desc' => 'Chaud, piquant, stimulant.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 4,
                'olfactive_note_name' => 'Chypre',
                'olfactive_note_desc' => 'Terreux, boisé, avec une touche de mousse.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 5,
                'olfactive_note_name' => 'Musqué',
                'olfactive_note_desc' => '',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 6,
                'olfactive_note_name' => 'Fougère',
                'olfactive_note_desc' => 'Florale aromatique, camphrée, emblématique des fougères.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 7,
                'olfactive_note_name' => 'Fruité',
                'olfactive_note_desc' => 'Sucré, juteux, gourmand.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 8,
                'olfactive_note_name' => 'Boisé',
                'olfactive_note_desc' => 'Chaud, sec, souvent masculin.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 9,
                'olfactive_note_name' => 'Ambré',
                'olfactive_note_desc' => 'Chaud, doux, résineux, souvent oriental.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 10,
                'olfactive_note_name' => 'Aromatique',
                'olfactive_note_desc' => 'Herbacé, frais.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 11,
                'olfactive_note_name' => 'Solaire',
                'olfactive_note_desc' => 'Chaud, doux, évoque la lumière et la chaleur.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 12,
                'olfactive_note_name' => 'Marine',
                'olfactive_note_desc' => 'Iodé, frais, évoque l\'océan.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 13,
                'olfactive_note_name' => 'Aldéhyde',
                'olfactive_note_desc' => 'Frais, pétillant, métallique',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 14,
                'olfactive_note_name' => 'Poudré',
                'olfactive_note_desc' => 'Douceur, élégance, souvent associée à la vanille.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 15,
                'olfactive_note_name' => 'Vert',
                'olfactive_note_desc' => 'Herbacé, frais, évoque la nature.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 16,
                'olfactive_note_name' => 'Cuir',
                'olfactive_note_desc' => 'Animal, fumé, sec, souvent associé à la masculinité.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 17,
                'olfactive_note_name' => 'Gourmand',
                'olfactive_note_desc' => 'Sucré, comestible, évoque les desserts.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 18,
                'olfactive_note_name' => 'Animal',
                'olfactive_note_desc' => 'Félin, musqué, souvent associé à la sensualité.',
                'olfactive_note_active' => true,
            ],
        ];

        foreach ($olfactiveNotes as $olfactiveNote) {
            // Vérifier si la note olfactive existe déjà pour éviter les doublons
            $exists = DB::table('olfactive_notes')
                ->where('id', $olfactiveNote['id'])
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