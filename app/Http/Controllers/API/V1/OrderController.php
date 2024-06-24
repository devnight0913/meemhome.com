<?php

namespace App\Http\Controllers\API\V1;

use App\Mail\AdminOrderPlacedMail;
use App\Mail\CustomerOrderPlacedMail;
use App\Models\Area;
use App\Models\Coupon;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderSource;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use App\Models\Settings;
use App\Models\User;
use App\Notifications\OrderPlacedNotification;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OrderController extends ApiController
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {

        $cart = (object) $request->cart;

        $this->validateOrder($request);
        if (Str::length($request->phone) <= 5) {
            throw ValidationException::withMessages([
                "phone" => "Invalid phone number",
            ])->status(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $order = new Order();
        $order->number = $this->randomNumber();

        $userId = $request->user_id;

        $user = User::where('id', $userId)->first();
        if ($user) {
            $order->user_id =  $userId;
        }


        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->is_delivery = $request->delivery;

        $subtotal = $cart->total;
        $deliveryFee = 0;
        $discount = 0;

        if ($request->delivery) {
            $area = Area::active()->find($request->area);
            if ($area) {
                $deliveryFee = $area->fee;
                $order->area()->associate($area);
                $order->address = $request->address;
            }
        }

        $order->payment_method()->associate(
            PaymentMethod::where('id', $request->payment_method)->exists()
                ? $request->payment_method
                : PaymentMethod::first()
        );



        if ($request->coupon_code) {
            $coupon = Coupon::where('code', $request->coupon_code)->active()->first();
            if ($coupon) {
                $order->coupon()->associate($coupon);
                if ($coupon->percentage > 0) {
                    $discount = (($coupon->percentage / 100) * $subtotal);
                }
            }
        }
        $order->comment = $request->comment;
        $source = OrderSource::find($request->get('source', OrderSource::WEBSITE));
        $order->order_source()->associate($source);
        $order->order_status()->associate(OrderStatus::PENDING);
        $order->delivery_fee = $deliveryFee;
        $order->subtotal = $subtotal;
        $order->discount = $discount;
        $order->total = $subtotal + $deliveryFee - $discount;
        $order->save();


        foreach ($cart->items as $cartItem) {
            $cartItem = (object)$cartItem;
            $item = Item::find($cartItem->id); // check item if valid
            if ($item) {
                $quantity = $cartItem->quantity > 1 ? $cartItem->quantity : 1; //prevent 0 and vegetive numbers
                $order_detail = new OrderDetail();
                $order_detail->quantity =  $quantity;
                $order_detail->price = $item->price;
                $order_detail->warranty_period = $item->warranty_period;
                $order_detail->cost = $item->cost;
                $order_detail->item()->associate($item);
                $order_detail->order()->associate($order);
                $order_detail->save();

                if ($item->track_stock) {
                    $item->in_stock -= $quantity;
                    $item->save();
                }
            }
        }

        try {
            $this->notifyUsers($order);
            $this->sendMail($order, $request->email);
        } catch (Exception $e) {
            //return $e;
            return $this->jsonResponse();
        }
        return $this->jsonResponse();
    }

    /**
     * Validate the customer order request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateOrder(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:100'],
            'phone' => ['required', 'max:255'],
            'delivery' => ['required', 'boolean'],
            'payment_method' => ['required', 'string'],
            'comment' => ['nullable', 'string', 'max:255'],
        ]);

        if ($request->delivery) {
            $request->validate([
                'area' => ['required', 'string'],
                'address' => ['required', 'string', 'max:255'],
            ]);
        }
    }

    /**
     * Send mail to admin and customer.
     *
     * @param  \App\Models\Order $order
     * @param  string $email
     * @return void
     */
    private function sendMail(Order $order, string $email)
    {
        Mail::to(Settings::getAdminEmailValue())->send(new AdminOrderPlacedMail($order));
        if ($email) {
            Mail::to($email)->send(new CustomerOrderPlacedMail($order));
        }
    }

    /**
     * Notify admins.
     *
     * @param  \App\Models\Order $order
     * @return void
     */
    public function notifyUsers(Order $order)
    {
        $users = User::admin()->get();
        foreach ($users as $user) {
            $user->notify(new OrderPlacedNotification($order));
        }
    }

    /**
     * Generate a random integer.
     *
     * @return int
     */
    private function randomNumber(): int
    {
        return rand(999999, 9999999);
    }
}
