@extends('dashboard.body.main')

@section('container') 
<div class="container">
    
    <h1 class="text-center mb-4" style="font-family: 'Poppins', sans-serif;">Reports & Analytics</h1>

    <!-- Tab Navigation -->
    <div class="d-flex justify-content-center mb-4">
        <a href="{{ route('reports.index') }}" class="btn mx-2" style="background-color: #FB8500; color: #ffffff; border: none;">Main Page</a> <!-- Powder Blue -->
        <a href="{{ route('reports.sales') }}" class="btn mx-2" style="background-color: #B0E0E6; color: #000; border: none;">Sales Report</a> <!-- Light Sky Blue -->
        <a href="{{ route('reports.stock') }}" class="btn mx-2" style="background-color: #4682B4; color: #fff; border: none;">Stock Report</a> <!-- Steel Blue -->
        <a href="{{ route('reports.income') }}" class="btn mx-2" style="background-color: #1E90FF; color: #fff; border: none;">Income Report</a> <!-- Dodger Blue -->
        <a href="{{ route('reports.products') }}" class="btn mx-2" style="background-color: #003459; color: #fff; border: none;">Products Report</a> <!-- Dark Blue -->
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
</style>
@endsection  
