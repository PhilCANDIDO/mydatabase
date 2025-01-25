<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer les permissions
        $permissions = [
            'view data',
            'add data',
            'edit data',
            'delete data',
            'import data',
            'export data',
            'manage users',
            'view audit',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Créer les rôles et assigner les permissions
        $reader = Role::firstOrCreate(['name' => 'Reader']);
        $reader->givePermissionTo(['view data']);

        $writer = Role::firstOrCreate(['name' => 'Writer']);
        $writer->givePermissionTo(['view data', 'add data']);

        $superviser = Role::firstOrCreate(['name' => 'Superviser']);
        $superviser->givePermissionTo([
            'view data',
            'add data',
            'edit data',
            'delete data',
            'import data',
            'export data',
        ]);

        $super = Role::firstOrCreate(['name' => 'Super']);
        $super->givePermissionTo(Permission::all());
    }
}
