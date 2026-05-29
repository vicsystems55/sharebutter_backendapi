<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create superadmin role if it doesn't exist
        $role = Role::firstOrCreate(['name' => 'superadmin']);

        // Create or update default admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@eventoga.ng'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('PassEvent@2026'),
            ]
        );

        // Assign the superadmin role
        if (! $admin->hasRole('superadmin')) {
            $admin->assignRole($role);
        }
    }
}
