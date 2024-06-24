@extends('admin.layouts.app')
@section('title', 'Orders')
@section('page_name', 'Orders')

@section('content')
    <div class="d-flex align-items-center mb-3">
        <div class="flex-grow-1 h5 fw-bold m-0 ff-montserrat">Orders</div>
    </div>
    <div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">

        <div class="d-flex align-items-center mb-3">
            <div class="flex-grow-1  m-0">
                <form action="" role="form" method="GET">
                    <div class="position-relative mb-3">
                        <input type="text" class="form-control w-auto" name="search_query" id="search"
                            autocomplete="off" placeholder="Search..." style="padding-left: 2.5rem !important"
                            value="{{ Request::get('search_query') }}" />
                        <div class="position-absolute top-50 start-0 translate-middle-y p-2">
                            <search-icon-component></search-icon-component>
                        </div>
                    </div>
                </form>
            </div>
            <div>
                @include('admin.orders.sort')
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover mb-0">
                <thead>
                    <tr>
                        <th>Order №</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Type</th>
                        <th>Delivery Charge</th>
                        <th>Subtotal</th>
                        <th>Total</th>
                        <th>Created At</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->number }}</td>
                            <td>{{ $order->name }}</td>
                            <td>
                                <a class="link-primary" href="mailto:{{ $order->email }}">{{ $order->email }}</a>
                            </td>
                            <td>
                                <a class="link-primary" href="tel:{{ $order->phone }}">{{ $order->phone }}</a>
                            </td>
                            <td>{{ $order->type }}</td>
                            <td>{{ $order->display_delivery_fee }}</td>
                            <td>{{ $order->display_subtotal }}</td>
                            <td>{{ $order->display_total }}</td>
                            <td>{{ $order->display_date }}</td>
                            <td>{!! $order->order_status->full_status !!}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="link-primary">View
                                    Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $orders->withQueryString()->links() }}
            @if ($orders->isEmpty())
                <no-content-component></no-content-component>
            @endif
        </div>
    </div>
@endsection
