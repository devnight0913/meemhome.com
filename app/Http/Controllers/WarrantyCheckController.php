<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\SerialNumber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class WarrantyCheckController extends Controller
{

    public function show(Request $request)
    {
        $request->validate([
            'serial_number' => ['nullable', 'string'],
        ]);
        $serialNumberRequest = $request->serial_number;
        if (is_null($serialNumberRequest)) {
            throw ValidationException::withMessages([
                'serial_number' => 'Invalid Serial Number.'
            ])->status(Response::HTTP_UNPROCESSABLE_ENTITY);
        }



        $serialNumber = SerialNumber::where('serial_numbers', 'LIKE', "%{$serialNumberRequest}%")->with('item')->first();

        if (!$serialNumber) {
            throw ValidationException::withMessages([
                'serial_number' => 'Invalid Serial Number.'
            ])->status(Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        $warrantyEndDate = new Carbon($serialNumber->warranty_end_date);


        if ($warrantyEndDate->gt(now())) {
            //$days = $warrantyEndDate->diffInDays(now());
            $info = "Warranty is valid until {$serialNumber->warranty_end_date_view}";
            $isValid = true;
        } else {
            $info = "Your Warranty has been expired since {$serialNumber->warranty_end_date_view}";
            $isValid = false;
        }


        return response()->json([
            'info' => $info,
            'item' =>  $serialNumber->item,
            'is_valid' => $isValid,
            'serial_number' => $serialNumberRequest,
            'purchase_date' => $serialNumber->purchase_date_view,
            'notes' => $serialNumber->notes,
        ]);
    }


    public function show2(Request $request)
    {
        $request->validate([
            'serial_number' => ['required', 'string'],
            'order_number' => ['required', 'string']
        ]);

        // $order = Order::where('number', $request->order_number)->first();
        // $item = Item::where('serial_number', $request->serial_number)->first();
        $orderNumber = $request->order_number;
        $serialNumber = $request->serial_number;

        $orderDetails = OrderDetail::whereHas('order', function ($query) use ($orderNumber) {
            $query->where('number', $orderNumber);
        })
            ->whereHas('item', function ($query) use ($serialNumber) {
                $query->where('serial_number', $serialNumber);
            })->with('order', 'item')->first();

        if (!$orderDetails) {
            throw ValidationException::withMessages([
                'serial_number' => 'Invalid Serial number or order number.'
            ])->status(Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $deliveredAt = $orderDetails->order->delivered_at;

        if (is_null($deliveredAt)) {
            throw ValidationException::withMessages([
                'serial_number' => 'No Information was found.'
            ])->status(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $dateDiff = now()->diffInDays(Carbon::parse($deliveredAt));

        $warrantyLeft = $orderDetails->item->warranty_period - $dateDiff;
        $isValid = false;
        $expiration_date = null;
        if ($warrantyLeft <= 0) {
            $info = "Your Warranty has been expired";
        } else {
            $info = "{$warrantyLeft} Days";
            $isValid = true;
            $expiration_date = now()->addDays($warrantyLeft);
        }

        return response()->json([
            'info' => $info,
            'item' => $orderDetails->item,
            'purchase_date' => $orderDetails->order->display_delivered_at,
            'is_valid' => (bool)$isValid,
            'expiration_date' =>  Carbon::parse($expiration_date)->format('d F Y'),
        ]);
    }
}
