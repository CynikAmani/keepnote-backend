<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Define all permissions based on your routes
        $permissions = [
            // User Management
            'view-users', 'create-user', 'update-user', 'delete-user',

            // Role & Permission Management
            'view-roles', 'create-role', 'update-role', 'delete-role',
            'view-role-permissions', 'update-role-permissions',

            // Labels
            'view-labels', 'create-label', 'update-label', 'delete-label',

            // Notes
            'view-notes', 'create-note', 'update-note', 'delete-note',
            
            // Todos
            'view-todo-groups', 'create-todo-group', 'update-todo-group', 'delete-todo-group',
            'create-todo-item', 'update-todo-item', 'delete-todo-item',
        ];
    
        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }
    
        // 2. Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole  = Role::firstOrCreate(['name' => 'user']);
    
        // 3. Mapping: Give 'user' a restricted set of permissions
        $userPermissions = Permission::whereIn('name', [
            'view-labels', 'create-label', 'update-label', 'delete-label',
            'view-notes', 'create-note', 'update-note', 'delete-note',
            'view-todo-groups', 'create-todo-group', 'update-todo-group', 'delete-todo-group',
            'create-todo-item', 'update-todo-item', 'delete-todo-item',
        ])->get();
    
        $userRole->permissions()->sync($userPermissions->pluck('id'));
    
        // 4. Mapping: Give 'admin' EVERYTHING
        $allPermissions = Permission::all();
        $adminRole->permissions()->sync($allPermissions->pluck('id'));
    }
}