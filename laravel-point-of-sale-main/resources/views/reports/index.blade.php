@extends('dashboard.body.main')

@section('container') 
<div class="container">
    
    <h1 class="text-center mb-4 no-print" style="font-family: 'Poppins', sans-serif;">Reports & Analytics</h1>

    <!-- Tab Navigation -->
    <div class="d-flex justify-content-center mb-4">
        <a href="{{ route('reports.index') }}" class="btn report-tab active">Main Page</a>
        <a href="{{ route('reports.sales') }}" class="btn report-tab">Sales Report</a>
        <a href="{{ route('reports.stock') }}" class="btn report-tab">Stock Report</a>
        <a href="{{ route('reports.income') }}" class="btn report-tab ">Income Report</a>
        <a href="{{ route('reports.products') }}" class="btn report-tab">Products Report</a>
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

<style>
    .btn {
        font-family: 'Poppins', sans-serif;
        border-radius: 30px;
        padding: 10px 20px;
        font-size: 15px;
    }

    .card {
        border-radius: 10px;
        background-color: #f9f9f9;
    }

    h1, h5 {
        font-family: 'Poppins', sans-serif;
    }
    .report-tab {
        background-color: #1E90FF;
        color: white;
        border-radius: 30px;
        padding: 10px 20px;
        font-size: 15px;
        margin: 5px;
        transition: all 0.3s ease-in-out;
    }

    .report-tab:hover {
        background-color: #004080;
        color: white;
        transform: scale(1.05);
    }

    .report-tab.active {
        background-color: #003459;
    }


    
</style>
@endsection  
