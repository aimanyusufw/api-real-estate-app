<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agent>
 */
class AgentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $images = [
            "01J6PYEX1RVBZEN6H6TH3E6JS9.jpg",
            "01J6PYGBVC4RDQGG01118R8A7B.jpg",
            "AGENTS1.jpg",
            "AGENTS2.jpg",
            "AGENTS3.jpg",
            "AGENTS4.jpg",
            "AGENTS5.jpg",
            "AGENTS6.jpg",
        ];

        return [
            'name' => $this->faker->unique()->name('id_ID'),
            'phone' => $this->faker->phoneNumber('id_ID'),
            'profile_picture' => "agents/" . $images[array_rand($images)],
            'social_media_links' => [
                'facebook' => 'https://facebook.com/' . Str::slug($this->faker->userName()),
                'instagram' => 'https://instagram.com/' . Str::slug($this->faker->userName()),
                'linkedin' => 'https://linkedin.com/in/' . Str::slug($this->faker->userName()),
                'tiktok' => 'https://tiktok.com/' . Str::slug($this->faker->userName()),
                'twitter' => 'https://x.com/' . Str::slug($this->faker->userName()),
            ],
            'joined_date' => $this->faker->dateTimeBetween('-5 years', 'now'),
            'description' => $this->faker->sentence(),
            'total_property' => $this->faker->numberBetween(10, 100),
            'total_sold_property' => $this->faker->numberBetween(5, 50),
            'price_range_property' => (int)($this->faker->randomFloat(2, 100, 10000) * 10000),
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
