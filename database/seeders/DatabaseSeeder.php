<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Cart;
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
            'phone' => "0943946262",
            'password' => bcrypt('password'),
            'role' => 1
        ]);

        User::factory(5)->create();

        $this->call([
            CategorySeeder::class
        ]);

        Medicine::factory(10)->create([
            'category_id' => 1
        ]);

        StatusMedicine::factory(2)->create([
            'medicine_id' =>1
        ]);

        for ($i=1; $i<=5; $i++){
            Cart::create([
                'medicine_id' => $i,
                'user_id' => 2
            ]);
        }

    }
}
