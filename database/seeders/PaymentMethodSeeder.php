<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PaymentMethodSeeder extends Seeder
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
            PaymentMethod::create([
                'name' => $faker->word,
                'is_active' => $faker->boolean(75),
            ]);
        }
    }
}
