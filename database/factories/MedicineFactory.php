<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicine>
 */
class MedicineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'commercial_name' => fake()->name(),
            'scientific_name' => fake()->name(),
            'manufacture_company' => fake()->name(),
            'price' => fake()->numberBetween(1,20),
            'category_id' => Category::factory()

        ];
    }
}
