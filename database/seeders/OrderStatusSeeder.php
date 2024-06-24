<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(OrderStatus::$statuses as $key => $value){
            OrderStatus::firstOrCreate([
                'id' => $key,
                'name' => $value,
                'icon' =>  OrderStatus::$icons[$key],
                'color' => OrderStatus::$colors[$key],
            ]);
        }
    }
}
