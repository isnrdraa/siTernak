<?php

namespace Database\Factories;

use App\Models\Cage;
use App\Models\FeedLog;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FeedLog>
 */
class FeedLogFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'cage_id' => Cage::factory(),
            'date' => fake()->dateTimeBetween('-30 days'),
            'feed_type' => fake()->randomElement(['Layer Feed', 'Grower Feed', 'Starter Feed', 'Concentrate']),
            'quantity_kg' => fake()->randomFloat(2, 10, 500),
            'recorded_by' => User::factory(),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
