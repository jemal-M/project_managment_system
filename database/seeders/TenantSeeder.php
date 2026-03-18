<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users with 'tenant' role
        $tenantUsers = User::where('role', 'tenant')->get();

        if ($tenantUsers->isEmpty()) {
            $this->command->info('No tenant users found. Please run UserSeeder first.');
            return;
        }

        foreach ($tenantUsers as $user) {
            // Check if tenant already exists for this user
            $existingTenant = Tenant::where('user_id', $user->id)->first();
            
            if ($existingTenant) {
                continue;
            }

            Tenant::create([
                'user_id' => $user->id,
                'organization_id' => $user->organization_id,
                'id_number' => $this->generateIdNumber(),
                'address' => $this->generateAddress(),
            ]);
        }

        // Create additional tenants for occupied units
        $this->createAdditionalTenants();
    }

    /**
     * Generate a random ID number
     */
    private function generateIdNumber(): string
    {
        return rand(10000000, 99999999) . '';
    }

    /**
     * Generate a random address
     */
    private function generateAddress(): string
    {
        $streets = [
            'Main Street', 'Oak Avenue', 'Maple Drive', 'Pine Road', 
            'Cedar Lane', 'Elm Court', 'Park Boulevard', 'Lake View',
            'River Road', 'Hill Street', 'Valley Way', 'Sunset Drive'
        ];
        
        $cities = [
            'New York', 'Los Angeles', 'Chicago', 'Houston', 
            'Phoenix', 'Philadelphia', 'San Antonio', 'San Diego',
            'Dallas', 'San Jose', 'Austin', 'Jacksonville'
        ];
        
        $states = ['NY', 'CA', 'IL', 'TX', 'AZ', 'PA', 'TX', 'CA', 'TX', 'CA', 'TX', 'FL'];
        
        $streetNumber = rand(100, 9999);
        $street = $streets[array_rand($streets)];
        $city = $cities[array_rand($cities)];
        $state = $states[array_rand($states)];
        $zip = rand(10000, 99999);
        
        return "$streetNumber $street, $city, $state $zip";
    }

    /**
     * Create additional tenants for variety
     */
    private function createAdditionalTenants(): void
    {
        $organizations = Organization::all();

        foreach ($organizations as $organization) {
            // Create 3 additional tenants per organization
            $additionalTenants = [
                [
                    'name' => 'John Smith',
                    'email' => 'john.smith.' . strtolower(str_replace(' ', '', $organization->name)) . '@example.com',
                ],
                [
                    'name' => 'Sarah Johnson',
                    'email' => 'sarah.johnson.' . strtolower(str_replace(' ', '', $organization->name)) . '@example.com',
                ],
                [
                    'name' => 'Michael Brown',
                    'email' => 'michael.brown.' . strtolower(str_replace(' ', '', $organization->name)) . '@example.com',
                ],
            ];

            foreach ($additionalTenants as $tenantData) {
                // Check if user already exists
                $existingUser = User::where('email', $tenantData['email'])->first();
                
                if ($existingUser) {
                    // Create tenant record if user exists
                    if (!Tenant::where('user_id', $existingUser->id)->exists()) {
                        Tenant::create([
                            'user_id' => $existingUser->id,
                            'organization_id' => $organization->id,
                            'id_number' => $this->generateIdNumber(),
                            'address' => $this->generateAddress(),
                        ]);
                    }
                } else {
                    // Create new user and tenant
                    $user = User::create([
                        'name' => $tenantData['name'],
                        'email' => $tenantData['email'],
                        'password' => \Illuminate\Support\Facades\Hash::make('password'),
                        'organization_id' => $organization->id,
                        'role' => 'tenant',
                        'phone' => '+1-' . rand(200, 999) . '-' . rand(100, 999) . '-' . rand(1000, 9999),
                    ]);

                    Tenant::create([
                        'user_id' => $user->id,
                        'organization_id' => $organization->id,
                        'id_number' => $this->generateIdNumber(),
                        'address' => $this->generateAddress(),
                    ]);
                }
            }
        }
    }
}
