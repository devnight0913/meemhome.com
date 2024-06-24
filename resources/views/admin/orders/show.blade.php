@extends('admin.layouts.app')
@section('title', 'Order №' . $order->number)

@section('content')

    <div class="d-flex align-items-center mb-3">
        <div class="flex-grow-1">
            <div class="h3 fw-bold"> Order №{{ $order->number }}</div>
        </div>
        <div class="dropdown">
            <a class="btn btn-primary" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="hero-icon">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>

            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                <li>
                    <a class="dropdown-item" href="{{ route('admin.orders.edit', $order->id) }}">
                        <mt-icon icon="edit" styleName="me-1"></mt-icon> Edit
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('admin.orders.print', $order->id) }}" target="_blank">
                        <mt-icon icon="print" styleName="me-1"></mt-icon> Print
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item text-danger" href="#" onclick="deleteOrder()">
                        <mt-icon icon="delete" styleName="me-1"></mt-icon> Delete
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <form id="delete-order-form" action="{{ route('admin.orders.delete', $order->id) }}" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>

    <div class="d-flex mb-3">
        <div class="dropdown ">
            <button class="btn btn-light border-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                data-bs-toggle="dropdown" aria-expanded="false">
                Change Order Status
            </button>
            <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                @foreach ($statuses as $status)
                    <li>
                        <a class="dropdown-item"
                            href="{{ route('admin.orders.status.update', [$order->id, $status->id]) }}">{!! $status->icon !!}
                            {{ $status->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
        <div class="d-flex align-items-center mb-2">
            <div>{!! $order->order_status->full_status !!}</div>
        </div>
        @if ($order->order_status->id == 2)
            <div class="mb-2">
                <span class="text-muted">Delivered At: </span> {{ $order->display_delivered_at }}
            </div>
        @endif
        <div class="mb-2">
            <span class="text-muted">Created At: </span> {{ $order->display_date_created }} at
            {{ $order->display_time_created }}
        </div>
        <div>Type: {{ $order->type }}</div>
    </div>
    <div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
        <div class="h3 fw-bold"> Customer information</div>
        <div class="mb-2">
            <span class="me-2">Name:</span>{{ $order->name }}
        </div>
        <div class="mb-2">
            <span class="me-2">Email:</span>
            <a class="link-primary" href="mailto:{{ $order->email }}">{{ $order->email }}</a>
        </div>
        <div class="mb-2">
            <span class="me-2">Phone:</span>
            <a class="link-primary" href="tel:{{ $order->phone }}">{{ $order->phone }}</a>
        </div>
        @if ($order->comment)
            <hr>
            <div class="mb-2">
                <span class="me-2">Comment:</span>{{ $order->comment }}
            </div>
        @endif
    </div>

    <div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
        <div class="h3 fw-bold"> Payment</div>
        <div class="mb-2">
            {{ $order->payment_method->name }}
        </div>
        <div class="mb-2">
            <span class="me-2">Subtotal:</span>{{ $order->display_subtotal }}
        </div>
        @if ($order->coupon)
            <div class="mb-2">
                <span class="me-2">Coupon:</span>{{ $order->coupon->code }}
            </div>
            <div class="mb-2">{{ $order->coupon->des }}</div>
        @endif
        @if ($order->discount > 0)
            <div class="mb-2">
                <span class="me-2">Discount:</span>{{ $order->display_discount }}
            </div>
        @endif
        @if ($order->is_delivery)
            <div class="mb-2">
                <span class="me-2">Delivery Charge:</span>{{ $order->display_delivery_fee }}
            </div>
        @endif
        <div class="fw-bold">
            <span class="me-2">Total:</span>{{ $order->display_total }}
        </div>
    </div>


    @if ($order->is_delivery)
        <div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
            <div class="h3 fw-bold"> Delivery Address</div>
            <div class="mb-2">
                <span class="me-2">Area:</span>{{ $order->area->name }}
            </div>
            <div class="mb-2">
                <span class="me-2">Address:</span>{{ $order->address }}
            </div>
            <div class="mb-2">
                <span class="me-2">DeliveryTime:</span>{{ $order->area->view_time }}
            </div>
        </div>
    @endif
    <div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
        <div class="h3 fw-bold"> Order Details</div>
        <div class="table-responsive">
            <table class=" table table-striped table-bordered table-hover mb-0">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->order_detail as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="me-2">
                                        <img src="{{ $item->item->sm_thumbnail_image_url }}" alt="img"
                                            class=" object-fit-cover rounded-circle" widtd="50" height="50">
                                    </div>
                                    <div>
                                        <a href="{{ $item->item->url }}" class="link-primary mb-2" target="_blank">
                                            {{ $item->item->name }}
                                        </a>
                                        <div>
                                            <a href="{{ $item->item->category->url }}"
                                                class="link-primary text-warning small" target="_blank">
                                                {{ $item->item->category->name }}
                                            </a>
                                        </div>
                                    </div>
                                </div>


                            </td>
                            <td>x{{ $item->quantity }}</td>
                            <td>{{ $item->display_subtotal }}</td>
                            <td>{{ $item->display_total }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class="text-end">
                            Subtotal
                        </td>

                        <td>{{ $order->display_subtotal }}</td>
                    </tr>

                    @if ($order->discount > 0)
                        <tr>
                            <td colspan="3" class="text-end">
                                Discount
                            </td>

                            <td>{{ $order->display_discount }}</td>
                        </tr>
                    @endif
                    @if ($order->is_delivery)
                        <tr>
                            <td colspan="3" class="text-end">
                                Delivery Charge
                            </td>

                            <td>{{ $order->display_delivery_fee }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="3" class="text-end">
                            Total
                        </td>

                        <td>{{ $order->display_total }}</td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>
@endsection
@push('script')
    <script>
        function deleteOrder() {
            Swal.fire({
                title: "Are you sure?",
                text: "You will not be able to reverse this action!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "Cancel",
                focusCancel: true,
                showClass: {
                    popup: "",
                    icon: "",
                },
                hideClass: {
                    popup: "",
                },
            }).then((result) => {
                if (result.value) {
                    document.getElementById("delete-order-form").submit();
                }
            });
        }
    </script>
@endpush
