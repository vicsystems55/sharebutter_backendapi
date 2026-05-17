<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS
        |--------------------------------------------------------------------------
        */

        $permissions = [

            // USERS
            'manage users',
            'view users',
            'suspend users',
            'delete users',

            // ROLES
            'manage roles',
            'manage permissions',

            // ORGANIZERS
            'approve organizers',
            'reject organizers',
            'suspend organizers',
            'view organizers',

            // EVENTS
            'create events',
            'edit own events',
            'delete own events',
            'publish events',
            'manage all events',
            'approve events',
            'reject events',
            'feature events',

            // BOOKINGS
            'buy tickets',
            'manage bookings',
            'view bookings',
            'checkin attendees',
            'cancel bookings',

            // REVIEWS
            'leave reviews',
            'moderate reviews',

            // WALLET
            'view wallet',
            'manage wallet',
            'credit wallet',
            'debit wallet',

            // PAYOUTS
            'request payout',
            'approve payout',
            'reject payout',
            'view payouts',

            // MARKETPLACE
            'manage marketplace',
            'manage vendors',
            'approve vendors',

            // ANALYTICS
            'view analytics',

            // SUPPORT
            'manage support',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | ROLES
        |--------------------------------------------------------------------------
        */

        $superAdmin = Role::firstOrCreate([
            'name' => 'super-admin',
            'guard_name' => 'web',
        ]);

        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $organizer = Role::firstOrCreate([
            'name' => 'organizer',
            'guard_name' => 'web',
        ]);

        $attendee = Role::firstOrCreate([
            'name' => 'attendee',
            'guard_name' => 'web',
        ]);

        $vendor = Role::firstOrCreate([
            'name' => 'vendor',
            'guard_name' => 'web',
        ]);

        $support = Role::firstOrCreate([
            'name' => 'support',
            'guard_name' => 'web',
        ]);

        /*
        |--------------------------------------------------------------------------
        | ASSIGN PERMISSIONS
        |--------------------------------------------------------------------------
        */

        // Super admin gets everything
        $superAdmin->givePermissionTo(Permission::all());

        // Admin
        $admin->givePermissionTo([
            'manage users',
            'view users',
            'suspend users',

            'approve organizers',
            'reject organizers',
            'suspend organizers',
            'view organizers',

            'manage all events',
            'approve events',
            'reject events',
            'feature events',

            'manage bookings',
            'view bookings',

            'moderate reviews',

            'approve payout',
            'reject payout',
            'view payouts',

            'manage marketplace',
            'manage vendors',
            'approve vendors',

            'view analytics',

            'manage support',
        ]);

        // Organizer
        $organizer->givePermissionTo([
            'create events',
            'edit own events',
            'delete own events',
            'publish events',

            'manage bookings',
            'view bookings',
            'checkin attendees',

            'view wallet',
            'request payout',

            'view analytics',
        ]);

        // Attendee
        $attendee->givePermissionTo([
            'buy tickets',
            'view bookings',
            'cancel bookings',

            'view wallet',

            'leave reviews',
        ]);

        // Vendor
        $vendor->givePermissionTo([
            'manage marketplace',
            'view wallet',
            'request payout',
        ]);

        // Support
        $support->givePermissionTo([
            'view users',
            'view organizers',
            'view bookings',
            'manage support',
        ]);
    }
}
