<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $parentId = null;
        if($this->faker->boolean() > 0 )
        {
            $parentId = Category::count() > 0
                ? Category::inRandomOrder()->first()->id
                : Category::factory()->create(['parent_id' => null])->id;
        }
        return [
            'title' => $this->faker->word,
            'parent_id' => $parentId
        ];
    }
}
