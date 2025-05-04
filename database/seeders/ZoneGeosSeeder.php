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
                'zone_geo_name' => 'Amérique',
                'zone_geo_desc' => 'Pays d\'Amérique du nord et du sud.',
                'zone_geo_active' => true,
            ],
            [
                'zone_geo_name' => 'Europe',
                'zone_geo_desc' => 'Pays du continent européen .',
                'zone_geo_active' => true,
            ],
            [
                'zone_geo_name' => 'Asie',
                'zone_geo_desc' => 'Pays d\'asie.',
                'zone_geo_active' => true,
            ],
            [
                'zone_geo_name' => 'Moyen-Orient',
                'zone_geo_desc' => 'Péninsule arabique, Iran, Irak, Syrie, Israël et pays environnants.',
                'zone_geo_active' => true,
            ],
            [
                'zone_geo_name' => 'Afrique',
                'zone_geo_desc' => 'Pays africains et du Maghreb.',
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