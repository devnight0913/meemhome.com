<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class OrderStatusController extends Controller
{
    public function update(Order $order, OrderStatus $status)
    {
        $this->checkPermission('order_status_edit');
        $order->order_status()->associate($status);
        if ($status->id == OrderStatus::DELIVERED) {
            $order->delivered_at = now();
        }
        $order->save();
        $orderStatusId = $order->order_status_id;
        $statusName = OrderStatus::$statuses[$orderStatusId];
        return Redirect::back()->with('success', "Order marked as {$statusName}.");
    }
}
