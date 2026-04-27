<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Users' => [
                'view-users'   => 'View Users',
                'create-user'  => 'Create User',
                'update-user'  => 'Update User',
                'delete-user'  => 'Delete User',
            ],
            'Roles' => [
                'view-roles'              => 'View Roles',
                'create-role'             => 'Create Role',
                'update-role'             => 'Update Role',
                'delete-role'             => 'Delete Role',
                'view-role-permissions'   => 'View Role Permissions',
                'update-role-permissions' => 'Update Role Permissions',
            ],
            'Notes' => [
                'view-notes'   => 'View Notes',
                'create-note'  => 'Create Note',
                'update-note'  => 'Update Note',
                'delete-note'  => 'Delete Note',
            ],
            'Todos' => [
                'view-todo-groups'   => 'View Todo Groups',
                'create-todo-group'  => 'Create Todo Group',
                'update-todo-group'  => 'Update Todo Group',
                'delete-todo-group'  => 'Delete Todo Group',
                'create-todo-item'   => 'Create Todo Item',
                'update-todo-item'   => 'Update Todo Item',
                'delete-todo-item'   => 'Delete Todo Item',
            ],
            'Labels' => [
                'view-labels'   => 'View Labels',
                'create-label'  => 'Create Label',
                'update-label'  => 'Update Label',
                'delete-label'  => 'Delete Label',
            ],
        ];

        foreach ($data as $module => $actions) {
            foreach ($actions as $name => $displayName) {
                Permission::updateOrCreate(
                    ['name' => $name],
                    [
                        'display_name' => $displayName,
                        'module'       => $module,
                    ]
                );
            }
        }

        // Initialize basic roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user  = Role::firstOrCreate(['name' => 'user']);

        // Admin gets everything
        $admin->permissions()->sync(Permission::all()->pluck('id'));

        // User gets content-related permissions
        $userPermissions = Permission::whereIn('module', ['Notes', 'Todos', 'Labels'])->pluck('id');
        $user->permissions()->sync($userPermissions);
    }
}