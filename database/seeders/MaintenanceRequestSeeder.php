<?php

namespace Database\Seeders;

use App\Models\MaintenanceRequest;
use App\Models\Tenant;
use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MaintenanceRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = Unit::all();

        if ($units->isEmpty()) {
            $this->command->info('No units found. Please run UnitSeeder first.');
            return;
        }

        $tenants = Tenant::all();

        // Create maintenance requests for various units
        $maintenanceTypes = $this->getMaintenanceTypes();

        // Create 3-5 maintenance requests per organization
        $organizations = \App\Models\Organization::all();

        foreach ($organizations as $organization) {
            $orgUnits = $units->filter(function ($unit) use ($organization) {
                return $unit->property->organization_id === $organization->id;
            });

            if ($orgUnits->isEmpty()) {
                continue;
            }

            // Create random maintenance requests
            $requestCount = rand(3, 8);

            for ($i = 0; $i < $requestCount; $i++) {
                $unit = $orgUnits->random();
                $maintenanceType = $maintenanceTypes[array_rand($maintenanceTypes)];
                
                // Get a random tenant for this unit (or any tenant from same organization)
                $orgTenants = $tenants->filter(function ($tenant) use ($organization) {
                    return $tenant->organization_id === $organization->id;
                });
                
                $tenant = $orgTenants->isNotEmpty() ? $orgTenants->random() : null;

                if (!$tenant) {
                    continue;
                }

                // Determine status and dates
                $status = $this->determineStatus();
                $requestedAt = $this->generateRequestedDate();
                $completedAt = null;

                if (in_array($status, ['completed', 'cancelled'])) {
                    $completedAt = $requestedAt->copy()->addDays(rand(1, 14));
                }

                MaintenanceRequest::create([
                    'unit_id' => $unit->id,
                    'tenant_id' => $tenant->id,
                    'title' => $maintenanceType['title'],
                    'description' => $maintenanceType['description'],
                    'requested_at' => $requestedAt,
                    'completed_at' => $completedAt,
                    'status' => $status,
                ]);
            }
        }
    }

    /**
     * Get maintenance request types
     */
    private function getMaintenanceTypes(): array
    {
        return [
            [
                'title' => 'Leaking Faucet',
                'description' => 'The kitchen faucet is leaking continuously. Water is dripping from the base.',
            ],
            [
                'title' => 'Broken HVAC System',
                'description' => 'Air conditioning unit is not cooling properly. Temperature remains high despite setting.',
            ],
            [
                'title' => 'Electrical Issue',
                'description' => 'Several outlets in the living room are not working. Circuit breaker keeps tripping.',
            ],
            [
                'title' => 'Plumbing Clog',
                'description' => 'Bathroom sink is draining very slowly. Have tried using drain cleaner without success.',
            ],
            [
                'title' => 'Broken Window',
                'description' => 'Window in bedroom has cracked glass. Needs replacement.',
            ],
            [
                'title' => 'Pest Control',
                'description' => 'Signs of mice in kitchen area. Droppings found near cabinets.',
            ],
            [
                'title' => 'Appliance Repair',
                'description' => 'Dishwasher not draining properly after cycle completes.',
            ],
            [
                'title' => 'Paint Touch-up',
                'description' => 'Wall paint in hallway is peeling. Needs repainting.',
            ],
            [
                'title' => 'Lock Repair',
                'description' => 'Front door lock is sticking. Difficult to open and close.',
            ],
            [
                'title' => 'Light Fixture Replacement',
                'description' => 'Ceiling light in dining area stopped working. Bulb replacement did not help.',
            ],
            [
                'title' => 'Flooring Repair',
                'description' => 'Hardwood floor in living room has several scratches and one board is creaking.',
            ],
            [
                'title' => 'Smoke Detector',
                'description' => 'Smoke detector beeping intermittently. Battery replacement did not resolve.',
            ],
        ];
    }

    /**
     * Determine maintenance request status
     */
    private function determineStatus(): string
    {
        $weights = [
            'pending' => 20,
            'in_progress' => 25,
            'completed' => 40,
            'cancelled' => 15,
        ];

        $random = rand(1, 100);
        $cumulative = 0;

        foreach ($weights as $status => $weight) {
            $cumulative += $weight;
            if ($random <= $cumulative) {
                return $status;
            }
        }

        return 'pending';
    }

    /**
     * Generate a random requested date within the past months
     */
    private function generateRequestedDate(): Carbon
    {
        $daysAgo = rand(1, 90);
        return Carbon::now()->subDays($daysAgo);
    }
}
