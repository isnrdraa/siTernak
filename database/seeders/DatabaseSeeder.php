<?php

namespace Database\Seeders;

use App\Enums\SubscriptionPlan;
use App\Enums\SubscriptionStatus;
use App\Models\Cage;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);

        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@siternak.com',
            'is_super_admin' => true,
        ]);

        $tenant = Tenant::create([
            'name' => 'Peternakan Sejahtera',
            'slug' => 'peternakan-sejahtera',
            'status' => 'active',
            'settings' => [],
        ]);

        Subscription::create([
            'tenant_id' => $tenant->id,
            'plan' => SubscriptionPlan::Free,
            'status' => SubscriptionStatus::Active,
            'starts_at' => now(),
        ]);

        $owner = User::factory()->create([
            'name' => 'Budi Santoso',
            'email' => 'owner@demo.com',
        ]);
        $tenant->users()->attach($owner, ['joined_at' => now()]);
        setPermissionsTeamId($tenant->id);
        $owner->assignRole('owner');

        $adminUser = User::factory()->create([
            'name' => 'Siti Aminah',
            'email' => 'admin@demo.com',
        ]);
        $tenant->users()->attach($adminUser, ['joined_at' => now()]);
        $adminUser->assignRole('admin');

        $supervisor = User::factory()->create([
            'name' => 'Ahmad Supervisor',
            'email' => 'supervisor@demo.com',
        ]);
        $tenant->users()->attach($supervisor, ['joined_at' => now()]);
        $supervisor->assignRole('supervisor');

        $staff = User::factory()->create([
            'name' => 'Dedi Staff',
            'email' => 'staff@demo.com',
        ]);
        $tenant->users()->attach($staff, ['joined_at' => now()]);
        $staff->assignRole('staff');

        Cage::create([
            'tenant_id' => $tenant->id,
            'name' => 'Kandang A1',
            'location' => 'Area Timur',
            'capacity' => 2000,
            'current_count' => 1750,
            'status' => 'active',
        ]);

        Cage::create([
            'tenant_id' => $tenant->id,
            'name' => 'Kandang A2',
            'location' => 'Area Barat',
            'capacity' => 1500,
            'current_count' => 1180,
            'status' => 'active',
        ]);

        Product::create([
            'tenant_id' => $tenant->id,
            'name' => 'Telur Ayam',
            'unit' => 'butir',
            'price_per_unit' => 2500,
            'is_active' => true,
        ]);

        Product::create([
            'tenant_id' => $tenant->id,
            'name' => 'Susu Segar',
            'unit' => 'liter',
            'price_per_unit' => 12000,
            'is_active' => true,
        ]);
    }
}
