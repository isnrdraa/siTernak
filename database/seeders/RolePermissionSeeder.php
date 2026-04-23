<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage-tenant-settings',
            'view-tenant-settings',
            'manage-members',
            'invite-members',
            'view-members',
            'manage-cages',
            'view-cages',
            'create-production',
            'view-production',
            'validate-production',
            'create-feed-log',
            'view-feed-log',
            'create-health-log',
            'view-health-log',
            'create-mortality-log',
            'view-mortality-log',
            'manage-feed-stock',
            'view-feed-stock',
            'create-feed-purchase',
            'manage-products',
            'view-products',
            'create-sale',
            'view-sales',
            'create-livestock-sale',
            'view-livestock-sales',
            'create-expense',
            'view-expenses',
            'view-finance',
            'view-reports',
            'export-reports',
            'view-dashboard',
            'view-audit-log',
        ];

        foreach ($permissions as $permissionName) {
            Permission::create(['name' => $permissionName, 'guard_name' => 'web']);
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $owner = Role::create(['name' => 'owner', 'guard_name' => 'web']);
        $owner->givePermissionTo($permissions);

        $adminPermissions = collect($permissions)->reject(
            fn (string $p) => $p === 'manage-tenant-settings'
        )->values()->all();
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $admin->givePermissionTo($adminPermissions);

        $supervisorPermissions = [
            'view-tenant-settings',
            'view-members',
            'view-cages',
            'manage-cages',
            'create-production',
            'view-production',
            'validate-production',
            'create-feed-log',
            'view-feed-log',
            'create-health-log',
            'view-health-log',
            'create-mortality-log',
            'view-mortality-log',
            'view-feed-stock',
            'create-feed-purchase',
            'view-products',
            'create-sale',
            'view-sales',
            'create-livestock-sale',
            'view-livestock-sales',
            'create-expense',
            'view-expenses',
            'view-finance',
            'view-reports',
            'view-dashboard',
            'view-audit-log',
        ];
        $supervisor = Role::create(['name' => 'supervisor', 'guard_name' => 'web']);
        $supervisor->givePermissionTo($supervisorPermissions);

        $staffPermissions = [
            'view-cages',
            'create-production',
            'view-production',
            'create-feed-log',
            'view-feed-log',
            'create-health-log',
            'view-health-log',
            'create-mortality-log',
            'view-mortality-log',
            'view-feed-stock',
            'view-products',
            'create-sale',
            'view-sales',
            'create-livestock-sale',
            'view-livestock-sales',
            'view-dashboard',
        ];
        $staff = Role::create(['name' => 'staff', 'guard_name' => 'web']);
        $staff->givePermissionTo($staffPermissions);
    }
}
