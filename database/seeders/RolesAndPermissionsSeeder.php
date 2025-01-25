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
         Permission::create(['name' => 'view users']);
         Permission::create(['name' => 'edit users']);
         Permission::create(['name' => 'delete users']);

         // Créer les rôles et assigner les permissions
         $adminRole = Role::create(['name' => 'admin']);
         $adminRole->givePermissionTo(['view users', 'edit users', 'delete users']);

         $userRole = Role::create(['name' => 'user']);
         $userRole->givePermissionTo(['view users']);
    }
}
