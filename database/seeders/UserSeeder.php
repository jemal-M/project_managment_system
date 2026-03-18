<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = Organization::all();

        // If no organizations exist, create a default one with admin user
        if ($organizations->isEmpty()) {
            $organization = Organization::create([
                'name' => 'Default Organization',
                'email' => 'admin@default.com',
                'phone' => '+1-555-0100',
                'address' => '123 Main Street, City, Country',
                'website' => 'https://default.com',
            ]);

            $this->createUsersForOrganization($organization);
            return;
        }

        // Create users for each organization
        foreach ($organizations as $organization) {
            $this->createUsersForOrganization($organization);
        }
    }

    /**
     * Create users for a specific organization
     */
    private function createUsersForOrganization($organization): void
    {
        // Create Admin user
        User::create([
            'name' => $organization->name . ' Admin',
            'email' => strtolower(str_replace(' ', '', $organization->name)) . '@example.com',
            'password' => Hash::make('password'),
            'organization_id' => $organization->id,
            'role' => 'admin',
            'phone' => $this->generatePhoneNumber(),
        ]);

        // Create Manager user
        User::create([
            'name' => $organization->name . ' Manager',
            'email' => strtolower(str_replace(' ', '', $organization->name)) . '.manager@example.com',
            'password' => Hash::make('password'),
            'organization_id' => $organization->id,
            'role' => 'manager',
            'phone' => $this->generatePhoneNumber(),
        ]);

        // Create Tenant user
        User::create([
            'name' => $organization->name . ' Tenant',
            'email' => strtolower(str_replace(' ', '', $organization->name)) . '.tenant@example.com',
            'password' => Hash::make('password'),
            'organization_id' => $organization->id,
            'role' => 'tenant',
            'phone' => $this->generatePhoneNumber(),
        ]);

        // Create additional staff users (2 more)
        $staffNames = [
            'Property Manager',
            'Maintenance Staff',
            'Accountant',
            'Leasing Agent',
        ];

        foreach ($staffNames as $index => $staffName) {
            User::create([
                'name' => $organization->name . ' ' . $staffName,
                'email' => strtolower(str_replace(' ', '', $organization->name)) . '.' . strtolower(str_replace(' ', '', $staffName)) . '@example.com',
                'password' => Hash::make('password'),
                'organization_id' => $organization->id,
                'role' => 'manager',
                'phone' => $this->generatePhoneNumber(),
            ]);
        }
    }

    /**
     * Generate a random phone number
     */
    private function generatePhoneNumber(): string
    {
        $prefixes = ['+1', '+44', '+254', '+91', '+86', '+49'];
        $prefix = $prefixes[array_rand($prefixes)];
        
        return $prefix . '-' . rand(100, 999) . '-' . rand(100, 999) . '-' . rand(1000, 9999);
    }
}
