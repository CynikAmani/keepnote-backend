<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // System-critical seeders must run in every environment.
        $this->call([
            RoleAndPermissionSeeder::class,
            AdminUserSeeder::class,
        ]);

        // Development and test data uses factories, which depend on fakerphp/faker.
        if (app()->environment('local', 'testing')) {
            $admin = User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@keep.com',
            ]);

            // Attach the admin role to this user
            $adminRole = Role::where('name', 'admin')->first();
            if ($adminRole) {
                $admin->roles()->attach($adminRole->id);
            }

            User::factory(5)->create()->each(function ($user) {
                $userRole = Role::where('name', 'user')->first();
                if ($userRole) {
                    $user->roles()->attach($userRole->id);
                }
            });
        }
    }
}
