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
            'commercial_name' => fake()->firstName,
            'scientific_name' => fake()->word(),
            'manufacture_company' => fake()->word(),
            'price' => fake()->numberBetween(1,20),
            'category_id' => Category::factory(),
          'image' => fake()->randomElement(['public/storage/photo/img_fever.png'])
        ];

    }
}
