<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = [
            [
                'name' => 'Skyline Properties',
                'email' => 'contact@skylineproperties.com',
                'phone' => '+1-555-0100',
                'address' => '123 Downtown Ave, New York, NY 10001',
                'website' => 'https://skylineproperties.com',
            ],
            [
                'name' => 'Urban Living Spaces',
                'email' => 'info@urbanliving.com',
                'phone' => '+1-555-0200',
                'address' => '456 Midtown Plaza, Los Angeles, CA 90001',
                'website' => 'https://urbanliving.com',
            ],
            [
                'name' => 'Green Valley Realty',
                'email' => 'hello@greenvalleyrealty.com',
                'phone' => '+1-555-0300',
                'address' => '789 Garden Road, Chicago, IL 60601',
                'website' => 'https://greenvalleyrealty.com',
            ],
            [
                'name' => 'Coastal Homes Management',
                'email' => 'support@coastalhomes.com',
                'phone' => '+1-555-0400',
                'address' => '321 Beach Boulevard, Miami, FL 33101',
                'website' => 'https://coastalhomes.com',
            ],
            [
                'name' => 'Metro Property Group',
                'email' => 'admin@metroproperty.com',
                'phone' => '+1-555-0500',
                'address' => '654 Central Street, Seattle, WA 98101',
                'website' => 'https://metroproperty.com',
            ],
            [
                'name' => 'Mountain View Estates',
                'email' => 'realestate@mountainview.com',
                'phone' => '+1-555-0600',
                'address' => '987 Summit Lane, Denver, CO 80201',
                'website' => 'https://mountainview.com',
            ],
            [
                'name' => 'Riverside Development Corp',
                'email' => 'info@riversidedevelopment.com',
                'phone' => '+1-555-0700',
                'address' => '147 Riverfront Drive, Portland, OR 97201',
                'website' => 'https://riversidedevelopment.com',
            ],
        ];

        foreach ($organizations as $organization) {
            Organization::create($organization);
        }
    }
}
