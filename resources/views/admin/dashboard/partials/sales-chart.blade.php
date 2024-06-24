<div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
    <div class="h3 fw-bold ff-montserrat"> Sales Analytics</div>
    <canvas id="sales-chart"></canvas>
</div>


@push('script')
    <script type="text/javascript">
        var sales_chart_element = document.getElementById("sales-chart").getContext("2d");
        sales_chart = new Chart(sales_chart_element, {
            type: "bar",
            data: {
                labels: [],
                datasets: [{
                    label: "Sales",
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
                    text: "Sales"
                },
                scales: {
                    yAxes: [{
                        scaleLabel: {
                            display: !0,
                            labelString: "Total"
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
        @foreach ($total_per_month as $order_count)
            sales_chart.data.labels.push("{{ $order_count->date }}"), sales_chart.data.datasets.forEach(a => {
                a.data.push("{{ $order_count->total }}");
            });
        @endforeach

        sales_chart.update();
    </script>
@endpush
