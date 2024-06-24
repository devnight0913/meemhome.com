<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Coupon;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
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
            $order = new Order();
            $isDelivery = $faker->boolean();
            $hasUser = $faker->boolean();
            $hasCoupon = $faker->boolean();
            $deliveryFee = 0;
            $discount = 0;
            $subtotal = 0;

            $orderId = Str::uuid()->toString();
            $order->id = $orderId;
            $order->number = rand(999999, 9999999);
            if ($hasUser) {
                $user = User::inRandomOrder()->first();
                $order->user_id =  $user->id;
                $order->name = $user->name;
                $order->email = $user->email;
                $order->phone = $faker->phoneNumber();
            } else {
                $order->name = $faker->name();
                $order->email = $faker->email();
                $order->phone = $faker->phoneNumber();
            }

            $order->is_delivery = $isDelivery;

            if ($isDelivery) {
                $area = Area::inRandomOrder()->first();
                $order->area_id = $area->id;
                $deliveryFee = $area->fee;
                $order->address = $faker->address();
            }

            $order->payment_method_id =  PaymentMethod::inRandomOrder()->first()->id;

            if ($hasCoupon) {
                $coupon = Coupon::inRandomOrder()->first();
                $order->coupon_id = $coupon->id;

                if ($coupon->percentage > 0) {
                    $discount = (($coupon->percentage / 100) * $subtotal);
                }
            }
            $order->comment = $faker->boolean() ? $faker->paragraph() : null;
            $order->order_source()->associate(rand(1, 3));
            $order->order_status()->associate(rand(1, 3));
            $order->delivery_fee = $deliveryFee;
            $order->subtotal = $subtotal;
            $order->discount = $discount;
            $order->total = $subtotal + $deliveryFee - $discount;
            $order->created_at = $faker->dateTimeBetween('-2 years');
            $order->save();

            foreach (range(1, rand(2, 3)) as $index) {
                $item = Item::inRandomOrder()->first();
                $order_detail = new OrderDetail();
                $quantity = rand(1, 3);
                $subtotal +=  ($item->base_price * $quantity);
                $order_detail->quantity =  rand(1, 3);
                $order_detail->price = $item->base_price;
                $order_detail->cost = $item->cost;
                $order_detail->item()->associate($item);
                $order_detail->order()->associate($order);
                $order_detail->save();
            }
            $orderToUpdate = Order::find($orderId);
            $orderToUpdate->subtotal = $subtotal;
            $orderToUpdate->total = $subtotal + $deliveryFee - $discount;
            $orderToUpdate->save();
        }
    }
}
