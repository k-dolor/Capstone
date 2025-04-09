@extends('dashboard.body.main')

@section('container')
<div class="content">

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
 
    /* Hide elements for print */
    @media print {
        .no-print {
            display: none !important;
        }
    }

    /* Container for the buttons */
    .d-flex {
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    /* Smooth Transition Effects */
    .report-tab {
        background-color: #007BFF; /* Soft blue background */
        color: white;
        border-radius: 30px;
        padding: 12px 25px;
        font-size: 16px;
        margin: 8px;
        text-align: center;
        text-transform: uppercase; /* Make text all caps for uniformity */
        font-weight: 500; /* Slightly bolder text */
        transition: all 0.3s ease-in-out, box-shadow 0.2s ease, transform 0.2s ease; /* Added transitions */
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Add subtle shadow for depth */
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px; /* Space between icon and text */
    }

    /* Active tab (highlighted) */
    .report-tab.active {
        background-color: #012a57; /* Darker blue */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* Darker shadow on active */
    }

    /* Hover effect with animation */
    .report-tab:hover {
        background-color: #0056b3; /* Darker blue on hover */
        transform: translateY(-3px); /* Slightly raise the button */
        color: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* Deeper shadow on hover */
    }

    /* Adding icons styles */
    .report-tab i {
        font-size: 20px; /* Icon size */
        transition: transform 0.2s ease; /* Smooth icon transition */
    }

    .report-tab:hover i {
        transform: translateX(5px); /* Slight movement of the icon when hovering */
    }

    /* Flexbox layout for the buttons */
    .d-flex {
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    /* Card Layout for Content (optional if you want to apply to other parts of the page) */
    .card {
        border-radius: 12px;
        background-color: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Elevation effect */
        padding: 20px;
        margin: 15px;
    }

    /* General Button Style */
    .btn {
        font-family: 'Poppins', sans-serif;
        border-radius: 30px;
        padding: 12px 25px;
        font-size: 16px;
    }

    /* Button active color */
    .btn-primary {
        background-color: #0066cc;
        border: none;
    }

    /* Buttons hover effects */
    .btn:hover {
        opacity: 0.9;
        transform: translateY(-2px); /* Slight upward movement */
    }

    /* For mobile responsiveness */
    @media (max-width: 768px) {
        .report-tab {
            font-size: 14px; /* Smaller font size on mobile */
            padding: 10px 18px; /* Adjust padding */
        }

        .report-tab i {
            font-size: 18px; /* Slightly smaller icons for smaller screens */
        }
    }


    
</style>
@endsection  
