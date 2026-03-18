<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $properties = Property::all();

        if ($properties->isEmpty()) {
            $this->command->info('No properties found. Please run PropertySeeder first.');
            return;
        }

        foreach ($properties as $property) {
            $this->createUnitsForProperty($property);
        }
    }

    /**
     * Create units for a specific property
     */
    private function createUnitsForProperty($property): void
    {
        $unitCount = $property->total_units;
        
        // Determine rent range based on property type
        $rentRange = $this->getRentRangeByType($property->type);
        
        for ($i = 1; $i <= $unitCount; $i++) {
            $floor = floor(($i - 1) / 5) + 1;
            $unitNumber = $floor . str_pad($i, 2, '0', STR_PAD_LEFT);
            
            // Determine status - some available, some occupied
            $status = $this->determineUnitStatus($i, $unitCount);
            
            Unit::create([
                'property_id' => $property->id,
                'name' => 'Unit ' . $unitNumber,
                'rent_amount' => rand($rentRange['min'], $rentRange['max']),
                'status' => $status,
            ]);
        }
    }

    /**
     * Get rent range based on property type
     */
    private function getRentRangeByType($type): array
    {
        $ranges = [
            'apartment' => ['min' => 1200, 'max' => 3000],
            'condo' => ['min' => 1800, 'max' => 4000],
            'townhouse' => ['min' => 2000, 'max' => 4500],
            'loft' => ['min' => 1500, 'max' => 3500],
            'mixed-use' => ['min' => 1000, 'max' => 2500],
        ];

        return $ranges[$type] ?? ['min' => 1000, 'max' => 2500];
    }

    /**
     * Determine unit status based on position
     */
    private function determineUnitStatus($index, $total): string
    {
        // First 20% available, 70% occupied, 10% maintenance
        $position = $index / $total;
        
        if ($position <= 0.2) {
            return 'available';
        } elseif ($position <= 0.9) {
            return 'occupied';
        } else {
            return 'maintenance';
        }
    }
}
