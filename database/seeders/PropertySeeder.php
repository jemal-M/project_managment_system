<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Property;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = Organization::all();

        if ($organizations->isEmpty()) {
            $this->command->info('No organizations found. Please run OrganizationSeeder first.');

            return;
        }

        foreach ($organizations as $organization) {
            $this->createPropertiesForOrganization($organization);
        }
    }

    /**
     * Create properties for a specific organization
     */
    private function createPropertiesForOrganization($organization): void
    {
        $properties = $this->getPropertiesForOrganization($organization->name);

        foreach ($properties as $propertyData) {
            Property::create([
                'name' => $propertyData['name'],
                'organization_id' => $organization->id,
                'description' => $propertyData['description'],
                'type' => $propertyData['type'],
                'address' => $propertyData['address'],
                'total_units' => $propertyData['total_units'],
            ]);
        }
    }

    /**
     * Get properties based on organization name
     */
    private function getPropertiesForOrganization($orgName): array
    {
        $propertiesByOrg = [
            'Skyline Properties' => [
                [
                    'name' => 'Skyline Tower',
                    'description' => 'Luxury high-rise apartment building in downtown with stunning city views',
                    'type' => 'apartment',
                    'address' => '123 Downtown Ave, New York, NY 10001',
                    'total_units' => 50,
                ],
                [
                    'name' => 'Skyline Gardens',
                    'description' => 'Garden-style community with spacious units and outdoor amenities',
                    'type' => 'apartment',
                    'address' => '456 Garden Lane, New York, NY 10002',
                    'total_units' => 30,
                ],
                [
                    'name' => 'Skyline Plaza',
                    'description' => 'Mixed-use property with retail space and residential units',
                    'type' => 'mixed-use',
                    'address' => '789 Commerce St, New York, NY 10003',
                    'total_units' => 25,
                ],
            ],
            'Urban Living Spaces' => [
                [
                    'name' => 'Urban Heights',
                    'description' => 'Modern high-rise living with rooftop pool and fitness center',
                    'type' => 'apartment',
                    'address' => '456 Midtown Plaza, Los Angeles, CA 90001',
                    'total_units' => 75,
                ],
                [
                    'name' => 'Urban Lofts',
                    'description' => 'Industrial-style lofts with exposed brick and high ceilings',
                    'type' => 'loft',
                    'address' => '789 Arts District, Los Angeles, CA 90002',
                    'total_units' => 20,
                ],
            ],
            'Green Valley Realty' => [
                [
                    'name' => 'Green Valley Apartments',
                    'description' => 'Eco-friendly community with solar panels and recycling programs',
                    'type' => 'apartment',
                    'address' => '789 Garden Road, Chicago, IL 60601',
                    'total_units' => 40,
                ],
                [
                    'name' => 'Valley View Residences',
                    'description' => 'Scenic property with views of the Chicago skyline',
                    'type' => 'condo',
                    'address' => '321 Lake Shore Dr, Chicago, IL 60602',
                    'total_units' => 35,
                ],
                [
                    'name' => 'Green Park Townhomes',
                    'description' => 'Family-friendly townhomes near parks and schools',
                    'type' => 'townhouse',
                    'address' => '654 Park Ave, Chicago, IL 60603',
                    'total_units' => 15,
                ],
            ],
            'Coastal Homes Management' => [
                [
                    'name' => 'Oceanview Suites',
                    'description' => 'Beachfront property with ocean views and private balconies',
                    'type' => 'apartment',
                    'address' => '321 Beach Boulevard, Miami, FL 33101',
                    'total_units' => 45,
                ],
                [
                    'name' => 'Palm Bay Condos',
                    'description' => 'Luxury waterfront condos with marina access',
                    'type' => 'condo',
                    'address' => '654 Marina Way, Miami, FL 33102',
                    'total_units' => 30,
                ],
            ],
            'Metro Property Group' => [
                [
                    'name' => 'Metro Central',
                    'description' => 'Downtown property close to public transit and amenities',
                    'type' => 'apartment',
                    'address' => '654 Central Street, Seattle, WA 98101',
                    'total_units' => 60,
                ],
                [
                    'name' => 'Metro Commons',
                    'description' => 'Pet-friendly community with dog park and community spaces',
                    'type' => 'apartment',
                    'address' => '987 Community Lane, Seattle, WA 98102',
                    'total_units' => 25,
                ],
                [
                    'name' => 'Tech District Lofts',
                    'description' => 'Modern lofts near tech companies and startups',
                    'type' => 'loft',
                    'address' => '147 Innovation Blvd, Seattle, WA 98103',
                    'total_units' => 40,
                ],
            ],
        ];

        // Return properties for the specific organization or default properties
        return $propertiesByOrg[$orgName] ?? [
            [
                'name' => $orgName.' Main Property',
                'description' => 'Primary property for '.$orgName,
                'type' => 'apartment',
                'address' => '123 Main Street, City, State 12345',
                'total_units' => 20,
            ],
        ];
    }
}
