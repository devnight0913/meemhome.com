@extends('layouts.app')
@section('title', 'Purchase History')
@section('content')
    <div class="border rounded-4 p-3 mb-3 bg-white  shadow-sm">
        <div class="h3 fw-bold mb-3"> Completed Orders</div>

        @if ($orders->isEmpty())
            <no-content-component></no-content-component>
        @endif

        @foreach ($orders as $order)
            <div class="border rounded-4 p-3 mb-3 bg-white  shadow-sm">
                <div class="mb-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 h5 fw-bold m-0">№{{ $order->number }}</div>
                        <div class="">
                            {!! $order->order_status->user_full_status !!}
                        </div>
                    </div>
                    <div class="small text-muted">
                        {{ $order->display_date_created }} at {{ $order->display_time_created }}
                    </div>
                </div>
                <div>
                    @if ($order->is_delivery)
                        <div>
                            <span class="text-muted">Delivery: </span> <span>{{ $order->area->name }},
                                {{ $order->address }}</span>
                        </div>
                    @endif
                    <div>
                        <span class="text-muted">Payment: </span> <span>{{ $order->payment_method->name }}</span>
                    </div>
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <span class="text-muted">Total: </span> <span>{{ $order->display_total }}</span>
                        </div>
                        <a href="{{ route('user.orders.show', $order) }}" class="link-primary d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="hero-icon-sm me-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                            </svg>View Details
                            
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
        {{ $orders->links() }}
    </div>



@endsection
