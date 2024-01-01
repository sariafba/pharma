<?php

namespace Database\Factories;

use App\Models\Medicine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StatusMedicine>
 */
class StatusMedicineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'expiration_date' => fake()->date(),
            'quantity' => fake()->numberBetween(0, 100),
            'report_quantity'=> fake()->numberBetween(0, 100)
        ];
    }
}
