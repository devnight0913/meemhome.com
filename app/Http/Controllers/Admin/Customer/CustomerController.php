<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $this->checkPermission('customer_access');
        $sorts = ['asc', 'desc'];
        $sort = $request->get('order', 'desc');
        $size = $request->get('size', 20);
        $search_query = $request->get("search_query");

        abort_if(!in_array($sort, $sorts), Response::HTTP_NOT_FOUND);

        $customers = Order::select('*', DB::raw('count(*) as order_count'))
            ->searchCustomer($search_query)
            ->orderBy('created_at', $sort)
            ->groupBy('email')->paginate($size);

        return view('admin.customers.index', [
            'customers' => $customers
        ]);
    }
}
