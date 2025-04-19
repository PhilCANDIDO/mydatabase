<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZoneGeosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zoneGeos = [
            [
                'zone_geo_name' => 'Amérique du Nord',
                'zone_geo_desc' => 'Canada, États-Unis, Mexique et pays d\'Amérique centrale.',
                'zone_geo_active' => true,
            ],
            [
                'zone_geo_name' => 'Amérique Latine',
                'zone_geo_desc' => 'Pays d\'Amérique du Sud et centrale où l\'on parle majoritairement l\'espagnol et le portugais.',
                'zone_geo_active' => true,
            ],
            [
                'zone_geo_name' => 'Europe',
                'zone_geo_desc' => 'Pays du continent européen hors France.',
                'zone_geo_active' => true,
            ],
            [
                'zone_geo_name' => 'France',
                'zone_geo_desc' => 'Marché français métropolitain et DOM-TOM.',
                'zone_geo_active' => true,
            ],
            [
                'zone_geo_name' => 'Asie du Nord',
                'zone_geo_desc' => 'Chine, Japon, Corée, Mongolie et régions associées.',
                'zone_geo_active' => true,
            ],
            [
                'zone_geo_name' => 'Asie du Sud',
                'zone_geo_desc' => 'Inde, Pakistan, Népal, Bangladesh, Sri Lanka et pays d\'Asie du Sud-Est.',
                'zone_geo_active' => true,
            ],
            [
                'zone_geo_name' => 'Pacifique',
                'zone_geo_desc' => 'Australie, Nouvelle-Zélande et îles du Pacifique.',
                'zone_geo_active' => true,
            ],
            [
                'zone_geo_name' => 'Moyen-Orient',
                'zone_geo_desc' => 'Péninsule arabique, Iran, Irak, Syrie, Israël et pays environnants.',
                'zone_geo_active' => true,
            ],
            [
                'zone_geo_name' => 'Afrique du Nord',
                'zone_geo_desc' => 'Pays du Maghreb et Égypte.',
                'zone_geo_active' => true,
            ],
            [
                'zone_geo_name' => 'Afrique Subsaharienne',
                'zone_geo_desc' => 'Pays africains au sud du Sahara.',
                'zone_geo_active' => true,
            ],
        ];

        foreach ($zoneGeos as $zoneGeo) {
            // Vérifier si la zone géographique existe déjà pour éviter les doublons
            $exists = DB::table('zone_geos')
                ->where('zone_geo_name', $zoneGeo['zone_geo_name'])
                ->exists();
                
            if (!$exists) {
                DB::table('zone_geos')->insert(array_merge($zoneGeo, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
                $this->command->info("Zone géographique \"{$zoneGeo['zone_geo_name']}\" créée.");
            } else {
                $this->command->info("Zone géographique \"{$zoneGeo['zone_geo_name']}\" existe déjà.");
            }
        }
    }
}