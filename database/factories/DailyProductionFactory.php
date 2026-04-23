<?php

namespace Database\Factories;

use App\Models\Cage;
use App\Models\DailyProduction;
use App\Models\Product;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DailyProduction>
 */
class DailyProductionFactory extends Factory
{
    public function definition(): array
    {
        $quantity = fake()->randomFloat(2, 10, 2000);

        return [
            'tenant_id' => Tenant::factory(),
            'cage_id' => Cage::factory(),
            'product_id' => Product::factory(),
            'date' => fake()->dateTimeBetween('-30 days'),
            'quantity' => $quantity,
            'damaged_count' => fake()->randomFloat(2, 0, $quantity * 0.05),
            'recorded_by' => User::factory(),
            'validated_by' => null,
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
