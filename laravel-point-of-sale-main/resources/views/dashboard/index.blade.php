@extends('dashboard.body.main')

@section('container')
@include('dashboard.body.navbar')
<div class="container-fluid bg-light p-4" style="border-radius: 5px;">
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <h1 class="text-center mb-5">Dashboard</h1>

    <div class="row">
        @foreach ([
            ['title' => 'Total Sales', 'value' => '₱ ' . $total_paid, 'icon' => 'ri-shopping-bag-3-line', 'bg' => 'primary'],
            ['title' => 'Total Orders', 'value' => count($complete_orders), 'icon' => 'ri-file-list-3-line', 'bg' => 'success'],
            ['title' => 'Total Products', 'value' => $total_products, 'icon' => 'ri-archive-line', 'bg' => 'danger']

        ] as $card)
        <div class="col-lg-4 col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="icon bg-{{ $card['bg'] }} text-white rounded-circle p-3 mr-3">
                        <i class="{{ $card['icon'] }} ri-2x"></i>
                    </div>
                    <div>
                        <p class="mb-1 text-muted">{{ $card['title'] }}</p>
                        <h3 class="mb-0">{{ $card['value'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row mt-4">
        <div class="col-lg-5 col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Stock Analysis</h5>
                </div>
                <div class="card-body mb-4 mt-2">
                    <canvas id="stockChart" width="600" height="400"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white font-weight-bold d-flex justify-content-between">
                    <span>Total Sales</span>
                    <select id="salesFilter" class="form-control form-control-sm w-auto">
                        <option value="yearly">Yearly</option>
                        <option value="monthly">Monthly</option>
                        <option value="weekly">Weekly</option>
                        <option value="previousMonth">Previous Month</option>
                    </select>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" style="height: 420px !important;"></canvas>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('specificpagescripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('stockChart').getContext('2d');
        var stockChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($stockLabels),
                datasets: [{
                    label: 'Stock Analysis',
                    data: @json($stockValues),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFD700', '#4BC0C0', '#9966FF', '#FF9F40', '#C9CBCF'],
                    borderColor: ['#FFFFFF', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#FFFFFF'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: { enabled: true }
                }
            }
        });


        var salesCtx = document.getElementById('salesChart').getContext('2d');
        var selectedDescription = '{{ now()->year }}';
        var salesChart = new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: @json($salesLabels),
                datasets: [{
                    label: 'Total Sales',
                    data: @json($salesData),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    barThickness: 30
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,  // Allows height customization
                scales: {
                    y: { beginAtZero: true }
                },
                plugins: {
                    legend: { position: 'top' },
                    tooltip: { enabled: true }
                },
                layout: {
                    padding: {
                        top: 10,
                        bottom: 10
                    }
                }
            }

        });

        document.getElementById('salesFilter').addEventListener('change', function () {
            var period = this.value;
            if (period === 'yearly') {
                salesChart.data.labels = @json($salesLabels);
                salesChart.data.datasets[0].data = @json($salesData);
                selectedDescription = '{{ now()->year }}';
            } else if (period === 'monthly') {
                salesChart.data.labels = @json($monthlySalesLabels);
                salesChart.data.datasets[0].data = @json($monthlySalesData);
                selectedDescription = '{{ now()->format("F Y") }}';
            } else if (period === 'weekly') {
                salesChart.data.labels = @json($weeklySalesLabels);
                salesChart.data.datasets[0].data = @json($weeklySalesData);
                selectedDescription = 'Week {{ now()->weekOfYear }} of {{ now()->year }}';
            } else if (period === 'previousMonth') {
                salesChart.data.labels = @json($previousMonthSalesLabels);
                salesChart.data.datasets[0].data = @json($previousMonthSalesData);
                selectedDescription = '{{ now()->subMonth()->format("F Y") }}';
            }
            salesChart.update();
        });
    });

    $('.notification-item').click(function() {
            let notificationId = $(this).data('id');

            $.ajax({
                url: "/notifications/read/" + notificationId,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    console.log(response);
                    alert('Notification marked as read!');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert('Error marking notification as read.');
                }
            });
        });

</script>
@endsection
