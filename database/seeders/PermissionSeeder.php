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

        $role_admin_administrator = Role::create(['name' => 'admin-administrator']);
        $role_admin_administrator->givePermissionTo(Permission::all());

        // Find the user with ID 1 and assign the new admin-administrator role
        $adminAdministrator = User::where('id', 1)->first();
        $adminAdministrator->syncRoles([$role_admin_administrator]);

        // Get Permissions by Role then assign user to permission
        $permission_admin_administrator = $role_admin_administrator->permissions->pluck('name')->toArray();
        $permission_user = $role_user->permissions->pluck('name')->toArray();
        // $user->syncPermissions($permission_user);
        $adminAdministrator->syncPermissions($permission_admin_administrator);
    }
}
