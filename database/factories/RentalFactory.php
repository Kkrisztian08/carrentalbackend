<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rental>
 */
class RentalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "car_id"=>$this->faker->randomNumber(1,8),
            "start_date"=>Carbon::now()->subDays($this->faker->numberBetween(1,20)),
            "end_date"=>Carbon::now()->addDays($this->faker->numberBetween(1,5))
        ];
    }
}
