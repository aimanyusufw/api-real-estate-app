<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\Property;
use App\Models\PropertyLocation;
use App\Models\PropertyTypes;
use App\Models\PropertyTypeSale;
use Illuminate\Support\Str;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Agent::factory(10)->create();

        // Property locations seeder
        $locations = [
            'Jakarta',
            'Bandung',
            'Surabaya',
            'Medan',
            'Makassar',
            'Yogyakarta',
            'Denpasar',
            'Balikpapan',
            'Palembang',
            'Semarang'
        ];
        foreach ($locations as $location) {
            PropertyLocation::create([
                "name" => $location,
                "slug" => Str::slug($location),
                "description" => "The property is located in the city of $location, Indonesia. This city has good infrastructure and easy access to various public facilities.",
            ]);
        }

        // Property type seeder
        $types = [
            'House',
            'Apartment',
            'Villa',
            'Shop House',
            'Office',
        ];
        foreach ($types as $type) {
            PropertyTypes::create([
                "name" => $type,
                "slug" => Str::slug($type),
                "description" => "The building is intended for use as a $type, offering a variety of features and facilities.",
            ]);
        }


        // Property typesale seeder
        $typeSales = [
            'Cash',
            'Monthly',
            'Annualy',
        ];
        foreach ($typeSales as $typeSale) {
            PropertyTypeSale::create([
                "name" => $typeSale,
                "slug" => Str::slug($typeSale),
                "description" => "This property is available for $typeSale payment, providing flexible options for buyers depending on their financial plan.",
            ]);
        }

        Property::factory(50)->create();
    }
}
