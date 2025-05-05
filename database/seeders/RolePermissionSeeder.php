<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Vider le cache des permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Créer les permissions
        Permission::create(['name' => 'voir archives']);
        Permission::create(['name' => 'créer archives']);
        Permission::create(['name' => 'modifier archives']);
        Permission::create(['name' => 'supprimer archives']);
        Permission::create(['name' => 'gérer utilisateurs']);
        Permission::create(['name' => 'gérer paramètres']);

        // 2. Créer les rôles et leur attribuer des permissions
        $consultant = Role::create(['name' => 'consultation']);
        $consultant->givePermissionTo(['voir archives']);

        $agent = Role::create(['name' => 'agent']);
        $agent->givePermissionTo(['voir archives', 'créer archives']);

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());
        $user = User::find(1);
        if($user){
            $user->assignRole('admin');

        }
    }
}
