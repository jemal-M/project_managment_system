<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * Order of seeders is critical due to dependencies:
     * 1. OrganizationSeeder - Base entity with no dependencies
     * 2. PropertySeeder - Belongs to organization
     * 3. UnitSeeder - Belongs to property
     * 4. UserSeeder - Users for organizations (includes admin, manager, tenant roles)
     * 5. TenantSeeder - Linked to users
     * 6. LeaseSeeder - Links tenants to units
     * 7. PaymentSeeder - Links to leases and tenants
     * 8. MaintenanceRequestSeeder - Links to units and tenants
     */
    public function run(): void
    {
        $this->call([
            OrganizationSeeder::class,
            PropertySeeder::class,
            UnitSeeder::class,
            UserSeeder::class,
            TenantSeeder::class,
            LeaseSeeder::class,
            PaymentSeeder::class,
            MaintenanceRequestSeeder::class,
        ]);
    }
}
