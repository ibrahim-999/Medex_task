<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
            'name' => $this->faker->title,
            'barcode' => $this->faker->randomNumber(),
            'short_description' => $this->faker->text,
            'long_description' => $this->faker->name,
            'subcategory_id' => Category::newFactory(),
            'brand_id' => Brand::newFactory(),
            'price' => $this->faker->numberBetween(1000, 2000),
            'quantity' => $this->faker->numberBetween(10, 20),
            'published_at' => $this->faker->dateTime
        ];
    }
}
