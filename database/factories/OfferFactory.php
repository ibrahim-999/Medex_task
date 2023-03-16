<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'start_date' =>$this->faker->date('Y-m-d H:00'),
            'end_date' => $this->faker->date('Y-m-d H:00'),
        ];
    }

    public function isValid() : OfferFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'start_date' => Carbon::now()->subDay(),
                'end_date' => Carbon::now()->addDay(),
            ];
        });
    }

    public function isInValid() : OfferFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'start_date' => Carbon::now()->subDays(2),
                'end_date' => Carbon::now()->subDay(),
            ];
        });
    }
}
