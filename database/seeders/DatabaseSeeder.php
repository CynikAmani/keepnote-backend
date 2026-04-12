<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Run the Role/Permission setup first
        $this->call([
            RoleAndPermissionSeeder::class,
        ]);

        // 2. Create a "Super Admin" for development
        $admin = User::factory()->create([
            'name'  => 'Admin User',
            'email' => 'admin@keep.com',
        ]);

        // Attach the admin role to this user
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $admin->roles()->attach($adminRole->id);
        }

        // 3. (Optional) Create some regular users for testing
        User::factory(5)->create()->each(function ($user) {
            $userRole = Role::where('name', 'user')->first();
            if ($userRole) {
                $user->roles()->attach($userRole->id);
            }
        });
    }
}