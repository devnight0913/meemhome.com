<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1, 50) as $index) {
            $has_discount = $faker->boolean(15);

            $price = rand(5, 300);

            $item = Item::create([
                'name' => $faker->sentence(rand(6, 20)),

                'description' => $faker->sentence(rand(300, 400)),

                'price' => $price,

                'cost' => rand(1, $price - 3),

                'discount' => $has_discount ? rand(1, 10) : 0,

                'category_id' => Category::inRandomOrder()->first()->id,

                'status_id' => 1,

                'in_stock' => rand(0, 200),

                'views' => rand(1, 10000),

                'sku' => $faker->unique()->randomNumber,
                'barcode' => $faker->unique()->randomNumber,
                'code' =>  $faker->unique()->randomNumber,
                'serial_number' =>  $faker->unique()->randomNumber,

                'pos' =>  $faker->boolean(),
                'website' =>  true,
                'android_app' =>  $faker->boolean(),
                'ios_app' =>  $faker->boolean(),

                'track_stock' => $faker->boolean(75),
                'continue_selling_when_out_of_stock' => $faker->boolean(75),


            ]);

            // foreach (range(1, 50) as $index) {
            //     $review = new Review();
            //     $review->item_id = $item->id;
            //     $review->user_id = User::first()->id;
            //     $review->comment = $faker->sentence(rand(300, 400));
            //     $review->rating = rand(0, 5);
            //     $review->save();
            // }
        }
    }
}
