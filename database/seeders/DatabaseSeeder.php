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

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //setting admin in database
        User::create([
            'name' => 'admin',
            'phone' => "732002",
            'password' => bcrypt('password'),
            'role' => 1
        ]);

        $this->call([
            CategorySeeder::class
        ]);

        Medicine::factory(5)->create([
            'category_id' => 1
        ]);

        StatusMedicine::factory(2)->create([
            'medicine_id' =>1
        ]);
    }
}
