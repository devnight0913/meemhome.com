<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Services\OffersCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionSeeder::class); // don't remove
        $this->call(UserSeeder::class); // don't remove
        $this->call(SettingsSeeder::class); // don't remove
        $this->call(OrderSourceSeeder::class); // don't remove
        $this->call(OrderStatusSeeder::class); // don't remove

        if (App::environment('local')) {
            $this->call(CategorySeeder::class);
            $this->call(ItemSeeder::class);
            $this->call(AreaSeeder::class);
            $this->call(CouponSeeder::class);
            $this->call(PaymentMethodSeeder::class);
            $this->call(OrderSeeder::class);
        }
    }
}
