<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AreaSeeder extends Seeder
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
            Area::create([
                'name' => $faker->city,
                'fee' => $faker->randomDigit,
                'time' => $faker->randomNumber(2),
                'is_active' => true,
            ]);
        }
    }
}
