<?php

namespace Database\Seeders;

use App\Models\OrderSource;
use Illuminate\Database\Seeder;

class OrderSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(OrderSource::$sources as $key => $value){
            OrderSource::firstOrCreate([
                'id' => $key,
                'name' => $value,
                'icon' => OrderSource::$icons[$key],
            ]);
        }
    }
}
