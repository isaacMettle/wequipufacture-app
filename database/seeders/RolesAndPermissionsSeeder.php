<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Créer les permissions
        /*Permission::create(['name' => 'view invoices']);
        Permission::create(['name' => 'create invoices']);
        Permission::create(['name' => 'edit invoices']);
        Permission::create(['name' => 'delete invoices']);
        Permission::create(['name' => 'validate invoices']);
        

        
        $admin = Role::create(['name' => 'Admin']);
        $admin->givePermissionTo(Permission::all());

        $chefComptable = Role::create(['name' => 'Chef Comptable']);
        $chefComptable->givePermissionTo(['view invoices', 'validate invoices', 'delete invoices']);

        $comptable = Role::create(['name' => 'Comptable']);
        $comptable->givePermissionTo(['view invoices', 'create invoices', 'edit invoices', 'delete invoices']);*/

        Permission::create(['name' => 'pay invoices']);
        $client = Role::create(['name' => 'Client']);
        $client->givePermissionTo(['pay invoices']);

        // Exemple : assigner le rôle Admin à un utilisateur spécifique
        /*$user = \App\Models\User::find(1); // Remplace 1 par l'ID de l'utilisateur que tu souhaites définir comme Admin
        if ($user) {
            $user->assignRole($admin);
        }*/
    }
}
