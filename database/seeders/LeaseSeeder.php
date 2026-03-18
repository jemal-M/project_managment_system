<?php

namespace Database\Seeders;

use App\Models\Lease;
use App\Models\Tenant;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LeaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenants = Tenant::all();

        if ($tenants->isEmpty()) {
            $this->command->info('No tenants found. Please run TenantSeeder first.');

            return;
        }

        // Get occupied units to create leases for
        $occupiedUnits = Unit::where('status', 'occupied')->get();

        if ($occupiedUnits->isEmpty()) {
            $this->command->info('No occupied units found. Please run UnitSeeder first.');

            return;
        }

        foreach ($occupiedUnits as $index => $unit) {
            // Find a tenant for this unit (distribute tenants across units)
            $tenantIndex = $index % $tenants->count();
            $tenant = $tenants[$tenantIndex];

            // Check if lease already exists for this unit
            $existingLease = Lease::where('unit_id', $unit->id)
                ->where('status', 'active')
                ->first();

            if ($existingLease) {
                continue;
            }

            // Create lease with realistic dates
            $startDate = $this->generateStartDate();
            $endDate = $startDate->copy()->addMonths(rand(6, 18));
            $rentAmount = $unit->rent_amount;

            // Determine status based on end date
            $status = $this->determineLeaseStatus($endDate);

            Lease::create([
                'unit_id' => $unit->id,
                'tenant_id' => $tenant->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'rent_amount' => $rentAmount,
                'status' => $status,
            ]);
        }

        // Create some expired leases for variety
        $this->createExpiredLeases($tenants);
    }

    /**
     * Generate a realistic lease start date
     */
    private function generateStartDate(): Carbon
    {
        $monthsAgo = rand(1, 24);

        return Carbon::now()->subMonths($monthsAgo)->startOfMonth();
    }

    /**
     * Determine lease status based on end date
     */
    private function determineLeaseStatus(Carbon $endDate): string
    {
        if ($endDate->isPast()) {
            return 'expired';
        } elseif ($endDate->diffInMonths(Carbon::now()) <= 2) {
            return 'expiring_soon';
        } else {
            return 'active';
        }
    }

    /**
     * Create some expired leases for variety
     */
    private function createExpiredLeases($tenants): void
    {
        // Create 5 expired leases
        $occupiedUnits = Unit::where('status', 'occupied')->limit(5)->get();
        $unitIndex = 0;

        foreach ($tenants->take(5) as $tenant) {
            if ($occupiedUnits->isEmpty()) {
                break;
            }

            $unit = $occupiedUnits[$unitIndex % $occupiedUnits->count()];

            // Check if lease already exists
            if (Lease::where('unit_id', $unit->id)->exists()) {
                $unitIndex++;

                continue;
            }

            // Create expired lease
            $startDate = Carbon::now()->subYears(2)->startOfMonth();
            $endDate = Carbon::now()->subYear(1)->endOfMonth();

            Lease::create([
                'unit_id' => $unit->id,
                'tenant_id' => $tenant->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'rent_amount' => $unit->rent_amount,
                'status' => 'expired',
            ]);

            $unitIndex++;
        }
    }
}
