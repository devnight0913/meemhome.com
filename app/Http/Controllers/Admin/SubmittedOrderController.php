<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SubmittedOrderController extends Controller
{
    public function index(Request $request): View
    {
        $this->checkPermission('order_access');
        $this->deleteAllNotifications();
        $sorts = ['asc', 'desc'];
        $sort = $request->get('order', 'desc');
        $size = $request->get('size', 10);
        $search_query = $request->get("search_query");

        abort_if(!in_array($sort, $sorts), Response::HTTP_NOT_FOUND);


        $orders = Order::with('order_status', 'order_source')->search($search_query)->orderBy('created_at', $sort)->paginate($size);
        return view('admin.orders.index', [
            'orders' => $orders,
        ]);
    }
    public function show(string $id): View
    {

        $this->checkPermission('order_show');
        $order = Order::with('area', 'payment_method', 'order_detail.item.category', 'coupon', 'order_status', 'order_source')->findOrFail($id);
        $statuses = OrderStatus::all();
        return view('admin.orders.show', [
            'order' => $order,
            'statuses' => $statuses,
        ]);
    }

    public function edit(string $id): View
    {
        $this->checkPermission('order_edit');
        $order = Order::with('area', 'payment_method', 'order_detail.item.category', 'coupon', 'order_status', 'order_source')->findOrFail($id);
        $statuses = OrderStatus::all();

        return view('admin.orders.edit', [
            'order' => $order,
            'statuses' => $statuses,
            'areas' => Area::orderBy('name', 'ASC')->get(),
        ]);
    }
    public function update(Request $request, Order $order)
    {
        $this->checkPermission('order_edit');
       
        $request->validate([
            'number' => ['required', 'string', 'max:7'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:100'],
            'phone' => ['required', 'max:255'],
            'is_delivery' => ['required', 'boolean'],
            'comment' => ['nullable', 'string', 'max:255'],
            'created_at' => ['required'],
            'delivered_at' => ['nullable'],
        ]);
       
        if ($request->is_delivery) {
            $request->validate([
                'area' => ['required', 'string'],
                'address' => ['required', 'string', 'max:255'],
            ]);
        } 
      
        $order->number = $request->number;
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->is_delivery = $request->is_delivery;
        $order->comment = $request->comment;
        $order->created_at = $request->created_at;
        $order->delivered_at = $request->delivered_at;
        $deliveryFee = 0;
        $area = null;
        

        if ($request->is_delivery) {
            $area = Area::find($request->area);
            if ($area) {
                $deliveryFee = $area->fee;
            }
        }
        $order->delivery_fee = $deliveryFee;
        $order->area_id = is_null($area) ? null : $area->id;
        $order->address = $request->address;
        $order->total = $order->subtotal + $deliveryFee - $order->discount;

        $order->save();


        return redirect()->route('admin.orders.show', $order)->with('success', 'Order has been updated.');
    }





    public function print(string $id): View
    {
        $this->checkPermission('order_print');
        $order = Order::with('area', 'payment_method', 'order_detail.item.category', 'coupon', 'order_status', 'order_source')->findOrFail($id);
        return view('admin.orders.print', [
            'order' => $order,
        ]);
    }

    private function deleteAllNotifications()
    {
        DB::table('notifications')->delete();
    }


    public function destroy(Order $order): RedirectResponse
    {
        $this->checkPermission('order_delete');
        $order->delete();
        return Redirect::route('admin.orders.index')->with('success', 'Order has been deleted.');
    }
}
