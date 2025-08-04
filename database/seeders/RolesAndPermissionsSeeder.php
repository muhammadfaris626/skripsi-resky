<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Str;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        app()['cache']->forget('spatie.permission.cache');

        $entities = ['user', 'role', 'permission', 'employee', 'target', 'sale', 'performance'];
        $actions = ['menu', 'create', 'read', 'update', 'delete'];
        $permissions = [];
        foreach ($entities as $entity) {
            foreach ($actions as $action) {
                $permissions["{$entity}: {$action}"] = Permission::create(['name' => "{$entity}: {$action}"]);
            }
        }
        $roles = [
            'root' => array_values($permissions),
            'stakeholder' => [],
            'admin' => [

            ],
            'staff' => [
                $permissions['sale: menu'], $permissions['sale: create'],
            ]
        ];
        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::create(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }
        $users = [
            [
                'name' => 'Root',
                'username' => 'root',
                'email' => 'root@system.com',
                'role' => 'root'
            ],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@system.com',
                'role' => 'admin'
            ],
            [
                'name' => 'Sales 1',
                'username' => 'sales1',
                'email' => 'sales1@system.com',
                'role' => 'staff'
            ],
            [
                'name' => 'Sales 2',
                'username' => 'sales2',
                'email' => 'sales2@system.com',
                'role' => 'staff'
            ],
            [
                'name' => 'Sales 3',
                'username' => 'sales3',
                'email' => 'sales3@system.com',
                'role' => 'staff'
            ]
        ];
        foreach ($users as $userData) {
            User::create([
                'name' => $userData['name'],
                'username' => $userData['username'],
                'email' => $userData['email'],
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ])->assignRole($userData['role']);
        }
    }
}
