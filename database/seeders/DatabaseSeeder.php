<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RolesAndPermissionsSeeder::class,
            AdminUserSeeder::class,
            UsersSeeder::class,
            ProductFamiliesSeeder::class,
            ApplicationsSeeder::class,
            ZoneGeosSeeder::class,
            OlfactiveFamiliesSeeder::class,
            OlfactiveNotesSeeder::class,
        ]);

    }
}
