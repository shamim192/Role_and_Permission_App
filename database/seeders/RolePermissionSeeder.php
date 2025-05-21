<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'create post',
            'edit post',
            'delete post',
            'publish post',
            'unpublish post',
            'view admin dashboard',
            'manage users',
            'manage roles',
            'manage permissions'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'admin']);

        $adminPermissions = [
            'create post',
            'edit post',
            'delete post',
            'publish post',
            'unpublish post',
            'view admin dashboard'
        ];

        $role->givePermissionTo($adminPermissions);

        $role = Role::create(['name' => 'editor']);
        $editorPermissions = [
            'create post',
            'edit post',
            'view admin dashboard'
        ];
        $role->givePermissionTo($editorPermissions);

        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo('view admin dashboard');


        // Create super admin user
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password')
        ]);

        $user->assignRole('super-admin');

        // Create admin user
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]);
        $user->assignRole('admin');

        // Create editor user
        $user = User::create([
            'name' => 'Editor User',
            'email' => 'editor@example.com',
            'password' => bcrypt('password')
        ]);
        $user->assignRole('editor');

        // Create regular user
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password')
        ]);
        $user->assignRole('user');
    }
}
