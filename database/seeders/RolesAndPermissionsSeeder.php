<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $comptableRole = Role::firstOrCreate(['name' => 'Comptable']);
        $chefComptableRole = Role::firstOrCreate(['name' => 'Chef Comptable']);

        // Create permissions if they don't exist
        $createPermission = Permission::firstOrCreate(['name' => 'create']);
        $editPermission =   Permission::firstOrCreate(['name' => 'edit']);
        $deletePermission = Permission::firstOrCreate(['name' => 'delete']);

        // Assign permissions to roles (attach if not already attached)
        if (!$adminRole->permissions()->where('name', 'create')->exists()) {
            $adminRole->permissions()->attach($createPermission->id);
        }
        if (!$adminRole->permissions()->where('name', 'edit')->exists()) {
            $adminRole->permissions()->attach($editPermission->id);
        }
        if (!$adminRole->permissions()->where('name', 'delete')->exists()) {
            $adminRole->permissions()->attach($deletePermission->id);
        }

        if (!$comptableRole->permissions()->where('name', 'create')->exists()) {
            $comptableRole->permissions()->attach($createPermission->id);
        }
        if (!$comptableRole->permissions()->where('name', 'create')->exists()) {
            $comptableRole->permissions()->attach($editPermission->id);
        }
        if (!$comptableRole->permissions()->where('name', 'create')->exists()) {
            $comptableRole->permissions()->attach($deletePermission->id);
        }

        // Assign permissions to Chef Comptable role as needed, similar to Admin or Comptable
        // (example, if Chef Comptable has the same permissions as Admin)
        /*if (!$chefComptableRole->permissions()->where('name', 'create')->exists()) {
            $chefComptableRole->permissions()->attach($createPermission->id);
        }*/
        if (!$chefComptableRole->permissions()->where('name', 'edit')->exists()) {
            $chefComptableRole->permissions()->attach($editPermission->id);
        }
        if (!$chefComptableRole->permissions()->where('name', 'delete')->exists()) {
            $chefComptableRole->permissions()->attach($deletePermission->id);
        }
    }
}
