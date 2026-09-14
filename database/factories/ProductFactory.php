<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sku' => $this->faker->unique()->bothify('SKU-####-####-####'),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'category' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'stock' => $this->faker->numberBetween(1, 100),
            'discountPercentage' => $this->faker->randomFloat(2, 0, 50),
            'thumbnail' => $this->faker->imageUrl(300, 300, 'products', true),
        ];
    }
}
