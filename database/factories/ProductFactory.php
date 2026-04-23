<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'name' => fake()->randomElement(['Telur Ayam', 'Susu Segar', 'Daging', 'Madu']),
            'unit' => fake()->randomElement(['butir', 'liter', 'kg', 'gram']),
            'price_per_unit' => fake()->randomFloat(2, 1000, 50000),
            'is_active' => true,
        ];
    }
}
