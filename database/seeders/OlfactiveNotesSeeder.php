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
                'olfactive_note_name' => 'Bergamote',
                'olfactive_note_desc' => 'Agrume frais et pétillant, souvent utilisé en note de tête pour sa vivacité.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 2,
                'olfactive_note_name' => 'Citron',
                'olfactive_note_desc' => 'Frais, acidulé, éclatant, apporte une touche zestée et dynamique.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 3,
                'olfactive_note_name' => 'Orange',
                'olfactive_note_desc' => 'Doux et sucré, apporte une note fruitée et solaire.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 4,
                'olfactive_note_name' => 'Mandarine',
                'olfactive_note_desc' => 'Agrume doux et juteux, plus sucré que la bergamote ou le citron.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 5,
                'olfactive_note_name' => 'Pamplemousse',
                'olfactive_note_desc' => 'Agrume amer et tonique, très rafraîchissant en tête.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 6,
                'olfactive_note_name' => 'Lavande',
                'olfactive_note_desc' => 'Florale aromatique, camphrée, emblématique des fougères.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 7,
                'olfactive_note_name' => 'Menthe',
                'olfactive_note_desc' => 'Fraîche et revigorante, mentholée, utilisée pour un effet glacé.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 8,
                'olfactive_note_name' => 'Basilic',
                'olfactive_note_desc' => 'Herbacé et épicé, donne un effet aromatique naturel.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 9,
                'olfactive_note_name' => 'Poivre rose',
                'olfactive_note_desc' => 'Épicé doux, légèrement fruité, apporte du peps à l\'ouverture.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 10,
                'olfactive_note_name' => 'Cardamome',
                'olfactive_note_desc' => 'Épice chaude et fraîche à la fois, raffinée et verte.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 11,
                'olfactive_note_name' => 'Cannelle',
                'olfactive_note_desc' => 'Chaude, sucrée et épicée, souvent présente dans les accords orientaux.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 12,
                'olfactive_note_name' => 'Gingembre',
                'olfactive_note_desc' => 'Piquant et pétillant, pour un effet stimulant et vif.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 13,
                'olfactive_note_name' => 'Jasmin',
                'olfactive_note_desc' => 'Floral blanc opulent, sensuel et riche.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 14,
                'olfactive_note_name' => 'Rose',
                'olfactive_note_desc' => 'Florale classique, douce ou verte selon les variétés.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 15,
                'olfactive_note_name' => 'Muguet',
                'olfactive_note_desc' => 'Florale verte et fraîche, évoque le printemps.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 16,
                'olfactive_note_name' => 'Ylang-Ylang',
                'olfactive_note_desc' => 'Exotique, floral et crémeux, aux facettes légèrement épicées.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 17,
                'olfactive_note_name' => 'Fleur d\'oranger',
                'olfactive_note_desc' => 'Florale douce, miellée et légèrement verte.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 18,
                'olfactive_note_name' => 'Iris',
                'olfactive_note_desc' => 'Poudré, élégant, raffiné, souvent associé au luxe.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 19,
                'olfactive_note_name' => 'Violette',
                'olfactive_note_desc' => 'Douce, poudrée, légèrement verte, très féminine.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 20,
                'olfactive_note_name' => 'Pêche',
                'olfactive_note_desc' => 'Fruité sucré et velouté, apporte de la rondeur.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 21,
                'olfactive_note_name' => 'Framboise',
                'olfactive_note_desc' => 'Fruit rouge acidulé et sucré, gourmand.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 22,
                'olfactive_note_name' => 'Cassis',
                'olfactive_note_desc' => 'Fruité vert et acide, un peu animal, très caractéristique.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 23,
                'olfactive_note_name' => 'Pomme',
                'olfactive_note_desc' => 'Fraîche, croquante, légèrement acidulée.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 24,
                'olfactive_note_name' => 'Patchouli',
                'olfactive_note_desc' => 'Terreux, boisé et camphré, puissant et tenace.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 25,
                'olfactive_note_name' => 'Santal',
                'olfactive_note_desc' => 'Boisé lacté, crémeux et enveloppant.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 26,
                'olfactive_note_name' => 'Cèdre',
                'olfactive_note_desc' => 'Boisé sec, propre et élégant, souvent masculin.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 27,
                'olfactive_note_name' => 'Vétiver',
                'olfactive_note_desc' => 'Boisé terreux, fumé, légèrement amer, très utilisé en fond.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 28,
                'olfactive_note_name' => 'Ambre',
                'olfactive_note_desc' => 'Doux, chaud, résineux, avec des facettes vanillées.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 29,
                'olfactive_note_name' => 'Vanille',
                'olfactive_note_desc' => 'Sucrée, chaude, gourmande, évoque les desserts.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 30,
                'olfactive_note_name' => 'Musc blanc',
                'olfactive_note_desc' => 'Doux, propre, poudré, effet "peau propre" moderne.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 31,
                'olfactive_note_name' => 'Encens',
                'olfactive_note_desc' => 'Résineux, mystique et sec, souvent utilisé dans les orientaux.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 32,
                'olfactive_note_name' => 'Cuir',
                'olfactive_note_desc' => 'Animal, fumé et sec, évoque le luxe ou l\'élégance brute.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 33,
                'olfactive_note_name' => 'Tabac',
                'olfactive_note_desc' => 'Doux, sec ou miellé, parfois épicé ou boisé.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 34,
                'olfactive_note_name' => 'Tonka',
                'olfactive_note_desc' => 'Sucrée, amandée, proche de la vanille, avec des facettes foin.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 35,
                'olfactive_note_name' => 'Benjoin',
                'olfactive_note_desc' => 'Résine douce, balsamique, vanillée, réconfortante.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 36,
                'olfactive_note_name' => 'Mousse de chêne',
                'olfactive_note_desc' => 'Terreuse, humide, aromatique, essentielle dans les chyprés.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 37,
                'olfactive_note_name' => 'Aldéhydes',
                'olfactive_note_desc' => 'Effet pétillant, métallique, légèrement gras et savonneux.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 38,
                'olfactive_note_name' => 'Accord ozonique',
                'olfactive_note_desc' => 'Fraîcheur "air pur", propre et cristalline.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 39,
                'olfactive_note_name' => 'Accord aquatique',
                'olfactive_note_desc' => 'Iodé, marin, salin, évoque la mer et la fraîcheur.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 40,
                'olfactive_note_name' => 'Accord solaire',
                'olfactive_note_desc' => 'Chaud, doux, évoquant la peau chauffée par le soleil.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 41,
                'olfactive_note_name' => 'Bois de oud',
                'olfactive_note_desc' => 'Fumé, animal, résineux, profond et mystérieux.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 42,
                'olfactive_note_name' => 'Safran',
                'olfactive_note_desc' => 'Épicé cuiré, légèrement médicinal, chaud et intense.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 43,
                'olfactive_note_name' => 'Rose Damascena',
                'olfactive_note_desc' => 'Florale riche, miellée et fruitée, très utilisée dans les parfums orientaux.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 44,
                'olfactive_note_name' => 'Encens oliban',
                'olfactive_note_desc' => 'Résine claire, citronnée, sacrée et mystique.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 45,
                'olfactive_note_name' => 'Myrrhe',
                'olfactive_note_desc' => 'Résine chaude, douce-amère, balsamique et spirituelle.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 46,
                'olfactive_note_name' => 'Ambre gris',
                'olfactive_note_desc' => 'Animal marin, doux, puissant fixateur, rare et luxueux.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 47,
                'olfactive_note_name' => 'Labdanum',
                'olfactive_note_desc' => 'Résine sombre, ambrée, légèrement cuirée, riche.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 48,
                'olfactive_note_name' => 'Bois de gaïac',
                'olfactive_note_desc' => 'Boisé fumé, légèrement sucré et résineux.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 49,
                'olfactive_note_name' => 'Cuir fumé',
                'olfactive_note_desc' => 'Cuir noir, fumé, intense, évoque la braise ou le feu de bois.',
                'olfactive_note_active' => true,
            ],
            [
                'id' => 50,
                'olfactive_note_name' => 'Miel',
                'olfactive_note_desc' => 'Sucré, animal, chaud, gourmand et parfois entêtant.',
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