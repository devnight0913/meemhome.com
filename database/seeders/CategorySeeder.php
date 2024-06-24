<?php

namespace Database\Seeders;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1, 5) as $index) {
            Category::create([
                'name' => $faker->sentence(rand(1, 3)),
                'sort_order' => $faker->randomNumber(1),
                'status_id' => 1,
            ]);
        }
    }
}
