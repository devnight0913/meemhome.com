<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    /**
     * show user's orders.
     *
     */
    public function index(Request $request)
    {
        $user = $request->user('api');
        $orders = Order::with('area', 'payment_method', 'order_detail.item.category', 'coupon', 'order_status', 'order_source')
            ->where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();
        return $this->jsonResponse([
            "orders" => $orders,
        ]);
    }

    /**
     * show user's order.
     *
     */
    public function show(Request $request, string $id)
    {
        $user = $request->user('api');
        $order = Order::with('area', 'payment_method', 'order_detail.item.category', 'coupon', 'order_status', 'order_source')
            ->where('user_id', $user->id)->orderBy('created_at', 'DESC')->findOrFail($id);
        return $this->jsonResponse([
            "order" => $order,
        ]);
    }
}
