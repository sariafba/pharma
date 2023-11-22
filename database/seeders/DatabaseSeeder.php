<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Medicine;
use App\Models\StatusMedicine;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::factory(5)->create();
        Medicine::factory(5)->create([
            'category_id' => 1
        ]);
        StatusMedicine::factory(2)->create([
            'medicine_id' =>1
        ]);
    }
}
