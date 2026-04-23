<?php

namespace Database\Factories;

use App\Enums\CageStatus;
use App\Models\Cage;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cage>
 */
class CageFactory extends Factory
{
    public function definition(): array
    {
        $capacity = fake()->numberBetween(100, 5000);

        return [
            'tenant_id' => Tenant::factory(),
            'name' => 'Kandang '.fake()->randomLetter().fake()->numerify('##'),
            'location' => fake()->optional()->city(),
            'capacity' => $capacity,
            'current_count' => fake()->numberBetween(0, $capacity),
            'status' => CageStatus::Active,
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
