@extends('dashboard.body.main')

@section('container')

<style>
        /* Import a clean, modern font */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');


    h1 {
        font-size: 2.5rem;
        font-weight: 600;
        color: #1e1e2f;
    }
    /* Tab Button Base */
    .report-tab {
        margin: 0.5rem;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        color: #1e1e2f;
        font-weight: 500;
        font-size: 1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    /* Hover & Active State */
    .report-tab:hover,
    .report-tab.active {
        background-color: #1e1e2f;
        color: #fff;
        font-weight: 600;
    }

    /* Responsive Flex Wrap Handling */
    @media (max-width: 768px) {
        .report-tab {
            flex: 1 1 100%;
            justify-content: center;
        }
    }

</style>

<div class="container">

    <h1 class="text-center mb-4 no-print" style="font-family: 'Poppins', sans-serif;">Reports & Analytics</h1>

    <!-- Tab Navigation -->
    <div class="d-flex justify-content-center mb-4 flex-wrap">
        <a href="{{ route('reports.index') }}" class="btn report-tab active no-print">
            <i class="fas fa-home"></i> Main Page
        </a>
        <a href="{{ route('reports.sales') }}" class="btn report-tab no-print">
            <i class="fas fa-chart-line"></i> Sales Report
        </a>
        <a href="{{ route('reports.stock') }}" class="btn report-tab no-print">
            <i class="fas fa-box"></i> Stock Report <!-- Changed to fa-box -->
        </a>
        <a href="{{ route('reports.income') }}" class="btn report-tab no-print">
            <i class="fas fa-dollar-sign"></i> Income Report
        </a>
        <a href="{{ route('reports.products') }}" class="btn report-tab no-print">
            <i class="fas fa-box-open"></i> Products Report <!-- Changed to fa-box-open -->
        </a>
    </div>
        <!-- Charts Section -->
<div class="row">
    <div class="col-md-6">
        <div class="card p-3 shadow">
            <h5 class="text-center">This Month ({{ now()->format('F Y') }})</h5>
            <canvas id="thisMonthChart"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-3 shadow">
            <h5 class="text-center">Last Month ({{ now()->subMonth()->format('F Y') }})</h5>
            <canvas id="lastMonthChart"></canvas>
        </div>
    </div>
</div>
 <!-- Pie Chart for Total Sales Per Product -->
 <div class="row mt-4">
    <div class="col-md-6">
        <div class="card p-3 shadow">
            <h5 class="text-center">Total Sales Per Product</h5>
            <canvas id="salesPieChart"></canvas>
        </div>
    </div>

        <!-- Bar Chart for Monthly Sales Per Product -->
        <div class="col-md-6">
            <div class="card p-3 shadow">
                <h5 class="text-center">Monthly Sales Per Product</h5>
                <canvas id="monthlySalesBarChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Fetch product sales data from Blade (this month)
            let productNames = @json($thisMonthSales->pluck('product_name'));
            let productSales = @json($thisMonthSales->pluck('total_sales'));

            // Pie Chart for Total Sales Per Product (This Month)
            const ctxPieChart = document.getElementById('salesPieChart').getContext('2d');
            new Chart(ctxPieChart, {
                type: 'pie',
                data: {
                    labels: productNames,
                    datasets: [{
                        label: 'Total Sales per Product',
                        data: productSales,
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4CAF50', '#FF9F40', '#9966FF'],
                        hoverOffset: 4
                    }]
                },
                options: { responsive: true }
            });

            // This Month Chart - Data dynamically loaded
            let thisMonthProductNames = @json($thisMonthSales->pluck('product_name'));
            let thisMonthSalesData = @json($thisMonthSales->pluck('total_sales'));

            const ctxThisMonth = document.getElementById('thisMonthChart').getContext('2d');
            new Chart(ctxThisMonth, {
                type: 'pie',
                data: {
                    labels: thisMonthProductNames,
                    datasets: [{
                        label: 'This Month',
                        data: thisMonthSalesData,
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4CAF50', '#FF9F40', '#9966FF'],
                    }]
                }
            });

            // Last Month Chart - Data dynamically loaded
            let lastMonthProductNames = @json($lastMonthSales->pluck('product_name'));
            let lastMonthSalesData = @json($lastMonthSales->pluck('total_sales'));

            const ctxLastMonth = document.getElementById('lastMonthChart').getContext('2d');
            new Chart(ctxLastMonth, {
                type: 'pie',
                data: {
                    labels: lastMonthProductNames,
                    datasets: [{
                        label: 'Last Month',
                        data: lastMonthSalesData,
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4CAF50', '#FF9F40', '#9966FF'],
                    }]
                }
            });

            // Monthly Sales Bar Chart - Data dynamically loaded
            let months = @json($monthlySales->pluck('month'));
            let monthlySalesData = @json($monthlySales->map(function($sale) {
                return $sale->total_sales;
            }));

            const ctxBarChart = document.getElementById('monthlySalesBarChart').getContext('2d');
            new Chart(ctxBarChart, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Monthly Total Sales',
                        data: monthlySalesData,
                        backgroundColor: '#36A2EB'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        });
    </script>
    



@endsection