<div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
    <div class="h3 fw-bold ff-montserrat"> Orders Analytics</div>
    <canvas id="orders-chart"></canvas>
</div>

@push('script')
    <script type="text/javascript">
        var orders_chart_element = document.getElementById("orders-chart").getContext("2d");
        orders_chart = new Chart(orders_chart_element, {
            type: "line",
            data: {
                labels: [],
                datasets: [{
                    label: "Orders",
                    borderColor: "#4285F4",
                    data: []
                }]
            },
            options: {
                layout: {
                    padding: 10
                },
                legend: {
                    position: "bottom"
                },
                title: {
                    display: !0,
                    text: "Orders"
                },
                scales: {
                    yAxes: [{
                        scaleLabel: {
                            display: !0,
                            labelString: "Orders"
                        }
                    }],
                    xAxes: [{
                        scaleLabel: {
                            display: !0,
                            labelString: "Data"
                        }
                    }]
                }
            }
        });

        @foreach ($total_orders_per_month as $order)
            orders_chart.data.labels.push("{{ $order->date }}"), orders_chart.data.datasets.forEach(a => {
                a.data.push("{{ $order->total }}");
            });
        @endforeach
        orders_chart.update();
    </script>
@endpush
