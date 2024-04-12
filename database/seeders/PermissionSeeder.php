<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        app()['cache']->forget('spatie.permission.cache');
        $faker = \Faker\Factory::create();

        // create permissions
        Permission::create(['name' => 'browse', 'guard_name' => 'api']);
        Permission::create(['name' => 'read', 'guard_name' => 'api']);
        Permission::create(['name' => 'edit', 'guard_name' => 'api']);
        Permission::create(['name' => 'add', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete', 'guard_name' => 'api']);

        //create roles and assign existing permissions
        $role_user = Role::create(['name' => 'user']);
        $role_user->givePermissionTo('browse');
        $role_user->givePermissionTo('read');

        $role_admin = Role::create(['name' => 'admin']);
        $role_admin->givePermissionTo('browse');
        $role_admin->givePermissionTo('read');
        $role_admin->givePermissionTo('edit');
        $role_admin->givePermissionTo('add');
        $role_admin->givePermissionTo('delete');

        $role_inactive = Role::create(['name' => 'inactive']);
        $role_inactive->givePermissionTo('browse');
        $role_inactive->givePermissionTo('read');

        // Assign user to role
        $admin = User::where(['id' => 1])->first();
        // $user = User::where(['id' => 2])->first();
        $admin->syncRoles([$role_admin]);
        // $user->syncRoles([$role_user]);

        // Get Permissions by Role then assign user to permission
        $permission_admin = $role_admin->permissions->pluck('name')->toArray();
        $permission_user = $role_user->permissions->pluck('name')->toArray();
        // $user->syncPermissions($permission_user);
        $admin->syncPermissions($permission_admin);
    }
}
