<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $randomDate = $this->faker->dateTimeBetween('2023-06-01', '2023-11-30')->format('Y-m-d H:i:s');

        return [
            'name' => $this->faker->company,
            'type' => $this->faker->randomElement(['Trial', 'Standard', 'Premium', 'Business']),
            'created_at' => $randomDate,
        ];
    }
}
