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
		$cntUsers = rand(30, 50);

		for($i=0; $i<$cntUsers; $i++)
		{
			DB::table('users')->insert([
				'name' => Str::random(18),
				'grade' => rand(1, 9),
				'email' => Str::random(20).'@test.com',
				'password' => Hash::make('password')
			]);
		}
		
		$cntProducts = rand(20, 40);
		for($i=0; $i<$cntProducts; $i++)
		{
			$price = rand(1, 300) * 100;

			$productNo = DB::table('products')->insertGetId([
				'user_register' => rand(1, $cntUsers),
				'title' => Str::random(50),
				'price' => $price,
				'inventory' => rand(10, 1000)
			]);
			
			$cntOrders = rand(-20, 5);

			for($j=0; $j<$cntOrders; $j++)
			{
				$qty = rand(1, 10);

				DB::table('orders')->insert([
					'user_buy' => rand(1, $cntUsers),
					'product_no' => $productNo,
					'qty' => $qty,
					'amt' => $price * $qty,
					'requirements' => Str::random(100)
				]);
			}
		}
    }
}