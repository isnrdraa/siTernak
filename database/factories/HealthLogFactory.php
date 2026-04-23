<?php

namespace Database\Factories;

use App\Models\Cage;
use App\Models\HealthLog;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HealthLog>
 */
class HealthLogFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'cage_id' => Cage::factory(),
            'date' => fake()->dateTimeBetween('-30 days'),
            'type' => fake()->randomElement(['Vaccination', 'Treatment', 'Checkup', 'Disease']),
            'description' => fake()->sentence(),
            'treatment' => fake()->optional()->sentence(),
            'recorded_by' => User::factory(),
        ];
    }
}
