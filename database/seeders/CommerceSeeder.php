<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CommerceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cntUsers = rand(200, 300);

        for($i=0; $i<$cntUsers; $i++)
        {
            DB::table('users')->insert([
                'name' => Str::random(18),
                'grade' => rand(1, 9),
                'email' => Str::random(20).'@test.com',
                'password' => Hash::make('password')
            ]);
        }

        $cntProducts = rand(30, 60);
        for($i=0; $i<$cntProducts; $i++)
        {
            // Product
            $price = rand(1, 300) * 100;

            $productId = DB::table('products')->insertGetId([
                'user_register' => rand(1, $cntUsers),
                'title' => Str::random(50),
                'price' => $price,
                'inventory' => rand(10, 1000)
            ]);

            // Product Register Fee
            DB::table('fees')->insertGetId([
                'memo' => Str::random(rand(50, 150)),
                'amt' => 100,
                'billed_id' => $productId,
                'billed_type' => 'App\Models\Product'
            ]);

            // Order
            $cntOrders = rand(-16, 4);

            for($j=0; $j<$cntOrders; $j++)
            {
                $qty = rand(1, 10);

                $orderId = DB::table('orders')->insertGetId([
                    'user_buy' => rand(1, $cntUsers),
                    'product_id' => $productId,
                    'qty' => $qty,
                    'amt' => $price * $qty,
                    'requirements' => Str::random(100)
                ]);

                // Selling Fee
                DB::table('fees')->insertGetId([
                    'memo' => Str::random(rand(50, 150)),
                    'amt' => floor($price * $qty * 0.05),
                    'billed_id' => $orderId,
                    'billed_type' => 'App\Models\Order'
                ]);
            }
        }
    }
}
