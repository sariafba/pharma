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
            'phone' => '0912345678',
            'password' => bcrypt('password'),
            'role' => 1
        ]);

        User::factory(1)->create([
            'phone' => '0943946262'
        ]);

        $this->call([
            CategorySeeder::class
        ]);

        Medicine::factory(5)->create([
            'category_id' => 1
        ]);

        for ($i=1; $i<=5; $i++)
        {
            StatusMedicine::factory(5)->create([
                'medicine_id' => $i
            ]);

            Medicine::find($i)->update([
                'quantity' => StatusMedicine::where('medicine_id', $i)->sum('quantity')
            ]);
        }
        for ($i=1; $i<=5; $i++){
            Cart::create([
                'medicine_id' => $i,
                'user_id' => 2,
                'quantity' => 1,
                'total_price' => Medicine::find($i)->price
            ]);
        }

    }
}
