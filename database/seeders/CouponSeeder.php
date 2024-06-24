<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1, 20) as $index) {
            Coupon::create([
                'code' => $faker->randomNumber(6),
                'percentage' => rand(0, 100),
                'description' => $faker->sentence(rand(6, 10)),
                'is_active' => $faker->boolean(75),
            ]);
        }
    }
}