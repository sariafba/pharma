<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Medicine;
use App\Models\StatusMedicine;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        //setting admin in database
        User::create([
            'name' => 'admin',
            'phone' => "0977",
            'password' => bcrypt('password'),
            'role' => 1
        ]);

        $this->call([
            CategorySeeder::class
        ]);

        Medicine::factory(5)->create([
            'category_id' => 1,
            'category_id' => 5
        ]);

        StatusMedicine::factory(2)->create([
            'medicine_id' =>1,
            'medicine_id' =>2
        ]);
    }
}
