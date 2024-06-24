<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PurchaseHistoryController extends Controller
{
    public function index(Request $request): View
    {
        $orders = $request->user()->orders()->latest()->paginate(5);
        return view('purchase-history.index', [
            'orders' => $orders,
        ]);
    }


    public function show(Request $request, string $id): View
    {
        $order = $request->user()->orders()->findOrFail($id);
        return view('purchase-history.show', [
            'order' => $order,
        ]);
    }
}
