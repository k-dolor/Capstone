@extends('dashboard.body.main')

@section('container')
@include('dashboard.body.navbar')
<div class="container-fluid" style="background-color: #f3f2f7;">
    <!-- Success Alert -->
    @if (session()->has('success'))
        <div class="alert text-white bg-success" role="alert">
            <div class="iq-alert-text">{{ session('success') }}</div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="ri-close-line"></i>
            </button>
        </div>
    @endif

    <h1 class="text-center mb-4" style="font-family: 'Poppins', sans-serif;">Dashboard</h1>

    <!-- Welcome Section -->
    <div class="row mb-2">
        <div class="col-lg-12">
            <div class="card card-transparent card-stretch card-height border-none">
                <div class="card-body p-2">
                    <h3 class="mb-2">Good Day, {{ auth()->user()->name }}</h3>
                    <p class="mb-0">Welcome to L&N Supply Management System.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Metrics Section -->
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="card card-block card-stretch card-height">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="icon iq-icon-box-2 bg-info-light">
                            <img src="../assets/images/product/1.png" class="img-fluid" alt="Total Paid">
                        </div>
                        <div class="ml-3">
                            <p class="mb-2">Total Sales</p>
                            <h2>₱ {{ $total_paid }}</h2>
                        </div>
                    </div>
                    {{-- <div class="iq-progress-bar mt-2">
                        <span class="bg-info iq-progress progress-1" data-percent="85"></span>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card card-block card-stretch card-height">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="icon iq-icon-box-2 bg-success-light">
                            <img src="../assets/images/product/3.png" class="img-fluid" alt="Complete Orders">
                        </div>
                        <div class="ml-3">
                            <p class="mb-2">Total Orders</p>
                            <h2>{{ count($complete_orders) }}</h2>
                        </div>
                    </div>
                    {{-- <div class="iq-progress-bar mt-2">
                        <span class="bg-success iq-progress progress-1" data-percent="75"></span>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card card-block card-stretch card-height">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="icon iq-icon-box-2 bg-danger-light">
                            <img src="../assets/images/product/2.png" class="img-fluid" alt="Total Products">
                        </div>
                        <div class="ml-3">
                            <p class="mb-2">Total Products</p> <!-- Updated label -->
                            <h2>{{ $total_products }}</h2> <!-- Displaying the total products -->
                        </div>
                    </div>
                    {{-- <div class="iq-progress-bar mt-2">
                        <span class="bg-danger iq-progress progress-1" data-percent="70"></span>
                    </div> --}}
                </div>
            </div>
        </div>
        
        
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <!-- Stock Analysis Section -->
<div class="col-lg-6 col-md-12 mb-4">
    <div class="card">
        <div class="card-header">
            <h5>Stock Analysis</h5>
        </div>
        <div class="card-body mb-4 mt-2">
            <canvas id="stockChart" width="600" height="400"></canvas>
        </div>
    </div>
</div>
     <!-- Total Sales by Month Chart -->
     <div class="col-lg-6 mb-4">
        <div class="card card-block card-stretch card-height">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Total Sales</h4>
                <!-- Dropdown for selecting time period (Yearly, Monthly, Weekly, Previous Month) -->
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span id="selectedPeriod">This Year</span> <i class="ri-arrow-down-s-line ml-1"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#" onclick="filterSales('yearly')">Yearly</a>
                        <a class="dropdown-item" href="#" onclick="filterSales('monthly')">Monthly</a>
                        <a class="dropdown-item" href="#" onclick="filterSales('weekly')">Weekly</a>
                        <a class="dropdown-item" href="#" onclick="filterSales('previousMonth')">Previous Month</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <canvas id="salesChart" width="400" height="400"></canvas>
            </div>
        </div>
    </div>

<!-- Top Products Section -->
<div class="col-lg-6 col-md-12">
    <div class="card">
        <div class="card-header">
            <h5>Top Products</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <img src="{{ $product->product_image ? asset('storage/products/'.$product->product_image) : asset('assets/images/product/gas.png') }}" 
                                     class="img-fluid" 
                                     style="height: 50px; width: 50px; object-fit: cover;" 
                                     alt="{{ $product->product_name }}">
                            </td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->selling_price }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
    <!-- Sales & Revenue Chart Section -->
<div class="col-lg-6 mb-4">
    <div class="card card-block card-stretch card-height">
        <!-- Card Header with Title and Filter Dropdown -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">Sales & Revenue</h4>
            <!-- Dropdown for selecting time period (Yearly, Monthly, Weekly) -->
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton002" data-toggle="dropdown">
                    <span>This Month</span> <i class="ri-arrow-down-s-line ml-1"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton002">
                    <a class="dropdown-item" href="#">Yearly</a>
                    <a class="dropdown-item" href="#">Monthly</a>
                    <a class="dropdown-item" href="#">Weekly</a>
                </div>
            </div>
        </div>

        <!-- Card Body for Chart Visualization -->
        <div class="card-body p-4">
            <!-- Updated Chart Display Section with Larger Area -->
            <div id="layout1-chart-2" style="min-height: 400px; background-color: #f8f9fa; border-radius: 8px;">
                <!-- Placeholder message with improved design -->
                <p class="text-center text-muted" style="padding-top: 180px;">Chart Will Be Displayed Here</p>
            </div>
        </div>
    </div>
</div>

    </div>
</div>
@endsection

@section('specificpagescripts')
<!-- Table Treeview JavaScript -->
<script src="{{ asset('assets/js/table-treeview.js') }}"></script>
<!-- Chart Custom JavaScript -->
<script src="{{ asset('assets/js/customizer.js') }}"></script>
<!-- Chart Custom JavaScript -->
<script async src="{{ asset('assets/js/chart-custom.js') }}"></script>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

    ////STOCK CHART -------------------------
    document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('stockChart').getContext('2d');
            var stockChart = new Chart(ctx, {
                type: 'doughnut', // Specify the chart type
                data: {
                    labels: @json($stockLabels), // Use the data passed from the controller
                    datasets: [{
                        label: 'Stock Analysis',
                        data: @json($stockValues), // Use the data passed from the controller
                        backgroundColor: [
                        '#FF6384', // Red
                        '#36A2EB', // Blue
                        '#FFD700', // Yellow
                        '#4BC0C0', // Teal
                        '#9966FF', // Purple
                        '#FF9F40', // Orange
                        '#C9CBCF'  // Grey
                    ],
                    borderColor: [
                        '#FFFFFF', // White border for better visibility
                        '#FFFFFF',
                        '#FFFFFF',
                        '#FFFFFF',
                        '#FFFFFF',
                        '#FFFFFF',
                        '#FFFFFF'
                    ],
                    borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        labels: {
                            font: {
                                size: 14 // Increase the font size of legend labels
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                        bodyFont: {
                            size: 14 // Increase the font size of tooltip labels
                        }
                    }
                }
            }
        });
    });

    ////SALES CHART -------------------------
    document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('salesChart').getContext('2d');
            var salesChart = new Chart(ctx, {
                type: 'bar', // Specify the chart type as 'bar'
                data: {
                    labels: @json($salesLabels), // Use the data passed from the controller
                    datasets: [{
                        label: 'Total Sales',
                        data: @json($salesData), // Use the data passed from the controller
                        backgroundColor: 'rgba(54, 162, 235, 0.6)', // Blue color with some transparency
                        borderColor: 'rgba(54, 162, 235, 1)', // Solid blue border
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true // Ensure the y-axis starts at zero
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                font: {
                                    size: 14 // Increase the font size of legend labels
                                }
                            }
                        },
                        tooltip: {
                            enabled: true,
                            bodyFont: {
                                size: 14 // Increase the font size of tooltip labels
                            }
                        }
                    }
                }
            });

            window.filterSales = function(period) {
                var selectedPeriod = document.getElementById('selectedPeriod');
                if (period === 'yearly') {
                    selectedPeriod.textContent = 'This Year';
                    // Update the chart data for yearly sales
                    salesChart.data.labels = @json($salesLabels); // Update with yearly labels
                    salesChart.data.datasets[0].data = @json($salesData); // Update with yearly data
                } else if (period === 'monthly') {
                    selectedPeriod.textContent = 'This Month';
                    // Update the chart data for monthly sales
                    salesChart.data.labels = @json($monthlySalesLabels); // Update with monthly labels
                    salesChart.data.datasets[0].data = @json($monthlySalesData); // Update with monthly data
                } else if (period === 'weekly') {
                    selectedPeriod.textContent = 'This Week';
                    // Update the chart data for weekly sales
                    salesChart.data.labels = @json($weeklySalesLabels); // Update with weekly labels
                    salesChart.data.datasets[0].data = @json($weeklySalesData); // Update with weekly data
                } else if (period === 'previousMonth') {
                    selectedPeriod.textContent = 'Previous Month';
                    // Update the chart data for previous month's sales
                    salesChart.data.labels = @json($previousMonthSalesLabels); // Update with previous month's labels
                    salesChart.data.datasets[0].data = @json($previousMonthSalesData); // Update with previous month's data
                }
                salesChart.update();
            };

            var ctxStock = document.getElementById('stockChart').getContext('2d');
            var stockChart = new Chart(ctxStock, {
                type: 'doughnut', // Specify the chart type
                data: {
                    labels: @json($stockLabels), // Use the data passed from the controller
                    datasets: [{
                        label: 'Stock Analysis',
                        data: @json($stockValues), // Use the data passed from the controller
                        backgroundColor: [
                            '#FF6384', // Red
                            '#36A2EB', // Blue
                            '#FFCE56', // Yellow
                            '#4BC0C0', // Teal
                            '#9966FF', // Purple
                            '#FF9F40', // Orange
                            '#C9CBCF'  // Grey
                        ],
                        borderColor: [
                            '#FFFFFF', // White border for better visibility
                            '#FFFFFF',
                            '#FFFFFF',
                            '#FFFFFF',
                            '#FFFFFF',
                            '#FFFFFF',
                            '#FFFFFF'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                font: {
                                    size: 14 // Increase the font size of legend labels
                                }
                            }
                        },
                        tooltip: {
                            enabled: true,
                            bodyFont: {
                                size: 14 // Increase the font size of tooltip labels
                            }
                        }
                    }
                }
            });
        });
    const salesConfig = {
        type: 'line',  // You can change this to 'bar' for a bar chart
        data: salesData,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    const salesChart = new Chart(
        document.getElementById('salesChart'),
        salesConfig
    );

    
</script>

@endsection
