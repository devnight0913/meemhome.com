<div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
    <div class="h3 fw-bold ff-montserrat"> Orders Report</div>
    <div class=" table-responsive" style="max-height:600px;">
        <table class="table table-bordered table-hover table-striped mb-0">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Orders</th>
                    <th>Delivery Charge</th>
                    <th>Subtotal</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($total_orders_per_month as $order)
                    <tr>
                        <td>{{ $order->date }}</td>
                        <td>{{ $order->total }}</td>
                        <td>{{ usd_money_format($order->delivery_fee_sum) }}</td>
                        <td>{{ usd_money_format($order->subtotal_sum) }}</td>
                        <td>{{ usd_money_format($order->total_sum) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($total_orders_per_month->isEmpty())
            <no-content-component></no-content-component>
        @endif
    </div>
</div>
