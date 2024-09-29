<?php

namespace Database\Factories;

use App\Models\Agent;
use App\Models\PropertyLocation;
use App\Models\PropertyTypes;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $certificate = ['SHM', 'SHB', 'AJB', 'SHSRS'];

        $agent = Agent::inRandomOrder()->first();

        return [
            'title' => $this->faker->words(8, true),
            'slug' => Str::slug($this->faker->unique()->words(8, true)),
            'short_description' => $this->faker->sentence(),
            'price' => (int)($this->faker->randomFloat(2, 100, 10000) * 1000000),
            'specification' => [
                'bedroom' => $this->faker->numberBetween(1, 10),
                'bathroom' => $this->faker->numberBetween(1, 10),
                'land_area' => $this->faker->numberBetween(50, 500),
                'building_area' => $this->faker->numberBetween(50, 500),
                'electricity' => $this->faker->numberBetween(50, 500),
                'rent_period' => $this->faker->numberBetween(1, 12),
                'rent_period' => $this->faker->numberBetween(1, 12),
                'price_per_m2' => $this->faker->numberBetween(1, 12),
                'certificate' => $certificate[array_rand($certificate)],
            ],
            'description' => implode("\n\n", [
                "Here are some key highlights of this property:",
                "<ul>" .
                    "<li><strong>Spacious Living Area.</strong> " . $this->faker->sentence(12) . " The open layout allows for seamless flow between the living, dining, and kitchen areas, providing a perfect space for entertainment and relaxation;</li>" .
                    "<li><strong>Prime Location.</strong> " . $this->faker->sentence(10) . " Situated in a highly sought-after neighborhood, this property offers easy access to local amenities, schools, and public transportation;</li>" .
                    "<li><strong>Modern Amenities.</strong> " . $this->faker->sentence(10) . " Equipped with state-of-the-art appliances and smart home features, this property ensures convenience and luxury at every turn;</li>" .
                    "<li><strong>Outdoor Space.</strong> " . $this->faker->sentence(15) . " Enjoy the beautiful backyard, perfect for gardening, family gatherings, or simply relaxing under the sun.</li>" .
                    "</ul>",
                "<strong>Designed for Comfort and Style</strong>",
                "Before you even step inside, " . $this->faker->sentence(8) . ". The exterior design blends modern architecture with timeless elegance, creating an inviting atmosphere for you and your family.",
                "Let’s start by scheduling a viewing to fully appreciate the beauty and functionality of this property."
            ]),
            'thumbnail' => "property/house-" . rand(1, 16) . ".jpg",
            'galleries' => [
                [
                    "image" => "property/house-" . rand(1, 6) . ".jpg",
                ],
                [
                    "image" => "property/house-" . rand(1, 6) . ".jpg",
                ],
                [
                    "image" => "property/house-" . rand(1, 6) . ".jpg",
                ],
            ],
            'agent_id' => $agent,
            'property_location_id' => $this->faker->numberBetween(1, 10),
            'property_type_id' => $this->faker->numberBetween(1, 5),
            'description_title' => $this->faker->words(5, true),
        ];
    }
}
