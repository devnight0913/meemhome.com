<div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
    <div class="h3 fw-bold ff-montserrat"> Latest orders</div>
    <div class=" table-responsive">
        <table class="table table-bordered table-hover table-striped mb-0">
            <thead>
                <tr>
                    <th>Order №</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($latest_orders as $order)
                    <tr>
                        <td>{{ $order->number }}</td>
                        <td>{{ $order->name }}</td>
                        <td><a class="link-primary" href="mailto:{{ $order->email }}">{{ $order->email }}</a>
                        </td>
                        <td><a class="link-primary" href="tel:{{ $order->phone }}">{{ $order->phone }}</a></td>
                        <td>{{ $order->display_date }}</td>
                        <td>{{ $order->display_total }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="link-primary">
                                View Details
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($latest_orders->isEmpty())
            <no-content-component></no-content-component>
        @endif
    </div>
</div>
