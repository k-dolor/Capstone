@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <!-- Success Alert -->
    @if (session()->has('success'))
        <div class="alert text-white bg-success" role="alert">
            <div class="iq-alert-text">{{ session('success') }}</div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="ri-close-line"></i>
            </button>
        </div>
    @endif

    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card card-transparent card-stretch card-height border-none">
                <div class="card-body p-4">
                    <h3 class="mb-2">Good Day, {{ auth()->user()->name }}</h3>
                    <p class="mb-0">Welcome to L&N Supply Management System.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Metrics Section -->
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card card-block card-stretch card-height">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon iq-icon-box-2 bg-info-light">
                            <img src="../assets/images/product/1.png" class="img-fluid" alt="Total Paid">
                        </div>
                        <div class="ml-3">
                            <p class="mb-2">Sales</p>
                            <h4>₱ {{ $total_paid }}</h4>
                        </div>
                    </div>
                    <div class="iq-progress-bar mt-2">
                        <span class="bg-info iq-progress progress-1" data-percent="85"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card card-block card-stretch card-height">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon iq-icon-box-2 bg-danger-light">
                            <img src="../assets/images/product/2.png" class="img-fluid" alt="Total Due">
                        </div>
                        <div class="ml-3">
                            <p class="mb-2">Total Due</p>
                            <h4>₱ {{ $total_due }}</h4>
                        </div>
                    </div>
                    <div class="iq-progress-bar mt-2">
                        <span class="bg-danger iq-progress progress-1" data-percent="70"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card card-block card-stretch card-height">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon iq-icon-box-2 bg-success-light">
                            <img src="../assets/images/product/3.png" class="img-fluid" alt="Complete Orders">
                        </div>
                        <div class="ml-3">
                            <p class="mb-2">Complete Orders</p>
                            <h4>{{ count($complete_orders) }}</h4>
                        </div>
                    </div>
                    <div class="iq-progress-bar mt-2">
                        <span class="bg-success iq-progress progress-1" data-percent="75"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        {{-- <!-- Revenue Vs Cost Chart -->
        <div class="col-lg-6 mb-4">
            <div class="card card-block card-stretch card-height">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Revenue Vs Cost</h4>
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton002" data-toggle="dropdown">
                            This Month <i class="ri-arrow-down-s-line ml-1"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton002">
                            <a class="dropdown-item" href="#">Yearly</a>
                            <a class="dropdown-item" href="#">Monthly</a>
                            <a class="dropdown-item" href="#">Weekly</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="layout1-chart-2" style="min-height: 360px;"></div>
                </div>
            </div>
        </div> --}}

      <!-- Total Sales by Month Chart -->
       <div class="col-lg-6 mb-4">
        <div class="card card-block card-stretch card-height">
            <div class="card-header">
                <h4 class="card-title">Total Sales </h4>
            </div>
            <div class="card-body">
                <canvas id="salesChart" width="400" height="200"></canvas>
            </div>
        </div>
     </div>


        <!-- Stock Analysis Chart -->
        <div class="col-lg-6 mb-4">
            <div class="card card-block card-stretch card-height">
                <div class="card-header">
                    <h4 class="card-title">Stock Analysis</h4>
                </div>
                <div class="card-body">
                    <canvas id="stockChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
 </div>

    <!-- Top Products Section -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card card-block card-stretch card-height">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Top Products</h4>
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton006" data-toggle="dropdown">
                            This Month <i class="ri-arrow-down-s-line ml-1"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton006">
                            <a class="dropdown-item" href="#">Year</a>
                            <a class="dropdown-item" href="#">Month</a>
                            <a class="dropdown-item" href="#">Week</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled row">
                        @foreach ($products as $product)
                            <li class="col-lg-3 mb-3">
                                <div class="card card-block card-stretch card-height">
                                    <div class="card-body text-center">
                                        <div class="bg-warning-light rounded p-3">
                                            <img src="{{ $product->product_image ? asset('storage/products/'.$product->product_image) : asset('assets/images/product/default.webp') }}" class="img-fluid" alt="{{ $product->product_name }}">

                                        </div>
                                        <div class="mt-3">
                                            <h5 class="mb-1">{{ $product->product_name }}</h5>
                                            <p class="mb-0">{{ $product->product_store }} Item</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- New Products Section -->
        <div class="col-lg-4">
            <div class="card card-block card-stretch card-height">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">New Products</h4>
                    <a href="#" class="btn btn-primary">View All</a>
                </div>
                <div class="card-body">
                    @foreach ($new_products as $product)
                        <div class="card card-block card-stretch mb-3">
                            <div class="card-body d-flex align-items-start">
                                <div class="bg-warning-light rounded p-2">
                                    <img src="{{ $product->product_image ? asset('storage/products/'.$product->product_image) : asset('assets/images/product/default.webp') }}" class="img-fluid" alt="{{ $product->product_name }}">
                                </div>
                                <div class="ml-3">
                                    <h5 class="mb-2">{{ $product->product_name }}</h5>
                                    <p class="mb-2">Stock: {{ $product->product_store }}</p>
                                    <p class="mb-0">Price: ₱{{ $product->selling_price }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
    const stockLabels = @json($labels);
    const stockData = {
        labels: stockLabels,
        datasets: [{
            label: 'Stock Quantity',
             data: @json($data),
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',  // Red
                'rgba(54, 162, 235, 0.2)',  // Blue
                'rgba(255, 206, 86, 0.2)',  // Yellow
                'rgba(75, 192, 192, 0.2)',  // Teal
                'rgba(153, 102, 255, 0.2)', // Purple
                'rgba(255, 159, 64, 0.2)'   // Orange
                // Add more colors if needed based on the number of products
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',  // Red
                'rgba(54, 162, 235, 1)',  // Blue
                'rgba(255, 206, 86, 1)',  // Yellow
                'rgba(75, 192, 192, 1)',  // Teal
                'rgba(153, 102, 255, 1)', // Purple
                'rgba(255, 159, 64, 1)'   // Orange
                // Match the border colors to the background colors
            ],
            borderWidth: 1
        }]
    };

    const stockConfig = {
        type: 'bar',
        data: stockData,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    const stockChart = new Chart(
        document.getElementById('stockChart'),
        stockConfig
    );

    const salesLabels = @json($salesLabels);
    const salesData = {
        labels: salesLabels,
        datasets: [{
            label: 'Total Sales',
            data: @json($salesData),
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',  // Red
                'rgba(54, 162, 235, 0.2)',  // Blue
                'rgba(255, 206, 86, 0.2)',  // Yellow
                'rgba(75, 192, 192, 0.2)',  // Teal
                'rgba(153, 102, 255, 0.2)', // Purple
                'rgba(255, 159, 64, 0.2)',  // Orange
                'rgba(153, 51, 102, 0.2)'   // Magenta
                // Add more colors if needed based on the number of products
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',  // Red
                'rgba(54, 162, 235, 1)',  // Blue
                'rgba(255, 206, 86, 1)',  // Yellow
                'rgba(75, 192, 192, 1)',  // Teal
                'rgba(153, 102, 255, 1)', // Purple
                'rgba(255, 159, 64, 1)',   // Orange
                'rgba(153, 51, 102, 1)'   // magentaa
                // Match the border colors to the background colors
            ],
            borderWidth: 1
        }]
    };

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
