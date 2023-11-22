<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Heart medications',
            'Chest medications',
            'Digestive medications',
            'Urinary medications',
            'Antibiotics',
            'Analgesics',
            'Vitamins',
            'Anti hypertensives',
            'Antifungals',
            'Antibacterials',
        ];
        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category
            ]);
        }
    }
}
